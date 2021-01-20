<?php

namespace App\Http\Controllers;

use App\Desk;
use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.desks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Desk $desk
     * @return \Illuminate\Http\Response
     */
    public function show(Desk $desk)
    {
        return view('admin.desks.show', compact('desk'));
    }

    public function publicShow($id)
    {
        $desk = Desk::find($id);
        return view('public.showDesk', compact('desk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function public_create()
    {
        $programs = Program::all();
        return view('public.create_desk', compact('programs'));
    }

    public function public_store(Request $request)
    {
        $id = $request->program_id;
        $user_id = Auth::user()->id;
        Desk::public_store($id, $user_id);
        return redirect()->route('cabinet');
    }

    public function change_desk(Request $request)
    {
        $desk = Desk::find($request->desk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function checkExistCode(Request $request)
    {

        $desk = Desk::where('code', $request->code)->first();
        if (!$desk) {
            return response()->json(false);
        }
        if ($desk->is_closed) {
            return response()->json(false);
        }
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function closeDesk($id)
    {
        $desk = Desk::find($id);
        $desk->is_closed = true;
        $desk->save();
        return redirect()->route('admin.desks.index');
    }

    public function datatableData()
    {
        return DataTables::of(Desk::query())
            ->editColumn('user_id', function (Desk $desk) {
                return $desk->user->name;
            })
            ->addColumn('cost', function (Desk $desk) {
                return $desk->program->cost;
            })
            ->addColumn('Teilnehmers', function (Desk $desk) {
                if (!$desk->users->count()) {
                    return 'Отсутствуют';
                } else {
                    $html_text = '<ul>';
                    foreach ($desk->users as $user) {
                        $html_text .= '<li>' . $user->name . '</li>';
                    }
                    $html_text .= '</ul>';
                    return $html_text;
                }
            })
            ->editColumn('is_closed', function (Desk $desk) {
                if (!$desk->is_closed) {
                    return 'Открытый';
                } else {
                    return 'Закрытый';
                }
            })
            ->editColumn('created_at', function (Desk $desk) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $desk->created_at)->format('d-m-Y');
            })
            ->addColumn('actions', function (Desk $desk) {
                return '<a class="btn btn-danger ml-1" href="' . route('admin.close.desk', $desk->id) . '"><i class="fas fa-door-closed"></i></a>';
            })
            ->rawColumns(['Teilnehmers', 'is_closed','actions'])
            ->make(true);
    }
}
