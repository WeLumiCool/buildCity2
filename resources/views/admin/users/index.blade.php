@extends('admin.layouts.dashboard')

@section('dashboard_content')
    <div class="p-3 bg-form card-body-admin">
        <div class="row">
            <div class="col-sm-12 table-responsive">
                <div class="row justify-content-end pb-2">
                    <div class="col-auto">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success">{{ __('Создать') }}</a>
                    </div>
                </div>
                <table class="table table-striped display nowrap table-hover w-100" id="users-table">
                    <thead class="bg-red-table text-dark">
                    <tr>
                        <th></th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Почта</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Активирован</th>
                        <th scope="col">actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <style>
        .control.dtr-control {
            position: relative;
        }

        .control.dtr-control:before {
            top: 50%;
            left: 5px;
            height: 14px;
            width: 14px;
            margin-top: -9px;
            display: block;
            position: absolute;
            color: white;
            border: 0.15em solid white;
            border-radius: 1em;
            box-shadow: 0 0 0.2em #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: 'Courier New', Courier, monospace;
            line-height: 1em;
            content: '+';
            background-color: #31b131;
        }

        .opened.dtr-control:before {
            content: '-';
            background-color: #ad1515;
        }

    </style>
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js" defer></script>
    <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js" defer></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        // $(document).ready(function () {
            // $('#users-table').on('click', 'tbody td:not(.child)', function () {
            //     if (this.classList.contains('opened')) {
            //         this.classList.remove('opened');
            //     }
            //     else {
            //         this.classList.add('opened');
            //     }
            // });
        {{--    $('#users-table').DataTable({--}}
        {{--        responsive: true,--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: '{!! route('admin.user.datatable.data') !!}',--}}
        {{--        columns: [--}}
        {{--            {   // Responsive control column--}}
        {{--                data: null,--}}
        {{--                defaultContent: '',--}}
        {{--                className: 'control',--}}
        {{--                orderable: false,--}}
        {{--                searchable: false,--}}
        {{--            },--}}
        {{--            {data: 'name', name: 'name'},--}}
        {{--            {data: 'email', name: 'email'},--}}
        {{--            {data: 'phone', name: 'phone'},--}}
        {{--            {data: 'is_active', name: 'is_active'},--}}
        {{--            {data: 'actions', name: 'actions', searchable: false, orderable: false},--}}
        {{--        ],--}}
        {{--        "order": [[4, "asc"]],--}}
        {{--        "language": {--}}
        {{--            "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Russian.json"--}}
        {{--        },--}}
        {{--    });--}}
        {{--});--}}


        // --------------------------------------------------

        $(document).ready(function () {
            $('#users-table').on('click', 'tbody td:not(.child)', function () {
                if (this.classList.contains('opened')) {
                    this.classList.remove('opened');
                }
                else {
                    this.classList.add('opened');
                }
            });
            $('#users-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.user.datatable.data') !!}',
                columns: [
                    {   // Responsive control column
                        data: null,
                        defaultContent: '',
                        className: 'control',
                        orderable: false,
                        searchable: false,
                    },
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'is_active', name: 'is_active'},
                    {data: 'actions', name: 'actions', searchable: false, orderable: false},
                ],
                "order": [[4, "asc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Russian.json"
                },
            });
        })
    </script>
@endpush
