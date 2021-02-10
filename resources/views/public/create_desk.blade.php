@extends('layouts.app')
@section('content')
    <div class="container" style="min-height: 80vh;">
        <div class="bg-form card-body">
            <div class="row">
                <form method="POST" action="{{ route('store.desk') }}">
                    <div class="form-group">
                        <label for="program-select">Программы:</label>
                        <select name="program_id" id="program-select" class="form-control">
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->cost }}</option>
                            @endforeach
                        </select>
                    </div>
                    @csrf
                    <div>
                        <button type="submit" title="{{ __('Добавить') }}"
                                class="btn btn-success">{{ __('Добавить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
