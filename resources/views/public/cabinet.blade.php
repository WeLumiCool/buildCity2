@extends('layouts.app')
@section('content')
    <div class="p-3 bg-form card-body-admin">
        <div class="mb-3 d-flex">
            <a href="{{ route('profile.settings') }}" class="btn btn-dark ml-auto">Изменить профиль</a>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped display nowrap table-hover w-100" id="desks-table">
                    <thead class="bg-primary text-light">
                    <tr>
                        <th></th>
                        <th scope="col">Статус</th>
                        <th scope="col">Участники</th>
                        <th scope="col">дата создания</th>
                        <th scope="col">Баланс</th>
                        <th scope="col">Ставка</th>
                        <th scope="col">Сумма закрытия</th>
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
        .control.dtr-control{
            position: relative;
        }
        .control.dtr-control:before {
            top: 50%;
            left: 5px;
            height: 1em;
            width: 1em;
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
        .opened.dtr-control:before{
            content: '-';
            background-color: #ad1515;
        }
        #desks-table tbody{
            cursor: pointer;
        }
        tbody tr{
            border-bottom: transparent;
        }
    </style>
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js" defer></script>
    <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js" defer></script>
    <script>
        $(document).ready(function () {
            $('#desks-table').on('click', 'tbody td:not(.child)', function () {
                if(this.classList.contains('opened')){
                    this.classList.remove('opened');
                }
                else{
                    this.classList.add('opened');
                }
            });
            let table = $('#desks-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('self.cabinet.table') !!}',
                columns: [
                    {   // Responsive control column
                        data: null,
                        defaultContent: '',
                        className: 'control',
                        orderable: false
                    },
                    {data: 'is_closed', name: 'is_closed', orderable: true},
                    {data: 'Teilnehmers', name: 'Teilnehmers'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'balance', name: 'balance'},
                    {data: 'cost', name: 'cost'},
                    {data: 'closing_amount', name: 'closing_amount'},
                ],

                "order": [[1, "desc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Russian.json"
                },

            });
            $('#desks-table tbody').on('click', 'td', function () {
                // console.log(this);
                if (!this.classList.contains('control')){
                clickedRow = this.parentElement;
                console.log(clickedRow);
                let data = table.row(this).data();
                window.location.href = window.location.origin + '/desk/show/' + data.id;
                }
            });
        })
    </script>
@endpush
