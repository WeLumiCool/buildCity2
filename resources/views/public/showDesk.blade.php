@extends('layouts.app')
@section('content')
    <?php
    use Jenssegers\Agent\Agent;

    $agent = new Agent();
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-5 mb-3">
                <div class="border p-2 shadow-sm">
                    @if($agent->isMobile())
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Баланс:</span><span
                                class="text-muted">{{ $desk->balance }} $</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Ставка:</span><span
                                class="text-muted">{{ $desk->program->cost }} $</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Сумма выплаты:</span><span
                                class="text-muted">{{ $desk->program->closing_amount }} $</span></p>
                        <p class="justify-content-between d-flex"><span class="font-weight-bold">Дата открытия стола:</span><span
                                class="text-muted">{{ $desk->created_at->format('d.m.y G:i') }}</span></p>
                    @elseif($agent->isDesktop())
                        <div class="row p-2">
                            <div class="col-6 border-right">
                                <p class="font-weight-bold">Баланс:</p>
                                <p class="font-weight-bold">Ставка:</p>
                                <p class="font-weight-bold">Сумма выплаты:</p>
                                <p class="font-weight-bold">Дата открытия стола:</p>
                            </div>
                            <div class="col-6 border-left">
                                <p class="text-muted">{{ $desk->balance }} $</p>
                                <p class="text-muted">{{ $desk->program->cost }} $</p>
                                <p class="text-muted">{{ $desk->program->closing_amount }} $</p>
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
                <div class="p-3 ">
                    <div class="treeview w-100 border  shadow-sm">
                        <ul class="my-1 pl-3 py-2">
                            <li>
                                <span class="caret"><i class="fas fa-users mx-2"></i>{{ $desk->user->name }}</span>
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

                <div class="col-12">
                    <div class="body genealogy-body genealogy-scroll d-flex justify-content-center">
                        <div class="genealogy-tree">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="{{ asset('img/owner.svg') }}"
                                                     alt="Member">
                                                <div class="member-details ">
                                                    <h6 class="pt-2" style="white-space: normal;">{{ $desk->user->name }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="active">
                                        @foreach($desk->users as $user)
                                            @if($user->is_active)
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <div class="member-view-box">
                                                            <div class="member-image">
                                                                <img
                                                                    src="{{ asset('img/person.svg') }}"
                                                                    alt="Member">
                                                                <div class="member-details ">
                                                                    <h6 class="pt-2" style="white-space: normal;">{{ $user->name }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
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
    <script>
        $(document).ready(function () {
            if ('1' === '{{ $desk->is_closed }}') {
                $('#linkEvent').remove();
                $('#copy_btn').remove();
            }
            else if ('0' === '{{ $desk->is_active }}') {
                let span = '<span class="text-danger">Примечание: стол находится на рассмотрении или ожидает оплаты!</span>';
                $('#linkEvent').remove();
                $('#copy_btn').remove();
                $('#note').html(span);
            }
            else if ('{{ $desk->users->count() }}' === '3')
            {
                let span = '<span class="text-danger">Примечание: Вы больше не можете приглашать новых пользователей!</span>';
                $('#linkEvent').remove();
                $('#copy_btn').remove();
                $('#note').html(span);
            }
            else {
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
    </script>
@endpush
