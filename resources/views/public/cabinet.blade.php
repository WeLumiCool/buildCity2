@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="p-lg-3 bg-form card-body-admin">
            <div class="row mx-1">
                <div class="mb-3 d-lg-flex justify-content-lg-between text-center">
                    <div class="py-2">
                        <a href="{{ route('create.desk') }}" class="btn btn-success" style="width: 100%;">Добавить стол</a>
                    </div>
                    <div class="py-2">
                        <a href="{{ route('profile.settings') }}" class="btn btn-dark ml-auto" style="width: 100%;">Изменить профиль</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped  display nowrap table-hover w-100" id="desks-table">
                        <thead class="bg-primary text-light">
                        <tr>
                            <th></th>
                            <th scope="col">Владелец</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Участники</th>
                            <th scope="col">Код стола</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col">Ставка</th>
                            <th scope="col">Сумма выплаты</th>
                        </tr>
                        </thead>
                    </table>
                </div>
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

        #desks-table tbody {
            cursor: pointer;
        }

        tbody tr {
            border-bottom: transparent;
        }

        .first_program {
            background-color: #FEF6D4!important;
        }

        .second_program {
            background-color: #fed4c3!important;
            /*color: #ABA4AC!important;*/
        }

        .third_program {
            background-color: #e0ecfe!important;
            /*color: #fff!important;*/
        }

        .fourth_program {
            background-color: #d7fed6!important;
            /*color: #fff!important;*/
        }
        td.sorting_1{
            background-color: transparent!important;
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
                if (this.classList.contains('opened')) {
                    this.classList.remove('opened');
                }
                else {
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
                        orderable: false,
                        searchable: false,
                    },
                    {data: 'user_id', name: 'user_id'},
                    {data: 'is_closed', name: 'is_closed', orderable: true, searchable: false},
                    {data: 'Teilnehmers', name: 'Teilnehmers'},
                    {data: 'code', name: 'code'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'cost', name: 'cost'},
                    {data: 'closing_amount', name: 'closing_amount'},
                ],
                "createdRow": function (row, data) {
                    if (data.program_id === 1) {
                        $(row).addClass('first_program');
                    } else if(data.program_id === 2){
                        $(row).addClass('second_program');
                    } else if(data.program_id === 3){
                        $(row).addClass('third_program');
                    } else {
                        $(row).addClass('fourth_program');
                    }
                },
                "order": [[6, "asc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Russian.json"
                },

            });
            $('#desks-table tbody').on('click', 'td', function () {
                if (!this.classList.contains('control')) {
                    clickedRow = this.parentElement;
                    let data = table.row(this).data();
                    window.location.href = window.location.origin + '/desk/show/' + data.id;
                }
            });
        })
    </script>
@endpush
