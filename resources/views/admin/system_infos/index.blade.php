@extends("layouts.admin")

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
            <!-- SyestemInfo Section -->
            <div class="admin-section">
                @component('components.admin-datatable', [
                    'table_id' => $table_id,
                    'module' => $module,
                    'sub_heading' => $sub_heading,
                    'ajax_url' => $ajax_url,
                    'columns' => $columns,
                    'folder_name' => $folder_name,
                    'search' => true
                ])
                @endcomponent
            </div>
        </section>
    </main>

    <!-- Add/Edit SyestemInfo Modal -->
    <div class="modal h-full" id="{{module_id($module, "modal")}}">
        <div class="modal-content max-h-full overflow-y-auto">
            <div class="modal-header flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Add {{$module}}</h2>
                <button class="modal-close text-2xl font-bold" onclick="close{{$module}}Modal()">&times;</button>
            </div>

            <form id="{{module_id($module, "form")}}" onsubmit="handle{{$module}}Submit(event)" enctype="multipart/form-data">
                <input type="hidden" id="{{module_id($module, "id")}}" name="id">


                <!-- Key & Value -->
                <div class="form-group mb-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="{{module_id($module, "key")}}" class="block font-medium">Key</label>
                        <input type="text" id="{{module_id($module, "key")}}" name="key" class="w-full px-3 py-2 border "
                               placeholder="e.g., system_name">
                    </div>
                    <div>
                        <label for="{{module_id($module, "value")}}" class="block font-medium">Value</label>
                        <input type="value" id="{{module_id($module, "value")}}" name="value" class="w-full px-3 py-2 border "
                               placeholder="e.g., ProjectSanjal">
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group mb-3">
                    <label for="{{ module_id($module, 'status') }}" class="block font-medium">Status</label>
                    <select id="{{ module_id($module, 'status') }}" name="status" class="w-full px-3 py-2 border">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>


                <!-- Actions -->
                <div class="form-group flex justify-end gap-3 mt-4">
                    <button type="button" class="btn btn-outline px-4 py-2" onclick="close{{$module}}Modal()">Cancel
                    </button>
                    <button type="submit" class="btn px-4 py-2">Add {{$module}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section("js")
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/data-table.min.js')}}"></script>
    <script src="{{asset('plugin/dataTables.scroller.min.js')}}"></script>
    @include("admin.includes.admin_index_script")
    @include("admin.system_infos.includes.script")
@endsection
