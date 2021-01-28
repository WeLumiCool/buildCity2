@extends('admin.layouts.app')
@section('content')
   <div class="container py-3">
       <div class="row ">
           <div class="col-12 col-sm-10 col-lg-12 col-md-10 bg-form card-body-admin py-4 px-5">
               <form action="{{ route('admin.desks.make.replace') }}" method="POST">
                   @csrf
                   <div class="form-group">
                       <label for="from_desk_select">Откуда добавить: <span style="color:red">*</span></label>
                       <select class="form-control" name="from_desk" id="from_desk_select" required>
                           <option value="0">Выберите стол</option>
                           @foreach($desks as $desk)
                               @if(!$desk->is_closed and count($desk->active_user)>0)
                                   <option value="{{ $desk->id }}">{{ $desk->user->name.'::'.$desk->code }}</option>
                               @endif
                           @endforeach
                       </select>
                   </div>
                   <div id="user_select" class="form-group">

                   </div>
                   <div class="form-group d-none" id="desk_select">
                       <label for="to_desk_select">Куда добавить:</label>
                       <select class="form-control" name="to_desk" id="to_desk_select">
                           @foreach($desks as $desk)
                               @if(!$desk->is_closed)
                                   <option value="{{ $desk->id }}">{{ $desk->user->name.'::'.$desk->code }}</option>
                               @endif
                           @endforeach
                       </select>
                   </div>
                   <button type="submit" id="replace-btn" title="{{ __('Поменять') }}"
                           class="btn n btn-success d-none">{{ __('Поменять') }}</button>

               </form>
           </div>
       </div>
   </div>
@endsection
@push('scripts')
    <script>
        $('#from_desk_select').change(function () {
            let id = $('#from_desk_select').val();
            $('#user_select').empty();
            if (id !== 0) {
                $.ajax({
                    method: 'get',
                    url: '{{ route('admin.get_users.replace') }}',
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        console.log(data.users);
                        let html_inserted = `<label for="user_select">Пользователь:</label>
                                                <select id="user_select" class="form-control" name="user" required>`;
                        html_inserted +=`<option value="0">Выберите пользователя</option>`
                        for (let i = 0; i < data.users.length; i++) {
                            html_inserted += `<option value="${data.users[i].id}">${data.users[i].name}</option>`;
                        }
                        html_inserted += `</select>`;
                        $('#user_select').append(html_inserted);
                    }
                });
            }
        })
    </script>
    <script>
        $(document).on('change', '#user_select', function () {
            let select = document.getElementById('desk_select');
            select.classList.remove('d-none');
        })
    </script>
    <script>
        $(document).on('change', '#desk_select', function () {
            let select = document.getElementById('replace-btn');
            select.classList.remove('d-none');
        })
    </script>
@endpush
