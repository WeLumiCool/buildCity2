@extends('admin.layouts.dashboard')
@section('dashboard_content')
    <div class="container bg-form card-body-admin py-4">
        <div class="row p-4 " id="show_articles">
            <div class="col-2">id</div>
            <div class="col-10">{{ $desk->id }}</div>
            <div class="col-2">Заголовок:</div>
            <div class="col-10">{{ $desk->balance }}</div>

        </div>

        <div class="tf-tree tf-gap-lg">
            <ul>
                <li>
                    <span class="tf-nc rounded">Жусуев Азрет</span>
                    <ul>
                        <li>
                            <span class="tf-nc rounded">Лумаза Дамир</span>
                            <ul>
                                <li><span class="tf-nc rounded">Мухамметрахимов Хусан</span></li>
                                <li><span class="tf-nc rounded">Наспеков Эркин</span></li>
                            </ul>
                        </li>
                        <li>
                            <span class="tf-nc rounded">Байбориев НУрсултан</span>
                            <ul>
                                <li><span class="tf-nc rounded">Байбориев НУрсултан</span></li>
                                <li><span class="tf-nc rounded">Наспеков Эркин</span></li>
                            </ul>
                        </li>
                        <li>
                            <span class="tf-nc rounded">Байбориев НУрсултан</span>
                        </li>
                        <li>
                            <span class="tf-nc rounded">Байбориев НУрсултан</span>
                        </li>
                        <li>
                            <span class="tf-nc rounded">Байбориев НУрсултан</span>
                        </li>
                        <li>
                            <span class="tf-nc rounded">Байбориев НУрсултан</span>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/treeflex/dist/css/treeflex.css">
    <style>
        #show_articles .col-2, #show_articles .col-10 {
            padding-top: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #dcdcdd;
        }
        #show_articles .col-2 {
            border-right: 1px solid #dcdcdd;
        }
        .tf-tree li li:before {
            border-top: .0625em solid forestgreen !important;
        }
        .tf-tree .tf-nc:after, .tf-tree .tf-nc:before, .tf-tree .tf-node-content:after, .tf-tree .tf-node-content:before {
            border-left: .0625em solid forestgreen !important;
        }
    </style>
@endpush
