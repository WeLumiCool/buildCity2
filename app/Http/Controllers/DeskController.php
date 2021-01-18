<?php

namespace App\Http\Controllers;

use App\Build;
use App\Desk;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
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

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
