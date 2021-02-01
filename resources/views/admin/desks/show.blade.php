@extends('admin.layouts.dashboard')
@section('content')
    <?php
    use Jenssegers\Agent\Agent;

    $agent = new Agent();
    ?>
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-5 mb-5 pt-3">
                <div class="border p-2 shadow-sm">
                    @if($agent->isMobile())
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Владелец:</span><span
                                class="text-muted">{{ $desk->user->name }}</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Баланс:</span><span
                                class="text-muted">{{ $desk->balance }} $</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Ставка:</span><span
                                class="text-muted">{{ $desk->program->cost }} $</span></p>
                        <p class="justify-content-between d-flex"><span
                                class="font-weight-bold">Сумма выплаты:</span><span
                                class="text-muted">{{ $desk->program->closing_amount }} $</span></p>
                        <p class="justify-content-between d-flex"><span
                                class="font-weight-bold">Дата открытия стола:</span><span
                                class="text-muted">{{ $desk->created_at->format('d.m.y G:i') }}</span></p>
                    @elseif($agent->isDesktop())
                        <div class="row p-2">
                            <div class="col-6 border-right">
                                <p class="font-weight-bold">Владелец:</p>
                                <p class="font-weight-bold">Баланс:</p>
                                <p class="font-weight-bold">Ставка:</p>
                                <p class="font-weight-bold">Сумма выплаты:</p>
                                <p class="font-weight-bold">Дата открытия стола:</p>
                            </div>
                            <div class="col-6 border-left">
                                <p class="text-muted">{{ $desk->user->name }}</p>
                                <p class="text-muted">{{ $desk->balance }} $</p>
                                <p class="text-muted">{{ $desk->program->cost }} $</p>
                                <p class="text-muted">{{ $desk->program->closing_amount }} $</p>
                                <p class="text-muted">{{ $desk->created_at->format('d.m.y G:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($desk->is_active == false)
                        <button type="submit" title="{{ __('Активировать стол') }}"
                                class="btn n btn-success" id="activation_btn" data-desk="{{$desk->id }}"
                                onclick="activation(this)">{{ __('Активировать стол') }}</button>
                    @endif
                </div>
            </div>
                @if($agent->isMobile())
                   <div class="col-12">
                       <div class="p-2 border d-flex mb-4">
                           <div class="treeview treeview-primary" data-mdb-accordion="true"
                                tabindex="0">
                               <ul role="tree">
                                   <li class="" aria-level="1" role="tree-item" tabindex="-1">
                                       <div class="d-flex">
                                           <a  class="treeview-category rotate"
                                               data-mdb-toggle="collapse"
                                               data-mdb-target="#level-913004" role="button"
                                               tabindex="-1" aria-expanded="true"><span
                                                   aria-label="toggle"><i class="fas fa-angle-right rotate mx-1"></i>{{ $desk->user->name }}</span>

                                           </a>
                                           <a href="{{ route('admin.users.edit', $desk->user) }}" class=""
                                              style="font-size: 0.9rem;">
                                               <i id="edit_profile" class="fas fa-pencil-alt ml-2"
                                                  style="padding-top: 7px;color: green"></i>
                                           </a>
                                       </div>
                                       <ul class="collapse show" id="level-913004"
                                           role="group" style="">
                                           @foreach($desk->users as $value)
                                               @if($value->is_active)
                                                   <li aria-level="2" role="tree-item"
                                                       class="treeview-category"
                                                       tabindex="-2">
                                                       <div class="d-flex">
                                                           <a class="treeview-category rotate"
                                                              data-mdb-toggle="collapse"
                                                              data-mdb-target="#level-9130042" role="button"
                                                              tabindex="-2" aria-expanded="true"><span
                                                                   aria-label="toggle"><i
                                                                       class="fas fa-angle-right rotate mx-1"></i></span>{{ $value->name }}
                                                           </a>
                                                           <a href="{{ route('admin.users.edit', $value) }}" class=""
                                                              style="font-size: 0.9rem;">
                                                               <i id="edit_profile" class="fas fa-pencil-alt ml-2"
                                                                  style="padding-top: 7px;color: green"></i>
                                                           </a>
                                                       </div>
                                                       <ul class="collapse show"
                                                           id="level-9130042" role="group"
                                                           style="">
                                                           @foreach($value->children as $item)
                                                               @if($item->is_active)
                                                                   <li aria-level="3" role="tree-item"
                                                                       class="treeview-category" tabindex="-1">
                                                                       <a class="pl-3"
                                                                          href="{{ route('admin.users.edit', $item) }}">{{ $item->name }}
                                                                           <i id="edit_profile" class="fas fa-pencil-alt ml-2"
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
                       </div>
                   </div>
                @elseif($agent->isDesktop())
                    <div class="col-12">
                        <div class="body genealogy-body genealogy-scroll d-flex justify-content-center">
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
                                                                        <a href="{{ route('admin.users.edit', $item) }}">
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
        function activation(desk) {
            var preloader = document.getElementById('loader');
            preloader.style.display = 'block';
            document.body.style.overflow = "hidden";
            let id = desk.getAttribute("data-desk");
            $.ajax({
                url: "{{ route('admin.desk.activation') }}",
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

