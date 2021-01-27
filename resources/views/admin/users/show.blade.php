@extends('admin.layouts.dashboard')
@section('dashboard_content')
    <?php
    use Jenssegers\Agent\Agent;

    $agent = new Agent();
    ?>
    <div class="container bg-form card-body-admin py-4">
{{--        @if($user->is_active == false)--}}
            <button type="submit" title="{{ __('Активировать') }}"
                    class="btn n btn-success" id="activation_btn" data-user="{{$user->id }}"
                    onclick="activation(this)">{{ __('Активировать') }}</button>
{{--        @endif--}}
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

                </div>
            </div>
        </div>
        <h3 class="text-center font-weight-bold">Столы</h3>
        <div class="row justify-content-center mt-4 mb-2 ">
            <div class="col-lg-9 col-12">
                <div id="main">
                    <div class="accordion md-accordion accordion-blocks border-0" id="accordionStages" role="tablist"
                         aria-multiselectable="true">
                        @if(!$user->desks == null)
                            <span>Участники:</span>
                        @else

                        @endif
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
                                         style="background: white"
                                         role="tab" id="Desk-{{ $desk->id }}">
                                        <div>
                                            <div
                                                class="p-2 {{ $desk->is_closed ? "bg-danger" : "bg-success" }} text-white rounded-lg">
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
                                                    <div class="p-3 ">
                                                        <div class="treeview w-100 border  shadow-sm">
                                                            <ul class="my-1 pl-3 py-2">
                                                                <li>
                                                                    <span class="caret" {{ $desk->user->name == $user->name ? "colored" : "" }}><i
                                                                            class="fas fa-users mx-2"></i>{{ $desk->user->name }}</span>
                                                                    <ul class="nested">
                                                                        @foreach($desk->users as $user)
                                                                            @if($user->is_active)
                                                                                <li>
                                                                                        <span class="caret">
                                                                                            <i class="fas fa-user-friends mr-2"></i>{{ $user->name }}
                                                                                        </span>
                                                                                    <ul class="nested">
                                                                                        @foreach($user->children as $item)
                                                                                            @if($item->is_active)
                                                                                                <li>
                                                                                                    <i class="fas fa-user-alt mr-2"></i>{{ $item->name }}
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
                                                    <div
                                                        class="body genealogy-body genealogy-scroll d-flex justify-content-center">
                                                        <div class="genealogy-tree">
                                                            <ul>
                                                                <li>
                                                                    <a href="javascript:void(0);">
                                                                        <div class="member-view-box">
                                                                            <div class="member-image">
                                                                                <img
                                                                                    src="{{ asset('img/owner.svg') }}"
                                                                                    alt="Owner">
                                                                                <div class="member-details ">
                                                                                    <h6 {{ $desk->user->name == $user->name ? "colored" : "" }} class="pt-2"
                                                                                        style="white-space: normal;">{{ $desk->user->name }}</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <ul class="active">
                                                                        @foreach($desk->users as $value)
                                                                            <li>
                                                                                <a href="javascript:void(0);">
                                                                                    <div class="member-view-box">
                                                                                        <div class="member-image">
                                                                                            <img
                                                                                                src="{{ asset('img/person.svg') }}"
                                                                                                alt="Member">
                                                                                            <div
                                                                                                class="member-details ">
                                                                                                <h6 {{ $value->name === $user->name ? "colored" : "" }} class="pt-2"
                                                                                                    style="white-space: normal;">{{ $value->name }}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
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
                        @if(!$user->owners == null)
                            <span>Владелец:</span>
                        @endif
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
                                         style="background: white"
                                         role="tab" id="Desk-{{ $desk->id }}">
                                        <div>
                                            <div
                                                class="p-2 {{ $desk->is_closed ? "bg-danger" : "bg-success" }} text-white rounded-lg">
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
                                                    <div class="p-3 ">
                                                        <div class="treeview w-100 border  shadow-sm">
                                                            <ul class="my-1 pl-3 py-2">
                                                                <li>
                                                                    <span
                                                                        {{ $desk->user->name == $user->name ? "colored" : "" }} class="caret"><i
                                                                            class="fas fa-users mx-2"></i>{{ $desk->user->name }}</span>
                                                                    <ul class="nested">
                                                                        @foreach($desk->users as $value)
                                                                            <li {{ $value->name === $user->name ? "colored" : "" }}  for="{{ $value->id }}">
                                                                                <i class="fas fa-user-alt mr-2"></i>{{ $value->name }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                @elseif($agent->isDesktop())
                                                    <div
                                                        class="body genealogy-body genealogy-scroll d-flex justify-content-center">
                                                        <div class="genealogy-tree">
                                                            <ul>
                                                                <li>
                                                                    <a href="javascript:void(0);">
                                                                        <div class="member-view-box">
                                                                            <div class="member-image">
                                                                                <img
                                                                                    src="{{ asset('img/owner.svg') }}"
                                                                                    alt="Member">
                                                                                <div class="member-details ">
                                                                                    <h6 {{ $desk->user->name == $user->name ? "colored" : "" }} rounded
                                                                                        class="pt-2"
                                                                                        style="white-space: normal;">{{ $desk->user->name }}</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <ul class="active">
                                                                        @foreach($desk->users as $value)
                                                                            <li>
                                                                                <a href="javascript:void(0);">
                                                                                    <div class="member-view-box">
                                                                                        <div class="member-image">
                                                                                            <img
                                                                                                src="{{ asset('img/person.svg') }}"
                                                                                                alt="Member">
                                                                                            <div
                                                                                                class="member-details ">
                                                                                                <h6 {{ $value->name === $user->name ? "colored" : "" }} class="pt-2"
                                                                                                    for="{{ $value->id }}"
                                                                                                    style="white-space: normal;">{{ $value->name }}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
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
    </style>
@endpush

@push('scripts')
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
            let id = user.getAttribute("data-user");
            $.ajax({
                url: "{{ route('admin.user.activation') }}",
                method: 'get',
                data: {
                    id: id,
                },
                success: function () {
                    // $('#activation_btn').hide();
                    // alert('Пользователь активен!')
                }
            })
        }
    </script>
    <script>
        $(function () {
            $('.genealogy-tree ul').hide();
            $('.genealogy-tree>ul').show();
            $('.genealogy-tree ul.active').show();
            $('.genealogy-tree li').on('click', function (e) {
                var children = $(this).find('> ul');
                if (children.is(":visible")) children.hide('fast').removeClass('active');
                else children.show('fast').addClass('active');
                e.stopPropagation();
            });
        });
    </script>
@endpush
