@extends('admin.layouts.dashboard')

@section('dashboard_content')
    <div class="row ">
        <div class="col-12 col-sm-10 col-lg-12 col-md-10 bg-form card-body-admin py-4 px-5">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <div class="form-group">
                    <label for="name-input">ФИО:<span style="color: red">*</span></label>
                    <input type="text" id="name-input" class="form-control" name="name" value="{{ old('name') }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="mail-input">Почта:<span style="color: red">*</span></label>
                    <input type="email" id="mail-input" class="form-control" name="email" value="{{ old('email') }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="phone-input">Телефон:<span style="color: red">*</span></label>
                    <input type="text" id="phone-input" class="form-control" name="phone" value="{{ old('phone') }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="type_of_object">Выберите стол куда его посадить:</label>
                    <select class="form-control" id="type_of_object" name="desk_id">
                        @foreach($parent as $item)
                            <option value="{{ $item->id }}">{{ $item->user->name }}:{{ $item->code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input id="admin_checkbox" type="checkbox" name="is_admin">
                    <label for="admin_checkbox">Является ли админом</label>
                </div>
                <div class="form-group">
                    <label for="password-input">Пароль:<span style="color: red">*</span></label>
                    <input type="password"
                           class="form-control"
                           name="password"
                           required autocomplete="new-password" id="password">
                </div>
                <div class="form-group">
                    <label for="password-confirm">Повторите пароль:<span style="color: red">*</span></label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required
                           autocomplete="new-password">
                </div>
                <button type="submit" title="{{ __('Добавить') }}"
                        class="btn n btn-success ">{{ __('Добавить') }}</button>
            </form>
        </div>
    </div>
@endsection
