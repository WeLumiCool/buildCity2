@extends('admin.layouts.dashboard')
@section('dashboard_content')
    <?php
    use Jenssegers\Agent\Agent;

    $agent = new Agent();
    ?>
    <div class="container bg-form card-body-admin py-4">
        <div class="row justify-content-center" id="show_articles">
            <div class="col-12 col-lg-7 mb-5">
                <div class="border p-2 shadow-sm">
                    @if($agent->isMobile())
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">ФИО:</span><span
                                class="text-muted">{{ $user->name }}</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Почта:</span><span
                                class="text-muted">{{ $user->email }}</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Телефон:</span><span
                                class="text-muted">{{ $user->phone }}</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Баланс:</span><span
                                class="text-muted">{{ $user->balance }} $</span></p>
                    @elseif($agent->isDesktop())
                        <div class="row p-2">
                            <div class="col-6 border-right">
                                <p class="font-weight-bold">ФИО:</p>
                                <p class="font-weight-bold">Почта:</p>
                                <p class="font-weight-bold">Телефон:</p>
                                <p class="font-weight-bold">Баланс:</p>
                            </div>
                            <div class="col-6 border-left">
                                <p class="text-muted">{{ $user->name }} </p>
                                <p class="text-muted">{{ $user->email }} </p>
                                <p class="text-muted">{{ $user->phone }} </p>
                                <p class="text-muted">{{ $user->balance }} $</p>


                            </div>
                        </div>
                    @endif
                    @if($user->is_active == false)
                        <button type="submit" title="{{ __('Активировать') }}"
                                class="btn n btn-success" id="activation_btn" data-user="{{$user->id }}"
                                onclick="activation(this)">{{ __('Активировать пользователя') }}</button>
                    @endif

                </div>
            </div>
        </div>
        <h3 class="text-center font-weight-bold">Столы</h3>
        {{--        //////Столы Участник--}}
        <div class="row justify-content-center mt-4 mb-2 ">
            <div class="col-lg-12 col-12">
                <div id="main">
                    <div class="accordion md-accordion accordion-blocks border-0" id="accordionStages" role="tablist"
                         aria-multiselectable="true">
                        @foreach($user->desks as $desk)

                            <div class="card" style="margin-bottom: 0.4rem;
    -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    border-bottom: 1px solid #dee2e6!important;
    border-bottom: 0;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;">
                                <a class="text-left collapsed text-decoration-none" data-toggle="collapse"
                                   data-parent="#accordionStages"
                                   href="#user-{{ $desk->user_id }}desk-{{ $desk->id }}"
                                   aria-expanded="true"
                                   aria-controls="user-{{ $desk->user_id }}desk-{{ $desk->id }}">
                                    <div class="card-header d-flex justify-content-between align-items-center border-0"
                                         style="background: {{ $desk->is_closed ? "#ef4f4f" : "#00b300" }}; color: white; "
                                         role="tab" id="Desk-{{ $desk->id }}">
                                        <div>
                                            <div
                                                class="p-2 text-white rounded-lg text-center">
                                                <h6 class="mt-1 mb-0">
                                                    <span
                                                        style="white-space:nowrap;">Программа: {{ $desk->program->cost }}</span>
                                                    <span
                                                        style="white-space:nowrap;">Баланс: {{ $desk->balance }} $</span>
                                                    <span style="white-space:nowrap;">Статус: Участник</span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="offset-1">
                                            <i class="fas fa-angle-down mr-1 rotate-icon"
                                               style="margin-top: 2px;"></i>
                                        </div>
                                    </div>
                                </a>
                                <div id="user-{{ $desk->user_id }}desk-{{ $desk->id }}" class="collapse"
                                     role="tabpanel" aria-labelledby="Desk-{{ $desk->id }}"
                                     data-parent="#accordionStages">
                                    <div class="card-body p-0">
                                        <div class="table-ui  mb-3">
                                            @if($desk->users)
                                                @if($agent->isMobile())
                                                    <section class="border p-2 d-flex mb-4">
                                                        <div class="treeview treeview-primary" data-mdb-accordion="true"
                                                             tabindex="0">
                                                            <ul role="tree">
                                                                <li  class="" aria-level="1" role="tree-item" tabindex="-1">
                                                                   <div class="d-flex">
                                                                       <a {{ $desk->user->name == $user->name ? "colored" : "" }} class="treeview-category rotate"
                                                                          data-mdb-toggle="collapse"
                                                                          data-mdb-target="#level-913004" role="button"
                                                                          tabindex="-1" aria-expanded="true"><span
                                                                               aria-label="toggle"><i class="fas fa-angle-right rotate mx-1"></i>{{ $desk->user->name }}</span>

                                                                       </a>
                                                                       <a href="{{ route('admin.users.edit', $desk->user) }}" class="" style="font-size: 0.9rem;">
                                                                           <i id="edit_profile" class="fas fa-pencil-alt ml-2" style="padding-top: 7px;color: green"></i>
                                                                       </a>
                                                                   </div>
                                                                    <ul class="collapse " id="level-913004"
                                                                        role="group" style="">
                                                                        @foreach($desk->users as $value)
                                                                            @if($value->is_active)
                                                                                <li aria-level="2" role="tree-item"
                                                                                    class="treeview-category"
                                                                                    tabindex="-2">
                                                                                    <div class="d-flex">
                                                                                        <a  class="treeview-category rotate"
                                                                                            data-mdb-toggle="collapse"
                                                                                            data-mdb-target="#level-{{$value->id}}" role="button"
                                                                                            tabindex="-2" aria-expanded="true"><span
                                                                                                aria-label="toggle"><i class="fas fa-angle-right rotate mx-1"></i></span>{{ $value->name }}</a>
                                                                                        <a href="{{ route('admin.users.edit', $value) }}" class="" style="font-size: 0.9rem;">
                                                                                            <i id="edit_profile" class="fas fa-pencil-alt ml-2" style="padding-top: 7px;color: green"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                    <ul class="collapse "
                                                                                        id="level-{{$value->id}}" role="group"
                                                                                        style="">
                                                                                        @foreach($value->children as $item)
                                                                                            @if($item->is_active)
                                                                                                <li aria-level="3" role="tree-item" class="treeview-category" tabindex="-3">
                                                                                                    <a class="pl-3" href="{{ route('admin.users.edit', $item) }}">{{ $item->name }}<i id="edit_profile" class="fas fa-pencil-alt ml-2" style="padding-top: 7px;color: green"></i></a>
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
                                                    </section>

                                                @elseif($agent->isDesktop())
                                                    <div
                                                        class="body genealogy-body genealogy-scroll d-flex justify-content-center">
                                                        <div class="genealogy-tree">
                                                            <ul>
                                                                <li>
                                                                    <a href="{{ route('admin.users.edit', $desk->user) }}">
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
                                                                        @foreach($desk->users as $value)
                                                                            @if($value->is_active)
                                                                                <li>
                                                                                    <a href="{{ route('admin.users.edit', $value) }}">
                                                                                        <div class="member-view-box">
                                                                                            <div class="member-image">
                                                                                                <img
                                                                                                    src="{{ asset('img/person.svg') }}"
                                                                                                    alt="Member"
                                                                                                    style="background-color: {{ $user->id == $value->id ? "limegreen" : "" }}">
                                                                                                <div
                                                                                                    class="member-details ">
                                                                                                    <h6 class="pt-2"
                                                                                                        style="white-space: normal;">{{ $value->name }}</h6>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>

                                                                                    <ul class="active">
                                                                                        @foreach($value->children as $item)
                                                                                            @if($item->is_active)
                                                                                                <li>
                                                                                                    <a href="{{ route('admin.users.edit', $item) }}">
                                                                                                        <div
                                                                                                            class="member-view-box">
                                                                                                            <div
                                                                                                                class="member-image">
                                                                                                                <img
                                                                                                                    src="{{ asset('img/person.svg') }}"
                                                                                                                    alt="Member">
                                                                                                                <div
                                                                                                                    class="member-details ">
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

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{--                        столы владелец--}}
                        @foreach($user->owners as $desk)

                            <div class="card" style="margin-bottom: 0.4rem;
    -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    border-bottom: 1px solid #dee2e6!important;
    border-bottom: 0;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;">
                                <a class="text-left collapsed text-decoration-none" data-toggle="collapse"
                                   data-parent="#accordionStages"
                                   href="#user-{{ $desk->user_id }}desk-{{ $desk->id }}"
                                   aria-expanded="true"
                                   aria-controls="user-{{ $desk->user_id }}desk-{{ $desk->id }}">

                                    <div class="card-header d-flex justify-content-between align-items-center border-0"
                                         style="background: {{ $desk->is_closed ? "#ef4f4f" : "#00b300" }}; color:white;"
                                         role="tab" id="Desk-{{ $desk->id }}">
                                        <div>
                                            <div
                                                class="p-2 text-white rounded-lg text-center">
                                                <h6 class="mt-1 mb-0">
                                                    <span
                                                        style="white-space:nowrap;">Программа: {{ $desk->program->cost }}</span>
                                                    <span
                                                        style="white-space:nowrap;">Баланс: {{ $desk->balance }}</span>
                                                    <span style="white-space:nowrap;">Статус: Владелец</span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="offset-1"><i
                                                class="fas fa-angle-down mr-1 rotate-icon"
                                                style="margin-top: 2px;"></i>
                                        </div>
                                    </div>
                                </a>

                                <div id="user-{{ $desk->user_id }}desk-{{ $desk->id }}" class="collapse"
                                     role="tabpanel" aria-labelledby="Desk-{{ $desk->id }}"
                                     data-parent="#accordionStages">
                                    <div class="card-body p-0">
                                        <div class="table-ui  mb-3">
                                            @if($desk->users)
                                                @if($agent->isMobile())
                                                    <section class="border p-2 d-flex mb-4">
                                                        <div class="treeview treeview-primary" data-mdb-accordion="true"
                                                             tabindex="0">
                                                            <ul role="tree">
                                                                <li class="" aria-level="1" role="tree-item"
                                                                    tabindex="-1">
                                                                    <div class="d-flex">
                                                                        <a {{ $desk->user->name == $user->name ? "colored" : "" }} class="treeview-category rotate"
                                                                           data-mdb-toggle="collapse"
                                                                           data-mdb-target="#level-913004" role="button"
                                                                           tabindex="-1" aria-expanded="true"><span
                                                                                aria-label="toggle"><i
                                                                                    class="fas fa-angle-right rotate mx-1"></i>{{ $desk->user->name }}</span>

                                                                        </a>
                                                                        <a href="{{ route('admin.users.edit', $desk->user) }}"
                                                                           class="" style="font-size: 0.9rem;">
                                                                            <i id="edit_profile"
                                                                               class="fas fa-pencil-alt ml-2"
                                                                               style="padding-top: 7px;color: green"></i>
                                                                        </a>
                                                                    </div>
                                                                    <ul class="collapse" id="level-913004"
                                                                        role="group" style="">
                                                                        @foreach($desk->users as $value)
                                                                            @if($value->is_active)
                                                                                <li aria-level="2" role="tree-item"
                                                                                    class="treeview-category"
                                                                                    tabindex="-2">
                                                                                    <div class="d-flex">
                                                                                        <a  class="treeview-category rotate"
                                                                                            data-mdb-toggle="collapse"
                                                                                            data-mdb-target="#level-{{$value->id}}" role="button"
                                                                                            tabindex="-2" aria-expanded="true"><span
                                                                                                aria-label="toggle"><i class="fas fa-angle-right rotate mx-1"></i></span>{{ $value->name }}</a>
                                                                                        <a href="{{ route('admin.users.edit', $value) }}" class="" style="font-size: 0.9rem;">
                                                                                            <i id="edit_profile" class="fas fa-pencil-alt ml-2" style="padding-top: 7px;color: green"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                    <ul class="collapse"
                                                                                        id="level-{{$value->id}}" role="group"
                                                                                        style="">
                                                                                        @foreach($value->children as $item)
                                                                                            @if($item->is_active)
                                                                                                <li aria-level="3"
                                                                                                    role="tree-item"
                                                                                                    class="treeview-category"
                                                                                                    tabindex="-1">
                                                                                                    <a class="pl-3"
                                                                                                       href="{{ route('admin.users.edit', $item) }}">{{ $item->name }}
                                                                                                        <i id="edit_profile"
                                                                                                           class="fas fa-pencil-alt ml-2"
                                                                                                           style="padding-top: 7px;color: green"></i></a>
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
                                                    </section>


                                                @elseif($agent->isDesktop())

                                                    <div
                                                        class="body genealogy-body genealogy-scroll d-flex justify-content-center">
                                                        <div class="genealogy-tree">
                                                            <ul>
                                                                <li>
                                                                    <a href="{{ route('admin.users.edit', $desk->user) }}">
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
                                                                                    <a href="{{ route('admin.users.edit', $user) }}">
                                                                                        <div class="member-view-box">
                                                                                            <div class="member-image">
                                                                                                <img
                                                                                                    src="{{ asset('img/person.svg') }}"
                                                                                                    alt="Member">
                                                                                                <div
                                                                                                    class="member-details ">
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
                                                                                                    <a href="{{ route('admin.users.edit', $item) }}">
                                                                                                        <div
                                                                                                            class="member-view-box">
                                                                                                            <div
                                                                                                                class="member-image">
                                                                                                                <img
                                                                                                                    src="{{ asset('img/person.svg') }}"
                                                                                                                    alt="Member">
                                                                                                                <div
                                                                                                                    class="member-details ">
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
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
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

        .main_spec_card {
            position: relative;
            z-index: 9999;
            transform: scale(1.05);
            box-shadow: 0px 2px 14px rgba(42, 252, 15, 0.54);
            transition: 0.3s;
        }

        .colored {
            background-color: greenyellow;
        }

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

        .treeview .rotate {
            font-size: 1rem !important;
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
            let toggler = document.getElementsByClassName("caret");
            let i;

            for (i = 0; i < toggler.length; i++) {
                toggler[i].addEventListener("click", function () {
                    this.parentElement.querySelector(".nested").classList.toggle("active");
                    this.classList.toggle("caret-down");
                });
            }
        });
    </script>
    <script>

        function activation(user) {
            var preloader = document.getElementById('loader');
            preloader.style.display = 'block';
            document.body.style.overflow = "hidden";
            let id = user.getAttribute("data-user");
            $.ajax({
                url: "{{ route('admin.user.activation') }}",
                method: 'get',
                data: {
                    id: id,
                },
                success: function () {
                    $('#activation_btn').hide();
                    location.reload();
                    preloader.style.display = 'none';
                    document.body.style.overflow = "visible";
                }
            })
        }
    </script>

@endpush
