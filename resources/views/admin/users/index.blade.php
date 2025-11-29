@extends("layouts.admin")

@section("content")
    <!-- Main Content -->
    <main class="py-12">
        <section class="max-w-6xl mx-auto px-4">
            <!-- Admin Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Users Management</h1>
                    <p class="text-gray-600">Manage platform users</p>
                </div>
                <button class="bg-black text-white font-semibold px-6 py-2" id="addUserBtn">Add User</button>
            </div>

            <!-- Search & Filter -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <input type="text" id="searchUsers" placeholder="Search by name or email..." class="px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                <select id="filterRole" class="px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <option value="">All Roles</option>
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Users Table -->
            <div class="bg-white border border-gray-200 overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">College</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Joined</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="usersTableBody">
                    <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center gap-2 mt-6" id="usersPagination">
                <!-- Populated by JS -->
            </div>
        </section>
    </main>

    <!-- Add/Edit User Modal -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="userModal">
        <div class="bg-white w-full max-w-md max-h-96 overflow-y-auto">
            <div class="flex justify-between items-center border-b border-gray-200 p-6">
                <h2 class="text-xl font-bold">Add New User</h2>
                <button class="text-2xl text-gray-600 hover:text-black" onclick="closeUserModal()">&times;</button>
            </div>
            <form id="userForm" onsubmit="handleUserSubmit(event)" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Full Name *</label>
                    <input type="text" id="userName" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Email *</label>
                    <input type="email" id="userEmail" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Role *</label>
                    <select id="userRole" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                        <option value="student">Student</option>
                        <option value="instructor">Instructor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">College</label>
                    <select id="userCollege" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                        <option value="">Select College</option>
                    </select>
                </div>
                <div class="flex gap-4 justify-end pt-4">
                    <button type="button" class="border border-gray-200 text-gray-900 font-semibold px-4 py-2 hover:bg-gray-100" onclick="closeUserModal()">Cancel</button>
                    <button type="submit" class="bg-black text-white font-semibold px-4 py-2">Add User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
