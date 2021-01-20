@extends('admin.layouts.dashboard')
@section('dashboard_content')
    <div class="container bg-form card-body-admin py-4">
        @if($user->is_active == false)
            <button type="submit" title="{{ __('Активировать') }}"
                    class="btn n btn-success" id="activation_btn" data-user="{{$user->id }}"
                    onclick="activation(this)">{{ __('Активировать') }}</button>
        @endif
        <div class="row p-5" id="show_articles">
            <div class="col-2">ФИО:</div>
            <div class="col-10">{{ $user->name }}</div>
            <div class="col-2">Почта:</div>
            <div class="col-10">{{ $user->email }}</div>
            <div class="col-2">Телефон:</div>
            <div class="col-10">{{ $user->phone }}</div>
            <div class="col-2">Баланс:</div>
            <div class="col-10">{{ $user->balance }}</div>

        </div>
        <h3 class="text-center font-weight-bold">Столы</h3>

        <div class="row mt-4 mb-2 ">
            <div class="col-12">
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
                                <div class="card-header d-flex justify-content-between align-items-center border-0"
                                     style="background: white"
                                     role="tab" id="Desk-{{ $desk->id }}">
                                    <a class="text-left w-100 collapsed text-decoration-none" data-toggle="collapse"
                                       data-parent="#accordionStages"
                                       href="#user-{{ $desk->user_id }}desk-{{ $desk->id }}"
                                       aria-expanded="true"
                                       aria-controls="user-{{ $desk->user_id }}desk-{{ $desk->id }}">
                                        <h6 class="mt-1 mb-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <div
                                                            class="p-3 mb-2 {{ $desk->is_closed ? "bg-danger" : "bg-success" }} text-white rounded-lg">
                                                        <span>Программа: {{ $desk->program->cost }}</span>
                                                        <span class="ml-3">Баланс: {{ $desk->balance }}</span>
                                                        <span class="ml-3">Статус: Участник стола</span>
                                                    </div>
                                                </div>
                                                <div class="col-2 offset-3"><i
                                                            class="fas fa-angle-down mr-3 rotate-icon"
                                                            style="margin-top: 2px;"></i></div>
                                            </div>


                                        </h6>
                                    </a>

                                </div>

                                <div id="user-{{ $desk->user_id }}desk-{{ $desk->id }}" class="collapse"
                                     role="tabpanel" aria-labelledby="Desk-{{ $desk->id }}"
                                     data-parent="#accordionStages">
                                    <div class="card-body p-0">
                                        <div class="table-ui  mb-3">
                                            @if($desk->users)
                                                <div class="tf-tree tf-gap-lg">
                                                    <ul>
                                                        <li>
                                                        <span
                                                                class="tf-nc {{ $desk->user->name == $user->name ? "colored" : "" }} rounded">{{$desk->user->name}}</span>
                                                            <ul>
                                                                @foreach($desk->users as $value)
                                                                    <li>
                                                                        <span class="tf-nc {{ $value->name === $user->name ? "colored" : "" }} rounded">{{ $value->name }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                        @foreach($user->owners as $desk)
                            <div class="card" style="margin-bottom: 0.4rem;
    -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    border-bottom: 1px solid #dee2e6!important;
    border-bottom: 0;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;">
                                <div class="card-header d-flex justify-content-between align-items-center border-0"
                                     style="background: white"
                                     role="tab" id="Desk-{{ $desk->id }}">
                                    <a class="text-left w-100 collapsed text-decoration-none" data-toggle="collapse"
                                       data-parent="#accordionStages"
                                       href="#user-{{ $desk->user_id }}desk-{{ $desk->id }}"
                                       aria-expanded="true"
                                       aria-controls="user-{{ $desk->user_id }}desk-{{ $desk->id }}">
                                        <h6 class="mt-1 mb-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <div
                                                            class="p-3 mb-2 {{ $desk->is_closed ? "bg-danger" : "bg-success" }} text-white rounded-lg">
                                                        <span>Программа: {{ $desk->program->cost }}</span>
                                                        <span class="ml-3">Баланс: {{ $desk->balance }}</span>
                                                        <span class="ml-3">Статус: Владелец стола</span>
                                                    </div>
                                                </div>
                                                <div class="col-2 offset-3"><i
                                                            class="fas fa-angle-down mr-3 rotate-icon"
                                                            style="margin-top: 2px;"></i></div>
                                            </div>


                                        </h6>
                                    </a>

                                </div>

                                <div id="user-{{ $desk->user_id }}desk-{{ $desk->id }}" class="collapse"
                                     role="tabpanel" aria-labelledby="Desk-{{ $desk->id }}"
                                     data-parent="#accordionStages">
                                    <div class="card-body p-0">
                                        <div class="table-ui  mb-3">
                                            @if($desk->users)
                                                <div class="tf-tree tf-gap-lg">
                                                    <ul>
                                                        <li>
                                                        <span
                                                                class="tf-nc {{ $desk->user->name == $user->name ? "colored" : "" }} rounded">{{$desk->user->name}}</span>
                                                            <ul>
                                                                @foreach($desk->users as $value)
                                                                    <li>
                                                                    <span class="tf-nc {{ $value->name === $user->name ? "colored" : "" }} rounded">
                                                                         <div class="form-check">
                                                                              <label class="form-check-label ml-3"
                                                                                     for="{{ $value->id }}">
                                                                                {{ $value->name }}
                                                                              </label>
                                                                            </div>
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
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
        function activation(user) {
            let id = user.getAttribute("data-user");
            $.ajax({
                url: "{{ route('admin.user.activation') }}",
                method: 'get',
                data: {
                    id: id,
                },
                success: function () {
                    $('#activation_btn').hide();
                    alert('Пользователь актвиен!')
                }
            })
        }
    </script>
@endpush
