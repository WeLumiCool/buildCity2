@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5">
                <div>
                    <p>Баланс: {{ $desk->balance }}</p>
                    <p>Ставка: {{ $desk->program->cost }}</p>
                    <p>Сумма Закрытия: {{ $desk->program->closing_amount }}</p>
                    <p>Дата открытия стола: {{ $desk->created_at->format('d.m.y G:i') }}</p>
                    <div>
                        <button class="btn btn-secondary" id="copy_btn">Скопировать ссыклу</button>
                        <input class="" id="linkEvent" type="text" readonly>
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
            $('#linkEvent').val(window.location.hostname + '/register/{{ $desk->code }}');
            $('#copy_btn').click(function () {
                copyToClipboard(document.getElementById("linkEvent"));
                $(this).removeClass('btn-secondary');
                $(this).addClass('btn-success');
                setTimeout(function () {
                    console.log('work timer');
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-secondary');
                }, 2000);
            });
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
