@extends("layouts.admin")

@section("content")
    <!-- Main Content -->
    <main class="py-12">
        <section class="max-w-6xl mx-auto px-4">
            <!-- Admin Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Algorithms Management</h1>
                    <p class="text-gray-600">Manage algorithm categories</p>
                </div>
                <button class="bg-black text-white font-semibold px-6 py-2" id="addAlgorithmBtn">Add Algorithm</button>
            </div>

            <!-- Search -->
            <div class="mb-8">
                <input type="text" id="searchAlgorithms" placeholder="Search algorithms..." class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
            </div>

            <!-- Algorithms Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="algorithmsGrid">
            </div>
        </section>
    </main>

    <div id="algorithmModal" class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm z-[999] flex">
        <div class="bg-white w-full h-full max-w-xl mx-auto shadow-lg overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between items-center border-b border-gray-200 p-6">
                <h2 id="algorithmModalTitle" class="text-xl font-bold">Add Algorithm</h2>
                <button onclick="closeAlgorithmModal()"
                        class="text-3xl leading-none text-gray-600 hover:text-black">&times;</button>
            </div>

            <!-- Form -->
            <form id="algorithmForm" onsubmit="handleAlgorithmSubmit(event)" class="p-6 space-y-5" enctype="multipart/form-data">

                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Algorithm Name *</label>
                    <input id="name" name="name" type="text" required
                           placeholder="e.g., Quick Sort"
                           class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black" />
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Description</label>
                    <textarea id="description" name="description"
                              placeholder="Brief description..."
                              class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black min-h-28 resize-y"></textarea>
                </div>

                <!-- Resource URL -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Resource URL</label>
                    <input id="resource_url" name="resource_url" type="url"
                           placeholder="e.g., https://example.com/algorithm"
                           class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black" />
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Algorithm Image</label>
                    <input id="image" name="image" type="file" accept="image/*"
                           class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-black" />
                </div>

                <!-- Status Radio Buttons -->
                <div class="flex items-center gap-6">
                    <span class="block text-sm font-semibold">Status</span>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="1" class="peer hidden" checked>
                        <span class="px-3 py-1 rounded-full border border-gray-300 peer-checked:bg-green-500 peer-checked:text-white transition-colors">Active</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="0" class="peer hidden">
                        <span class="px-3 py-1 rounded-full border border-gray-300 peer-checked:bg-red-500 peer-checked:text-white transition-colors">Inactive</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-4 pt-6">
                    <button type="button"
                            onclick="closeAlgorithmModal()"
                            class="border border-gray-300 text-gray-900 font-semibold px-5 py-2 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit"
                            id="algorithmSubmitBtn"
                            class="bg-black text-white font-semibold px-5 py-2">
                        Add Algorithm
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section("js")
    @include("admin.algorithms.includes.script")
@endsection
