@extends('admin.layouts.dashboard')

@section('dashboard_content')
    <div class="p-3 bg-form card-body-admin">
        <div class="row">
            <div class="col-12 col-sm-10 col-lg-12 col-md-10">
                <form action="{{ route('admin.programs.store') }}" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <p class="font-weight-bold h2">Добавления программы</p>
                    </div>
                    <div class="form-group">
                        <label for="name_field">Цена открытия программы<span class="text-danger">*</span></label>
                        <input id="name_field" type="text" class="form-control" name="cost" required>
                    </div>
                    <div class="form-group">
                        <label for="name_field">Сумма закрытия программы<span class="text-danger">*</span></label>
                        <input id="name_field" type="text" class="form-control" name="closing_amount" required>
                    </div>
                    <button type="submit" title="{{ __('Добавить') }}"
                            class="btn n btn-success">{{ __('Добавить') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
