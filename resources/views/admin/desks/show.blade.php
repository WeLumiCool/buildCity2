@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5">
                <div class="border p-2 shadow-sm">
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Баланс:</span>
                        <span class="text-muted">{{ $desk->balance }}</span></p>
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Ставка:</span><span
                                class="text-muted">{{ $desk->program->cost }}</span></p>
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Сумма Закрытия:</span><span
                                class="text-muted">{{ $desk->program->closing_amount }}</span></p>
                    <p class="justify-content-between d-flex"><span class="font-weight-bold">Дата открытия стола:</span><span
                                class="text-muted">{{ $desk->created_at->format('d.m.y G:i') }}</span></p>
                    @if($desk->is_active == false)
                    <button type="submit" title="{{ __('Активировать стол') }}"
                            class="btn n btn-success" id="activation_btn" data-desk="{{$desk->id }}"
                            onclick="activation(this)">{{ __('Активировать стол') }}</button>
                        @endif
                </div>
            </div>
            <div class="col-6">

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
        function activation(desk) {
            let id = desk.getAttribute("data-desk");
            $.ajax({
                url: "{{ route('admin.desk.activation') }}",
                method: 'get',
                data: {
                    id: id,
                },
                success: function () {
                    $('#activation_btn').hide();
                    alert('Стол активен!')
                }
            })
        }
    </script>

    @endpush
