@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5">
                <div class="border p-2 shadow-sm">
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Баланс:</span><span
                            class="text-muted">{{ $desk->balance }}</span></p>
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Ставка:</span><span
                            class="text-muted">{{ $desk->program->cost }}</span></p>
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Сумма Закрытия:</span><span
                            class="text-muted">{{ $desk->program->closing_amount }}</span></p>
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Дата открытия стола:</span><span
                            class="text-muted">{{ $desk->created_at->format('d.m.y G:i') }}</span></p>
                    <div class="form-group">
                        <button class="btn btn-secondary mb-3" id="copy_btn">Скопировать ссыклу</button>
                        <input class="form-control" id="linkEvent" type="text" readonly>
                    </div>
                </div>
            </div>
            <div class="tf-tree">
                <ul>
                    <li>
                        <span class="tf-nc">{{ $desk->user->name }}</span>
                        <ul>
                            @foreach($desk->users as $user)
                                @if($user->is_active)
                                    <li><span class="tf-nc">{{ $user->name }}</span></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            if ('1' === '{{ $desk->is_closed }}') {
                $('#linkEvent').remove();
                $('#copy_btn').remove();
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
    </script>
@endpush
