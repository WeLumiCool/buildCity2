@extends('admin.layouts.app')
@section('content')
    <div class="row ">
        <div class="col-12 col-sm-10 col-lg-12 col-md-10 bg-form card-body-admin py-4 px-5">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                {{--                @dd($desks)--}}
                <div class="form-group">
                    <label for="desk_select">Куда добавить:</label>
                    <select class="form-control" name="to_desk" id="desk_select">
                        @foreach($desks as $desk)
                            @if(!$desk->is_closed)
                                <option value="{{ $desk->id }}">{{ $desk->code }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" title="{{ __('Поменять') }}"
                        class="btn n btn-success ">{{ __('Поменять') }}</button>
            </form>
        </div>
    </div>
@endsection