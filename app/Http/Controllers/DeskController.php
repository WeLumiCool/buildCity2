<?php

namespace App\Http\Controllers;

use App\Desk;
use App\Program;
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
        $desk = new Desk();
        $desk->program_id = $request->program_id;
        $desk->user_id = Auth::user()->id;
        $desk->balance = '0';
        $desk->code = self::get_code();
        $desk->save();
        return redirect()->route('cabinet');
    }

    public static function get_code()
    {
        $str = '';
        for ($i = 0; $i < 6; $i++) {
            $str .= rand(0, 9);
        }
        return $str;
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

    public function datatableData()
    {
        return DataTables::of(Desk::query())
            ->addColumn('actions', function (Desk $desk) {
                return view('admin.actions', ['type' => 'desks', 'model' => $desk]);
            })
            ->make(true);
    }
}
