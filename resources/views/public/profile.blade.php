@extends('layouts.app')
@section('content')
    <div class="container" style="min-height: 80vh;">
        <div class="bg-form card-body p-5">
            <div class="row">
                <form method="POST" action="{{ route('update.profile') }}">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}">

                    <div class="form-group row">
                        <label for="current_pwd_field" class="col-lg-2 col-12 col-form-label font-weight-bold">Текущий
                            пароль:</label>
                        <div class="col-12 col-lg-10">
                            <input id="current_pwd_field" type="text"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   name="current_password">
                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_field" class="col-lg-2 col-12 col-form-label font-weight-bold">Новый
                            пароль:</label>
                        <div class="col-12 col-lg-10">
                            <input id="password_field" type="text"
                                   class="form-control  @error('password') is-invalid @enderror" name="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pwd_confirmation_field" class="col-lg-2 col-12 col-form-label font-weight-bold">Повтор
                            пароль:</label>
                        <div class="col-12 col-lg-10">
                            <input id="pwd_confirmation_field" type="text" class="form-control"
                                   name="password_confirmation">
                        </div>
                    </div>
                    <div>
                        <button type="submit" title="{{ __('Сохранить') }}"
                                class="btn n btn-success mx-auto">{{ __('Сохранить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
