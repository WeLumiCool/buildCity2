<?php

namespace App\Http\Controllers;

use App\Desk;
use App\Mail\BuildCityMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $user = User::create($request->all());
        $user->role = $request->exists('is_admin');
        $user->is_active = true;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $desks = Desk::where('is_closed', false)->get();
        return view('admin.users.show', compact('user', 'desks'));
    }


    public function activation(Request $request)
    {
        $user = User::find($request->id);
        $admin = User::where('role', 1)->first();
        Mail::to($user->email)->send(new BuildCityMail());
        $user->is_active = true;
        $user->save();
        foreach ($user->desks as $desk) {
            if ($desk->users->count() == 1) {
                $user->parent->balance += $desk->program->cost;
                $user->parent->save();
            }
            else {
                if ($desk->parent == null) {
                    $admin->balance += $desk->program->cost;
                    $admin->save();
                }
                else{
                    $desk->parent->balance += $desk->program->cost;
                    $desk->parent->save();
                }
            }
            if ($desk->parent->balance == $desk->program->closing_amount) {
                $desk->parent->is_closed = true;
                $desk->parent->save();
                $user = $desk->parent->user;
                if ($user->role == 1) {
                    $admin->balance += $desk->program->closing_amount;
                    $admin->save();
                }
                else{
                    $user->balance += ($desk->program->closing_amount - $desk->program->cost);
                    $user->save();
                    $admin->balance += $desk->program->cost;
                    $admin->save();
                }
            }
            $desk->save();
            Desk::public_store($desk->program->id, $user->id, $active = true, $desk->id);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        //
    }

    public function profile()
    {
        return view('public.profile');
    }

    public function change_profile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'max:25', Rule::unique('users')->ignore($user->id)],
            'password' => ['confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->current_password != null) {
            if ($user->password == Hash::make($request->current_password)) {
                $user->password = Hash::make($request->password);
            } else {
                return back()->withInput()->withErrors(['current_password' => ['Пароль не верен']]);
            }
        }
        $user->save();
        return redirect()->route('cabinet');
    }

    public function wait()
    {
        return view('public.wait');
    }

    public function datatableData()
    {

        return DataTables::of(User::query())
            ->addColumn('actions', function (User $user) {
                return view('admin.actions', ['type' => 'users', 'model' => $user]);
            })
            ->editColumn('is_active', function (User $user) {
                if ($user->is_active) {
                    return 'Да';
                } else {
                    return 'Нет';
                }
            })
            ->make(true);
    }
}
