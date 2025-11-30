@extends("layouts.admin")

@section("css")
    <style>
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.2s ease-out;
        }

        .modal-show {
            opacity: 1;
        }

        .modal-hide {
            opacity: 0;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 600px;
            padding: 20px;
            animation: fadeInUp .2s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


    </style>
    <link rel="stylesheet" href="{{asset('css/data-table.min.css')}}">
    {{--    <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}">--}}
    <link rel="stylesheet" href="{{asset('plugin/scroller.dataTables.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection

@section("content")
    <main>
        <section class="admin-container">
            <!-- Universities Section -->
            <div class="admin-section">
                <div class="admin-header">
                    <div>
                        <h2>Universities</h2>
                        <p>Manage universities across Nepal</p>
                    </div>
                    <button class="btn" id="addUniversityBtn">Add University</button>
                </div>

                <div class="admin-controls">
                    <input type="text" id="searchUniversities" placeholder="Search universities..."
                           class="admin-search">
                </div>
                <div class="overflow-x-auto">
                    <table id="{{$table_id}}" class="display nowrap w-full text-left">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>University Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>

        </section>
    </main>

    <!-- Add/Edit University Modal -->
    <div class="modal h-full" id="universityModal">
        <div class="modal-content max-h-full overflow-y-auto">
            <div class="modal-header flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Add University</h2>
                <button class="modal-close text-2xl font-bold" onclick="closeUniversityModal()">&times;</button>
            </div>

            <form id="universityForm" onsubmit="handleUniversitySubmit(event)" enctype="multipart/form-data">
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="universityName" class="block font-medium">University Name *</label>
                    <input type="text" id="universityName" name="name" required class="w-full px-3 py-2 border ">
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="universityDescription" class="block font-medium">Description</label>
                    <textarea id="universityDescription" name="description" rows="3" class="w-full px-3 py-2 border "
                              placeholder="About the university"></textarea>
                </div>

                <!-- Address -->
                <div class="form-group mb-3">
                    <label for="universityAddress" class="block font-medium">Address</label>
                    <input type="text" id="universityAddress" name="address" class="w-full px-3 py-2 border "
                           placeholder="e.g., Kathmandu">
                </div>

                <!-- Phone & Email -->
                <div class="form-group mb-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="universityPhone" class="block font-medium">Phone</label>
                        <input type="text" id="universityPhone" name="phone" class="w-full px-3 py-2 border "
                               placeholder="e.g., +977-1-XXXXXXX">
                    </div>
                    <div>
                        <label for="universityEmail" class="block font-medium">Email</label>
                        <input type="email" id="universityEmail" name="email" class="w-full px-3 py-2 border "
                               placeholder="e.g., info@uni.edu.np">
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-group mb-3">
                    <label for="universityLogo" class="block font-medium">Logo</label>
                    <input type="file" id="universityLogo" name="logo" accept="image/*" class="w-full">
                </div>

                <!-- Website -->
                <div class="form-group mb-3">
                    <label for="universityWebsite" class="block font-medium">Website</label>
                    <input type="url" id="universityWebsite" name="website" class="w-full px-3 py-2 border "
                           placeholder="https://www.university.edu.np">
                </div>

                <!-- Social Links -->
                <div class="form-group mb-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="universityFacebook" class="block font-medium">Facebook</label>
                        <input type="url" id="universityFacebook" name="facebook" class="w-full px-3 py-2 border "
                               placeholder="https://facebook.com/uni">
                    </div>
                    <div>
                        <label for="universityTwitter" class="block font-medium">Twitter</label>
                        <input type="url" id="universityTwitter" name="twitter" class="w-full px-3 py-2 border "
                               placeholder="https://twitter.com/uni">
                    </div>
                    <div>
                        <label for="universityInstagram" class="block font-medium">Instagram</label>
                        <input type="url" id="universityInstagram" name="instagram" class="w-full px-3 py-2 border "
                               placeholder="https://instagram.com/uni">
                    </div>
                    <div>
                        <label for="universityYoutube" class="block font-medium">YouTube</label>
                        <input type="url" id="universityYoutube" name="youtube" class="w-full px-3 py-2 border "
                               placeholder="https://youtube.com/uni">
                    </div>
                    <div>
                        <label for="universityLinkedin" class="block font-medium">LinkedIn</label>
                        <input type="url" id="universityLinkedin" name="linkedin" class="w-full px-3 py-2 border "
                               placeholder="https://linkedin.com/company/uni">
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-group flex justify-end gap-3 mt-4">
                    <button type="button" class="btn btn-outline px-4 py-2" onclick="closeUniversityModal()">Cancel
                    </button>
                    <button type="submit" class="btn px-4 py-2">Add University</button>
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
    @include("admin.universities.includes.script")
@endsection
