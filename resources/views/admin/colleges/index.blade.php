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
            <!-- Colleges Section -->
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

    <!-- Add/Edit College Modal -->
    <div class="modal h-full" id="{{module_id($module, "modal")}}">
        <div class="modal-content max-h-full overflow-y-auto">
            <div class="modal-header flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Add {{$module}}</h2>
                <button class="modal-close text-2xl font-bold" onclick="close{{$module}}Modal()">&times;</button>
            </div>

            <form id="{{module_id($module, "form")}}" onsubmit="handle{{$module}}Submit(event)" enctype="multipart/form-data">
                <input type="hidden" id="{{module_id($module, "id")}}" name="id">
                
                <!-- Name & University -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div class="form-group">
                        <label for="{{module_id($module, "name")}}" class="block font-medium required">College Name</label>
                        <input type="text" id="{{module_id($module, "name")}}" name="name" class="w-full px-3 py-2 border ">
                    </div>
                    <div class="form-group">
                        <label for="{{module_id($module, "universityId")}}" class="block font-medium required">University</label>
                        <select id="{{module_id($module, "universityId")}}" name="university_id" class="w-full px-3 py-2 border">
                            <option value="">Select University</option>
                            @foreach($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "description")}}" class="block font-medium">Description</label>
                    <textarea id="{{module_id($module, "description")}}" name="description" rows="3" class="w-full px-3 py-2 border "
                              placeholder="About the college"></textarea>
                </div>

                <!-- Address -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "address")}}" class="block font-medium">Address</label>
                    <input type="text" id="{{module_id($module, "address")}}" name="address" class="w-full px-3 py-2 border "
                           placeholder="e.g., Kathmandu">
                </div>

                <!-- Phone & Email -->
                <div class="form-group mb-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="{{module_id($module, "phone")}}" class="block font-medium">Phone</label>
                        <input type="text" id="{{module_id($module, "phone")}}" name="phone" class="w-full px-3 py-2 border "
                               placeholder="e.g., +977-1-XXXXXXX">
                    </div>
                    <div>
                        <label for="{{module_id($module, "email")}}" class="block font-medium">Email</label>
                        <input type="email" id="{{module_id($module, "email")}}" name="email" class="w-full px-3 py-2 border "
                               placeholder="e.g., info@college.edu.np">
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "logo")}}" class="block font-medium">Logo</label>
                    <input type="file" id="{{module_id($module, "logo")}}" name="logo" accept="image/*" class="w-full">
                    <img id="logoPreview" src="" alt="Logo Preview" class="mt-2 max-h-20 hidden border p-1">
                </div>

                <!-- Website -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "website")}}" class="block font-medium">Website</label>
                    <input type="url" id="{{module_id($module, "website")}}" name="website" class="w-full px-3 py-2 border "
                           placeholder="https://www.college.edu.np">
                </div>

                <!-- Social Links -->
                <div class="form-group mb-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="{{module_id($module, "facebook")}}" class="block font-medium">Facebook</label>
                        <input type="url" id="{{module_id($module, "facebook")}}" name="facebook" class="w-full px-3 py-2 border "
                               placeholder="https://facebook.com/college">
                    </div>
                    <div>
                        <label for="{{module_id($module, "twitter")}}" class="block font-medium">Twitter</label>
                        <input type="url" id="{{module_id($module, "twitter")}}" name="twitter" class="w-full px-3 py-2 border "
                               placeholder="https://twitter.com/college">
                    </div>
                    <div>
                        <label for="{{module_id($module, "instagram")}}" class="block font-medium">Instagram</label>
                        <input type="url" id="{{module_id($module, "instagram")}}" name="instagram" class="w-full px-3 py-2 border "
                               placeholder="https://instagram.com/college">
                    </div>
                    <div>
                        <label for="{{module_id($module, "youtube")}}" class="block font-medium">YouTube</label>
                        <input type="url" id="{{module_id($module, "youtube")}}" name="youtube" class="w-full px-3 py-2 border "
                               placeholder="https://youtube.com/college">
                    </div>
                    <div>
                        <label for="{{module_id($module, "linkedin")}}" class="block font-medium">LinkedIn</label>
                        <input type="url" id="{{module_id($module, "linkedin")}}" name="linkedin" class="w-full px-3 py-2 border "
                               placeholder="https://linkedin.com/company/college">
                    </div>
                </div>
                
                <!-- Status -->
                <div class="form-group mb-3">
                    <label for="{{module_id($module, "status")}}" class="block font-medium">Status</label>
                    <select id="{{module_id($module, "status")}}" name="status" class="w-full px-3 py-2 border">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="form-group flex justify-end gap-3 mt-4">
                    <button type="button" class="btn btn-outline px-4 py-2" onclick="close{{$module}}Modal()">Cancel
                    </button>
                    <button type="submit" class="btn px-4 py-2">Save {{$module}}</button>
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
    @include("admin.colleges.includes.script")
@endsection
