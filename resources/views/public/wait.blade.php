@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-5 p-4">
                <div class="font-weight-extra font-size-28 text-danger mb-4">
                    Ваш аккаунт неактивен
                </div>
                <p class="font-weight-normal font-size-18 text-dark">
                    Ваш аккаунт находится на рассмотрении Администратором или ждет подтверждения вашего Email адреса.
                </p>
                <a href=".">
                    <button class="btn btn-success px-4 py-2 mt-3">
                        Вернуться на главную
                    </button>
                </a>

            </div>
            <div class="col-3 text-center">
                <img class="img-fluid" src="{{ asset('img/sand-clock.png') }}" alt="">
            </div>
        </div>
    </div>
@endsection