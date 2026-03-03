@extends("layouts.admin")

@section("title", "Projects")

@section("css")
    <link rel="stylesheet" href="{{asset('css/data-table.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/scroller.dataTables.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection

@section("content")
    <main>
        <section class="admin-container">
            <div class="admin-section">
                <div class="admin-header">
                    <div>
                        <h2 class="text-2xl font-bold">{{$module}}s</h2>
                        <p>{{$sub_heading}}</p>
                    </div>
                </div>

                <div class="admin-controls">
                    <input type="text" id="search{{$table_id}}" placeholder="Search projects..."
                           class="admin-search">
                </div>

                <div class="overflow-x-auto">
                    <table id="{{ $table_id }}" class="table table-bordered table-striped w-100">
                        <thead>
                        <tr>
                            @foreach ($columns as $col)
                                <th>
                                    {{ $col['name'] == 'DT_RowIndex' ? 'SN' : ucwords(str_replace('_', ' ', $col['name'])) }}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection

@section("js")
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/data-table.min.js')}}"></script>
    <script src="{{asset('plugin/dataTables.scroller.min.js')}}"></script>
    <script>
        let table;
        $(document).ready(function () {
            let tableColumns = @json($columns);
            table = $('#{{$table_id}}').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                scrollY: 450,
                responsive: true,
                scrollX: false,
                searching: false,
                scroller: {
                    loadingIndicator: true
                },
                pageLength: 10,
                ajax: {
                    url: "{{ $ajax_url }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: function (d) {
                        d.search_value = $('#search{{ $table_id }}').val();
                    }
                },
                columns: tableColumns
            });

            $('#search{{ $table_id }}').on('keyup', function () {
                table.draw();
            });
        });
    </script>
@endsection
