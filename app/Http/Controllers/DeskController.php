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
        return view('public.showDesk', compact('id'));
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
        return response()->json(Desk::where('code', $request->code)->exists());
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
