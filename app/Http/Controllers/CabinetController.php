<?php

namespace App\Http\Controllers;

use App\Desk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CabinetController extends Controller
{
    public function get_page()
    {
        return view('public.cabinet');
    }

    public function datatableData()
    {
        $desks = Desk::where('user_id', Auth::user()->id)->orderBy('is_closed')->get();
        return DataTables::of($desks)
            ->addColumn('copy_btn', function (Desk $desk){
                return '<button class="btn"><i class="fas fa-copy"></i></button>';
            })
            ->editColumn('user_id', function (Desk $desk) {
                return $desk->user->name;
            })
            ->editColumn('cost', function (Desk $desk) {
                return $desk->program->cost;
            })
            ->addColumn('closing_amount', function (Desk $desk) {
                return $desk->program->closing_amount;
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
            ->rawColumns(['Teilnehmers', 'is_closed','copy_btn'])
            ->make(true);
    }
}
