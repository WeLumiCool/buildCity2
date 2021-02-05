@extends('admin.layouts.dashboard')

@section('dashboard_content')
    <div class="row">
        <div class="col-12 col-sm-10 col-lg-12 col-md-12 card-body-admin py-4 px-5">
            <form action="{{ route('admin.users.update', $user) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h3 class="text-center font-weight-bold">Редактирование пользователя</h3>
{{--                <ul>--}}
{{--                    @foreach($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
                <div class="form-group">
                    <label for="name-input">ФИО:</label>
                    <input type="text" id="name-input" class="form-control" name="name"
                           value="{{ old('name', $user->name) }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="mail-input">{{ __('Почта') }}:</label>
                    <input type="text" id="mail-input" class="form-control  @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="form-group">
                    <label for="phone-input">Телефон:</label>
                    <input type="text" id="phone-input" class="form-control @error('phone') is-invalid @enderror" name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           required>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-input">Пароль:<span style="color: red">*</span></label>
                    <label for="password"></label><input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                                         autocomplete="new-password" id="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Повторите пароль:<span style="color: red">*</span></label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation"
                           autocomplete="new-password">

                </div>

                <div class="form-group">
                    <input id="admin_checkbox" type="checkbox" name="is_admin" {{ $user->role ? 'checked' : '' }}>
                    <label for="admin_checkbox">Является ли админом</label>
                </div>
                <button type="submit" title="{{ __('Изменить') }}"
                        class="btn n btn-success">{{ __('Изменить') }}</button>
            </form>
        </div>
    </div>
@endsection
