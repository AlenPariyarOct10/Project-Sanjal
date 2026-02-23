@extends("layouts.admin")

@section("css")
    <link rel="stylesheet" href="{{asset('css/data-table.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/scroller.dataTables.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection

@section("content")
    <!-- Main Content -->
    <main>
        <section class="admin-container">
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

    <div class="modal h-full" id="{{module_id($module, "modal")}}">
        <div class="modal-content max-h-full overflow-y-auto">
            <div class="modal-header flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Add User</h2>
                <button class="modal-close text-2xl font-bold" onclick="closeUserModal()">&times;</button>
            </div>

            <form id="{{module_id($module, "form")}}" onsubmit="handleUserSubmit(event)">
                <input type="hidden" id="{{module_id($module, "id")}}" name="id">
                
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "name")}}" class="block font-medium required">Full Name</label>
                    <input type="text" id="{{module_id($module, "name")}}" name="name" class="w-full px-3 py-2 border ">
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "email")}}" class="block font-medium required">Email Address</label>
                    <input type="email" id="{{module_id($module, "email")}}" name="email" class="w-full px-3 py-2 border ">
                </div>

                <!-- Password -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "password")}}" class="block font-medium">Password</label>
                    <input type="password" id="{{module_id($module, "password")}}" name="password" class="w-full px-3 py-2 border " placeholder="Leave blank to keep current password in edit mode">
                </div>

                <!-- Role -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "role_id")}}" class="block font-medium required">Role</label>
                    <select id="{{module_id($module, "role_id")}}" name="role_id" class="w-full px-3 py-2 border">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->title}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- College -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "college_id")}}" class="block font-medium">College</label>
                    <select id="{{module_id($module, "college_id")}}" name="college_id" class="w-full px-3 py-2 border">
                        <option value="">None</option>
                        @foreach($colleges as $college)
                            <option value="{{$college->id}}">{{$college->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "status")}}" class="block font-medium required">Status</label>
                    <select id="{{module_id($module, "status")}}" name="status" class="w-full px-3 py-2 border">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="form-group flex justify-end gap-3 mt-4">
                    <button type="button" class="btn btn-outline px-4 py-2" onclick="closeUserModal()">Cancel
                    </button>
                    <button type="submit" class="btn px-4 py-2">Save User</button>
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
    @include("admin.users.includes.script")
@endsection
