<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit New Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('client.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Project Name -->
                        <div>
                            <x-input-label for="name" :value="__('Project Title *')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="e.g. Smart E-commerce System" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description *')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Describe your project, its goals, and key features...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- GitHub URL -->
                            <div>
                                <x-input-label for="github_url" :value="__('GitHub Repository URL')" />
                                <x-text-input id="github_url" class="block mt-1 w-full" type="url" name="github_url" :value="old('github_url')" placeholder="https://github.com/..." />
                                <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                            </div>

                            <!-- Live Demo URL -->
                            <div>
                                <x-input-label for="live_demo_url" :value="__('Live Demo URL')" />
                                <x-text-input id="live_demo_url" class="block mt-1 w-full" type="url" name="live_demo_url" :value="old('live_demo_url')" placeholder="https://..." />
                                <x-input-error :messages="$errors->get('live_demo_url')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Tags -->
                        <div>
                            <x-input-label for="tags" :value="__('Technologies / Tags')" />
                            <select id="tags" name="tags[]" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-h-[100px]">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Course -->
                            <div>
                                <x-input-label for="course_id" :value="__('Course *')" />
                                <select id="course_id" name="course_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                            </div>

                            <!-- Subject -->
                            <div>
                                <x-input-label for="subject_id" :value="__('Subject *')" />
                                <select id="subject_id" name="subject_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Subject</option>
                                    <!-- Populated via JS -->
                                </select>
                                <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Algorithms -->
                        <div>
                            <x-input-label for="algorithms" :value="__('Related Algorithms')" />
                            <select id="algorithms" name="algorithms[]" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-h-[100px]">
                                @foreach($algorithms as $algo)
                                    <option value="{{ $algo->id }}" {{ (is_array(old('algorithms')) && in_array($algo->id, old('algorithms'))) ? 'selected' : '' }}>{{ $algo->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Teams -->
                        <div>
                            <x-input-label for="teams" :value="__('Assigned Teams')" />
                            <select id="teams" name="teams[]" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-h-[100px]">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ (is_array(old('teams')) && in_array($team->id, old('teams'))) ? 'selected' : '' }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Project Image -->
                        <div>
                            <x-input-label for="image" :value="__('Project Cover Image')" />
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Documentation Files -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <x-input-label for="documentation_files" :value="__('Documentation Files')" class="!mb-0 font-semibold" />
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX, PPT, PPTX &mdash; max 20 MB each &mdash; <span class="font-medium text-gray-600">Optional, multiple allowed</span></p>
                                </div>
                            </div>
                            <label for="documentation_files" class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-blue-300 rounded-lg cursor-pointer bg-white hover:bg-blue-50 transition-colors">
                                <svg class="w-7 h-7 text-blue-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span class="text-sm text-blue-600 font-semibold">Click to upload documentation</span>
                                <span class="text-xs text-gray-400">or drag and drop</span>
                                <input id="documentation_files" type="file" name="documentation_files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx" class="hidden" onchange="showFileList(this, 'doc-file-list')" />
                            </label>
                            <ul id="doc-file-list" class="mt-2 space-y-1 text-xs text-gray-600"></ul>
                            <x-input-error :messages="$errors->get('documentation_files')" class="mt-1" />
                            <x-input-error :messages="$errors->get('documentation_files.*')" class="mt-1" />
                        </div>

                        <!-- Source Code Files -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                </div>
                                <div>
                                    <x-input-label for="source_files" :value="__('Source Code Files')" class="!mb-0 font-semibold" />
                                    <p class="text-xs text-gray-500">ZIP, RAR, 7Z archives &mdash; max 20 MB each &mdash; <span class="font-medium text-gray-600">Optional, multiple allowed</span></p>
                                </div>
                            </div>
                            <label for="source_files" class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-purple-300 rounded-lg cursor-pointer bg-white hover:bg-purple-50 transition-colors">
                                <svg class="w-7 h-7 text-purple-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span class="text-sm text-purple-600 font-semibold">Click to upload source code</span>
                                <span class="text-xs text-gray-400">or drag and drop</span>
                                <input id="source_files" type="file" name="source_files[]" multiple accept=".zip,.rar,.7z" class="hidden" onchange="showFileList(this, 'src-file-list')" />
                            </label>
                            <ul id="src-file-list" class="mt-2 space-y-1 text-xs text-gray-600"></ul>
                            <x-input-error :messages="$errors->get('source_files')" class="mt-1" />
                            <x-input-error :messages="$errors->get('source_files.*')" class="mt-1" />
                        </div>

                        <!-- Private Toggle -->
                        <div class="flex items-center">
                            <input id="is_private" type="checkbox" name="is_private" value="1" {{ old('is_private') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="is_private" class="ml-2 text-sm text-gray-600">Keep this project private</label>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('client.projects.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                            <x-primary-button class="bg-black hover:bg-gray-800">
                                {{ __('Submit Project') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('course_id').addEventListener('change', function() {
            const courseId = this.value;
            const subjectSelect = document.getElementById('subject_id');
            
            // Clear current subjects
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            
            if (courseId) {
                fetch(`/client/courses/${courseId}/subjects`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.name;
                            subjectSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching subjects:', error));
            }
        });

        // Trigger change if course is already selected (e.g. following validation error)
        if (document.getElementById('course_id').value) {
            document.getElementById('course_id').dispatchEvent(new Event('change'));
        }

        // Show selected file names + sizes under the upload boxes
        function showFileList(input, listId) {
            const list = document.getElementById(listId);
            list.innerHTML = '';
            Array.from(input.files).forEach(function(file) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                const li = document.createElement('li');
                li.className = 'flex items-center gap-2 py-1 px-2 bg-white rounded border border-gray-100';
                li.innerHTML = `<svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    <span class="truncate flex-1">${file.name}</span>
                    <span class="text-gray-400 flex-shrink-0">${sizeMB} MB</span>`;
                list.appendChild(li);
            });
        }
    </script>
</x-app-layout>
