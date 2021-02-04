@extends('layouts.app')
@section('content')
    <?php
    use Jenssegers\Agent\Agent;

    $agent = new Agent();
    ?>
    <div id="divInfo" class="alert alert-success alert-dismissible position-fixed invisible" style="right: 0; top: 10px;">
        Код стола данного пользователя скопирован
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-5 mb-3">
                <div class="border p-2 shadow-sm">
                    @if($agent->isMobile())
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Ставка:</span><span
                                class="text-muted">{{ $desk->program->cost }} $</span></p>
                        <p class="justify-content-between d-flex"><span
                                class="font-weight-bold">Сумма выплаты:</span><span
                                class="text-muted">{{ $desk->program->amount_payment }} $</span></p>
                        <p class="justify-content-between d-flex"><span
                                class="font-weight-bold">Дата открытия стола:</span><span
                                class="text-muted">{{ $desk->created_at->format('d.m.y G:i') }}</span></p>
                    @elseif($agent->isDesktop())
                        <div class="row p-2">
                            <div class="col-6 border-right">
                                <p class="font-weight-bold">Ставка:</p>
                                <p class="font-weight-bold">Сумма выплаты:</p>
                                <p class="font-weight-bold">Дата открытия стола:</p>
                            </div>
                            <div class="col-6 border-left">
                                <p class="text-muted">{{ $desk->program->cost }} $</p>
                                <p class="text-muted">{{ $desk->program->amount_payment }} $</p>
                                <p class="text-muted">{{ $desk->created_at->format('d.m.y G:i') }}</p>
                            </div>
                            <div class="form-group" id="note">
                                <button class="btn btn-secondary mb-3" id="copy_btn">Скопировать ссыклу</button>
                                <input class="form-control" id="linkEvent" type="text" readonly>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if($agent->isMobile())
                <div class="p-2 d-flex mb-4">
                    <div class="treeview treeview-primary" data-mdb-accordion="true"
                         tabindex="0">
                        <ul role="tree">
                            <li class="" aria-level="1" role="tree-item" tabindex="-1">
                                    <a  class="treeview-category rotate"
                                        data-mdb-toggle="collapse"
                                        data-mdb-target="#level-913004" role="button"
                                        tabindex="-1" aria-expanded="true"><span
                                            aria-label="toggle"><i class="fas fa-angle-right rotate mx-1"></i>{{ $desk->user->name }}</span>

                                    </a>
                                <ul class="collapse " id="level-913004"
                                    role="group" style="">
                                    @foreach($desk->users as $value)
                                        @if($value->is_active)
                                            <li aria-level="2" role="tree-item"
                                                class="treeview-category"
                                                tabindex="-2">
                                                    <a class="treeview-category rotate"
                                                       data-mdb-toggle="collapse"
                                                       data-mdb-target="#level-{{$value->id}}" role="button"
                                                       tabindex="-2" aria-expanded="true"><span
                                                            aria-label="toggle"><i
                                                                class="fas fa-angle-right rotate mx-1"></i></span>{{ $value->name }}
                                                    </a>

                                                <ul class="collapse "
                                                    id="level-{{$value->id}}" role="group"
                                                    style="">
                                                    @foreach($value->children as $item)
                                                        @if($item->is_active)
                                                            <li aria-level="3" role="tree-item"
                                                                class="treeview-category" tabindex="-1">
                                                                {{ $item->name }}

                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            @elseif($agent->isDesktop())

                <div class="col-12">
                    <div class="body genealogy-body genealogy-scroll d-flex justify-content-center">
                        <div class="genealogy-tree">
                            <ul>
                                <li>

                                    <a href="">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="{{ asset('img/owner.svg') }}"
                                                     alt="Member">
                                                <div class="member-details ">
                                                    <h6 class="pt-2"
                                                        style="white-space: normal;">{{ $desk->user->name }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="active">
                                        @foreach($desk->users as $user)
                                            @if($user->is_active)
                                                <li>
                                                    <a  title="Скопировать ссылку стола" class="desk_code" onclick="copyToClipboard(this)"  data-desk="{{ $user->owners->filter(function ($q) use ($desk) {
                                                        return $q->parent_id === $desk->id;
                                                    })->first()->code }}">
                                                        <div class="member-view-box" >
                                                            <div class="member-image">
                                                                <img
                                                                    src="{{ asset('img/person.svg') }}"
                                                                    alt="Member">
                                                                <div class="member-details ">
                                                                    <h6 class="pt-2"
                                                                        style="white-space: normal;">{{ $user->name }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <ul class="active">
                                                        @foreach($user->children as $item)
                                                            @if($item->is_active)
                                                                <li>
                                                                    <a  title="Скопировать ссылку стола" onclick="copyToClipboard(this)" class="desk_code">
                                                                        <div class="member-view-box">
                                                                            <div class="member-image">
                                                                                <img
                                                                                    src="{{ asset('img/person.svg') }}"
                                                                                    alt="Member">
                                                                                <div class="member-details ">
                                                                                    <h6 class="pt-2"
                                                                                        style="white-space: normal;">{{ $item->name }}</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .treeview {
            width: 100%;
        }

        .treeview ul {
            /*margin-left: .8rem;*/
            padding-left: .8rem;
        }

        .treeview-primary .active {
            color: #1266f1 !important;
        }

        .treeview-category:hover, .treeview-primary .active {
            background-color: rgba(18, 102, 241, .05);
        }

        .treeview .active, .treeview .treeview-category {
            padding: 0 .4rem;
            border-radius: 5px;
        }

        .treeview li {
            list-style-type: none;
            margin: 3px 0;
        }

        .treeview a[data-mdb-toggle=collapse] {
            color: unset;
        }

        .treeview .active, .treeview .treeview-category {
            padding: 0 .4rem;
            border-radius: 5px;
        }

        .treeview a {
            color: #4f4f4f;
            display: block;
        }

        [role=button] {
            cursor: pointer;
        }

        .treeview span[aria-label=toggle] i {
            -webkit-transition: .3s;
            transition: .3s;
            cursor: pointer;
        }

        .fa-angle-right:before {
            content: "\f105";
        }

        [tabindex="-1"]:focus:not(:focus-visible) {
            outline: 0 !important;
        }

        .treeview span[aria-label=toggle] i {
            -webkit-transition: .3s;
            transition: .3s;
            cursor: pointer;
        }

        .treeview a[data-mdb-toggle=collapse] {
            color: unset;
        }

        .treeview-primary .active {
            color: #1266f1 !important;
        }

        .collapse:not(.show) {
            display: none;
        }

        .treeview-primary .active {
            color: #1266f1 !important;
        }

        .treeview-category:hover, .treeview-primary .active {
            background-color: rgba(18, 102, 241, .05);
        }

        .treeview .active, .treeview .treeview-category {
            padding: 0 .4rem;
            border-radius: 5px;
        }

        .treeview a {
            color: #4f4f4f;
            display: block;
        }

        .treeview-animated .treeview-animated-list .treeview-animated-items .closed .fa-angle-right.down {
            position: relative;
            color: #f8f9fa;
            -webkit-transform: rotate(
                90deg
            );
            transform: rotate(
                90deg
            );
        }

        .treeview-animated .treeview-animated-list .treeview-animated-items .closed .fa-angle-right {
            font-size: .8rem;
            -webkit-transition: all .1s linear;
            transition: all .1s linear;
        }

        .treeview-primary a:focus, .treeview-primary li:focus {
            outline: none;
            background-color: rgba(18, 102, 241, .05);
        }
        .treeview .rotate{
            font-size: 1rem!important;
        }

        .rotate {
            -moz-transition: all .3s linear;
            -webkit-transition: all .3s linear;
            transition: all .3s linear;
        }

        .rotate.down {
            -moz-transform: rotate(90deg);
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }
        .fa, .fas {
            font-weight: 900;
        }

    </style>
@endpush
@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.2.0/mdb.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/js/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(".rotate").click(function () {
            $(this).children().children().toggleClass('down');
        });
    </script>

    <script>
        $(document).ready(function () {

            if ('1' === '{{ $desk->is_closed }}') {
                $('#linkEvent').remove();
                $('#copy_btn').remove();
            } else if ('0' === '{{ $desk->is_active }}') {
                let span = '<span class="text-danger">Примечание: стол находится на рассмотрении или ожидает оплаты!</span>';
                $('#linkEvent').remove();
                $('#copy_btn').remove();
                $('#note').html(span);
            } else if ('{{ $desk->users->count() }}' === '3') {
                let span = '<span class="text-danger">Примечание: Вы больше не можете приглашать новых пользователей!</span>';
                $('#linkEvent').remove();
                $('#copy_btn').remove();
                $('#note').html(span);
            } else {
                $('#linkEvent').val(window.location.hostname + '/register/{{ $desk->code }}');
                $('#copy_btn').click(function () {
                    copyToClipboard(document.getElementById("linkEvent"));
                });
            }
        });

        function copyToClipboard(elem) {
            let origSelectionStart, origSelectionEnd;
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
            let currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);
            document.execCommand("copy");
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        }


        function copyToClipboard(element) {
            console.log(element.getAttribute("data-desk"))
            let $temp = $("<input>");
            $("body").append($temp);
            $temp.val(window.location.hostname + '/register/' + $(element).data("desk")).select();
            document.execCommand("copy");
            $temp.remove();


            $('#divInfo').removeClass('invisible');
            setTimeout(function () {

                $('#divInfo').addClass('invisible');

            }, 3000);
        }


    </script>


@endpush
