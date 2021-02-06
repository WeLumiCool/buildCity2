<?php

namespace App\Http\Controllers;

use App\Desk;
use App\Mail\DeskCity;
use App\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Telegram\Bot\Api;

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
        if (Auth::user()->role == 1)
        {
            Desk::public_store($id, $user_id, $active = true, 0);
        }
        else{

            $desk = Desk::public_store($id, $user_id, $active = false, 0);
            $telegram = new Api('1511098073:AAHi-7hA7JkRoQYWL71KVEwcmDLBjDr7MDY');
            $text = "Создан новый стол!\nИмя владельца: " . $desk->user->name . ",\nКод стола: " . $desk->code ."";
            $telegram->sendMessage(['chat_id' => '422483386', 'text' => $text]);

        }
        return redirect()->route('cabinet');
    }

    public function change_desk(Request $request)
    {
        $from_desk = Desk::find($request->from_desk);
        $from_desk->balance = $from_desk->balance - $from_desk->program->cost;
        $to_desk = Desk::find($request->to_desk);
        $to_desk->balance = $to_desk->balance + $to_desk->program->cost;
        $from_desk->users()->detach($request->user);
        $to_desk->users()->attach($request->user);
        $counter = 0;
        foreach ($to_desk->users as $user) {
            if ($user->is_active)
                $counter++;
        }
        if ($counter > 5) {
            $to_desk->is_closed = true;
        }
        $to_desk->save();
        $from_desk->save();
        return redirect()->route('admin.desks.index');
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
        if ($desk->users->count() == 3) {
            return response()->json(false);
        }
        if ($desk->is_active == false) {
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

    public function replaceShow()
    {
        $desks = Desk::where('is_closed', false)->
            where('is_active', true)
            ->get();
        $desks->map(function ($desk) {
            $result_array = [];
            foreach ($desk->users as $user) {
                if ($user->is_active == true) {
                    $result_array[] = $user;
                }
            }
            $desk['active_user'] = $result_array;
            return $desk;
        });
//        dd($desks);
        return view('admin.desks.replace', compact('desks'));
    }

    public function closeDesk($id)
    {
        $desk = Desk::find($id);
        $desk->is_closed = true;
        $desk->save();
        return redirect()->route('admin.desks.index');
    }

    public function get_users(Request $request)
    {
        $users = [];
        foreach (Desk::find($request->id)->users as $user) {
            if ($user->is_active) {
                $users[] = $user;
            }
        }
        return response()->json(['users' => $users]);
    }

    public function datatableData()
    {
        $desks = Desk::where('is_active', false)->get();
        return DataTables::of($desks)
            ->editColumn('user_id', function (Desk $desk) {
                $name = str_replace(' ', '<br>', $desk->user->name);
                return $name;
            })
            ->editColumn('balance',function (Desk $desk){
                return $desk->balance.' $';
            })
            ->addColumn('cost', function (Desk $desk) {
                return $desk->program->cost.' $';
            })
            ->addColumn('Teilnehmers', function (Desk $desk) {
                $counter_active_users = 0;
                foreach ($desk->users as $user) {
                    if ($user->is_active) {
                        $counter_active_users++;
                    }
                }
                if (!$counter_active_users) {
                    return 'Отсутствуют';
                } else {
                    $html_text = '<ul>';
                    foreach ($desk->users as $user) {
                        if ($user->is_active) {
                            $html_text .= '<li>' . $user->name . '</li>';
                        }
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
                if (!$desk->is_closed) {
                    return '<a class="btn btn-success ml-1" href="' . route('admin.desks.show', $desk->id) . '"><i class="fas fa-eye"></i></a>' .
                        '<button class="close_desk btn btn-danger ml-1" data-id="' . $desk->id . '"><i class="fas fa-external-link-alt"></i></button>';
                } else {
                    return '<a class="btn btn-success ml-1" href="' . route('admin.desks.show', $desk->id) . '"><i class="fas fa-eye"></i></a>';
                }
            })
            ->rawColumns(['Teilnehmers', 'is_closed', 'actions', 'user_id'])
            ->make(true);
    }


    public function activated()
    {

        return view('admin.desks.activated');
    }
    public function active_datatable()
    {
        $desks = Desk::where('is_active', true)->get();
        return DataTables::of($desks)
            ->editColumn('user_id', function (Desk $desk) {
                $name = str_replace(' ', '<br>', $desk->user->name);
                return $name;
            })
            ->editColumn('balance',function (Desk $desk){
                return $desk->balance.' $';
            })
            ->addColumn('cost', function (Desk $desk) {
                return $desk->program->cost.' $';
            })
            ->addColumn('Teilnehmers', function (Desk $desk) {
                $counter_active_users = 0;
                foreach ($desk->users as $user) {
                    if ($user->is_active) {
                        $counter_active_users++;
                    }
                }
                if (!$counter_active_users) {
                    return 'Отсутствуют';
                } else {
                    $html_text = '<ul>';
                    foreach ($desk->users as $user) {
                        if ($user->is_active) {
                            $html_text .= '<li>' . $user->name . '</li>';
                        }
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
                if (!$desk->is_closed) {
                    return '<a class="btn btn-success ml-1" href="' . route('admin.desks.show', $desk->id) . '"><i class="fas fa-eye"></i></a>' .
                        '<button class="close_desk btn btn-danger ml-1" data-id="' . $desk->id . '"><i class="fas fa-external-link-alt"></i></button>';
                } else {
                    return '<a class="btn btn-success ml-1" href="' . route('admin.desks.show', $desk->id) . '"><i class="fas fa-eye"></i></a>';
                }
            })
            ->rawColumns(['Teilnehmers', 'is_closed', 'actions', 'user_id'])
            ->make(true);
    }

    public function activation(Request $request)
    {
        $desk = Desk::find($request->id);
        $desk->is_active = true;
        $desk->save();
        $details =[
            'owner' => $desk->user->name,
            'desk' => $desk->code,
        ];
        Mail::to($desk->user->email)->send(new DeskCity($details));


    }
}
