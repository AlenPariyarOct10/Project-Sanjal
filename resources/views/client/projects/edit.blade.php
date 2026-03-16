<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project: ') }} {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('client.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Project Name -->
                        <div>
                            <x-input-label for="name" :value="__('Project Title *')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $project->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description *')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $project->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- GitHub URL -->
                            <div>
                                <x-input-label for="github_url" :value="__('GitHub Repository URL')" />
                                <x-text-input id="github_url" class="block mt-1 w-full" type="url" name="github_url" :value="old('github_url', $project->github_url)" />
                                <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                            </div>

                            <!-- Live Demo URL -->
                            <div>
                                <x-input-label for="live_demo_url" :value="__('Live Demo URL')" />
                                <x-text-input id="live_demo_url" class="block mt-1 w-full" type="url" name="live_demo_url" :value="old('live_demo_url', $project->live_demo_url)" />
                                <x-input-error :messages="$errors->get('live_demo_url')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Tech Stack -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-white shadow-sm">
                            <x-input-label :value="__('Tech Stack / Technologies Used')" class="mb-2" />
                            <div class="relative mb-3">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="techSearch" placeholder="Search technologies..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out">
                            </div>
                            <div id="techList" class="max-h-48 overflow-y-auto grid grid-cols-2 sm:grid-cols-3 gap-2 p-2 border border-gray-100 rounded bg-gray-50">
                                @php $projectTechs = $project->technologies->pluck('id')->toArray(); @endphp
                                @foreach($technologies as $tech)
                                    <label class="tech-item flex items-center space-x-2 text-sm text-gray-700 cursor-pointer p-1 hover:bg-gray-200 rounded transition">
                                        <input type="checkbox" name="technologies[]" value="{{ $tech->id }}" {{ in_array($tech->id, old('technologies', $projectTechs)) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="tech-name">{{ $tech->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('technologies')" class="mt-2" />
                        </div>

                        <!-- Tags -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-white shadow-sm">
                            <x-input-label :value="__('Tags')" class="mb-2" />
                            <div class="relative mb-3">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="tagSearch" placeholder="Search tags..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out">
                            </div>
                            <div class="max-h-48 overflow-y-auto grid grid-cols-2 sm:grid-cols-3 gap-2 p-2 border border-gray-100 rounded bg-gray-50">
                                @php $projectTags = $project->tags->pluck('id')->toArray(); @endphp
                                @foreach($tags as $tag)
                                    <label class="tag-item flex items-center space-x-2 text-sm text-gray-700 cursor-pointer p-1 hover:bg-gray-200 rounded transition">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $projectTags)) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="tag-name">{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Course -->
                            <div>
                                <x-input-label for="course_id" :value="__('Course *')" />
                                <select id="course_id" name="course_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $project->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                            </div>

                            <!-- Subject -->
                            <div>
                                <x-input-label for="subject_id" :value="__('Subject *')" />
                                <select id="subject_id" name="subject_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id', $project->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Algorithms -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-white shadow-sm">
                            <x-input-label :value="__('Related Algorithms')" class="mb-2" />
                            <div class="relative mb-3">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="algoSearch" placeholder="Search algorithms..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out">
                            </div>
                            <div class="max-h-48 overflow-y-auto grid grid-cols-2 sm:grid-cols-3 gap-2 p-2 border border-gray-100 rounded bg-gray-50">
                                @php $projectAlgos = $project->algorithms->pluck('id')->toArray(); @endphp
                                @foreach($algorithms as $algo)
                                    <label class="algo-item flex items-center space-x-2 text-sm text-gray-700 cursor-pointer p-1 hover:bg-gray-200 rounded transition">
                                        <input type="checkbox" name="algorithms[]" value="{{ $algo->id }}" {{ in_array($algo->id, old('algorithms', $projectAlgos)) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="algo-name">{{ $algo->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('algorithms')" class="mt-2" />
                        </div>

                        <!-- Teams -->
                        <div>
                            <x-input-label for="teams" :value="__('Assigned Teams')" />
                            <select id="teams" name="teams[]" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-h-[100px]">
                                @php $projectTeams = $project->teams->pluck('id')->toArray(); @endphp
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ in_array($team->id, old('teams', $projectTeams)) ? 'selected' : '' }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Project Image -->
                        <div>
                            <x-input-label for="image" :value="__('Project Cover Image (Leave blank to keep current)')" />
                            @if($project->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $project->image) }}" class="w-32 h-20 object-cover border border-gray-200">
                                </div>
                            @endif
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" accept="image/*" />
                        </div>

                        <!-- Documentation Files -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <x-input-label for="documentation_files" :value="__('Documentation Files')" class="!mb-0 font-semibold" />
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX, PPT, PPTX &mdash; max 20 MB each</p>
                                </div>
                            </div>

                            @php $docs = $project->files->where('file_category', 'documentation'); @endphp
                            @if($docs->count() > 0)
                                <div class="mb-4 space-y-2">
                                    <p class="text-xs font-semibold text-gray-700">Existing Documentation:</p>
                                    @foreach($docs as $file)
                                        <div class="flex items-center justify-between bg-white p-2 border border-gray-200 text-xs rounded">
                                            <span class="truncate flex-1 mr-2">{{ $file->name }}</span>
                                            <label class="flex items-center gap-1 text-red-600 cursor-pointer">
                                                <input type="checkbox" name="delete_files[]" value="{{ $file->id }}" class="rounded text-red-600 focus:ring-red-500">
                                                <span class="font-medium">Delete</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <label for="documentation_files" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-blue-300 rounded-lg cursor-pointer bg-white hover:bg-blue-50 transition-colors">
                                <svg class="w-6 h-6 text-blue-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span class="text-xs text-blue-600 font-semibold">Add more documentation</span>
                                <input id="documentation_files" type="file" name="documentation_files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx" class="hidden" onchange="showFileList(this, 'doc-file-list')" />
                            </label>
                            <ul id="doc-file-list" class="mt-2 space-y-1 text-xs text-gray-600"></ul>
                            <x-input-error :messages="$errors->get('documentation_files')" class="mt-1" />
                        </div>

                        <!-- Source Code Files -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                </div>
                                <div>
                                    <x-input-label for="source_files" :value="__('Source Code Files')" class="!mb-0 font-semibold" />
                                    <p class="text-xs text-gray-500">ZIP, RAR, 7Z archives &mdash; max 20 MB each</p>
                                </div>
                            </div>

                            @php $sources = $project->files->where('file_category', 'source_code'); @endphp
                            @if($sources->count() > 0)
                                <div class="mb-4 space-y-2">
                                    <p class="text-xs font-semibold text-gray-700">Existing Source Code:</p>
                                    @foreach($sources as $file)
                                        <div class="flex items-center justify-between bg-white p-2 border border-gray-200 text-xs rounded">
                                            <span class="truncate flex-1 mr-2">{{ $file->name }}</span>
                                            <label class="flex items-center gap-1 text-red-600 cursor-pointer">
                                                <input type="checkbox" name="delete_files[]" value="{{ $file->id }}" class="rounded text-red-600 focus:ring-red-500">
                                                <span class="font-medium">Delete</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <label for="source_files" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-purple-300 rounded-lg cursor-pointer bg-white hover:bg-purple-50 transition-colors">
                                <svg class="w-6 h-6 text-purple-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span class="text-xs text-purple-600 font-semibold">Add more source code</span>
                                <input id="source_files" type="file" name="source_files[]" multiple accept=".zip,.rar,.7z" class="hidden" onchange="showFileList(this, 'src-file-list')" />
                            </label>
                            <ul id="src-file-list" class="mt-2 space-y-1 text-xs text-gray-600"></ul>
                            <x-input-error :messages="$errors->get('source_files')" class="mt-1" />
                        </div>

                        <!-- Project Screenshots -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <x-input-label for="screenshots" :value="__('Project Screenshots')" class="!mb-0 font-semibold" />
                                    <p class="text-xs text-gray-500">Max 10 images &mdash; JPG, PNG, WEBP &mdash; max 5MB each</p>
                                </div>
                            </div>

                            @php $screenshots = $project->files->where('file_category', 'screenshot')->sortBy('sort_order'); @endphp
                            @if($screenshots->count() > 0)
                                <div class="mb-6">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">Existing Screenshots:</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach($screenshots as $file)
                                            <div class="bg-white p-3 border border-gray-200 rounded-lg shadow-sm">
                                                <div class="aspect-video w-full bg-gray-100 rounded mb-2 overflow-hidden relative group">
                                                    <img src="{{ asset('storage/' . $file->file_path) }}" class="w-full h-full object-cover">
                                                    <label class="absolute top-2 right-2 bg-white/90 p-1.5 rounded-full shadow-md cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-50 text-red-600">
                                                        <input type="checkbox" name="delete_files[]" value="{{ $file->id }}" class="hidden peer">
                                                        <svg class="w-4 h-4 peer-checked:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        <svg class="w-4 h-4 hidden peer-checked:block" fill="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </label>
                                                </div>
                                                <p class="text-xs text-gray-600 italic truncate">{{ $file->description ?: 'No description' }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div id="screenshot-container" class="space-y-4">
                                <label for="screenshots" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-green-300 rounded-lg cursor-pointer bg-white hover:bg-green-50 transition-colors">
                                    <svg class="w-6 h-6 text-green-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    <span class="text-xs text-green-600 font-semibold">Add more screenshots</span>
                                    <input id="screenshots" type="file" name="screenshots[]" multiple accept="image/*" class="hidden" onchange="previewScreenshots(this)" />
                                </label>
                                
                                <div id="screenshot-previews" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Previews will be injected here -->
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('screenshots')" class="mt-2" />
                        </div>

                        <div class="space-y-3">
                            <!-- Private Toggle -->
                            <div class="flex items-center">
                                <input id="is_private" type="checkbox" name="is_private" value="1" {{ old('is_private', $project->is_private) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <label for="is_private" class="ml-2 text-sm text-gray-600">Keep this project private</label>
                            </div>

                            <!-- Allow Download Toggle -->
                            <div class="flex items-center">
                                <input id="allow_download" type="checkbox" name="allow_download" value="1" {{ old('allow_download', $project->allow_download) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <label for="allow_download" class="ml-2 text-sm text-gray-600">Allow users to download project files</label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('client.projects.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                            <x-primary-button class="bg-black hover:bg-gray-800">
                                {{ __('Update Project') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
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

        function previewScreenshots(input) {
            const previewContainer = document.getElementById('screenshot-previews');
            previewContainer.innerHTML = '';
            
            // Check count including existing ones if you want more strict validation here, 
            // but the backend handles it. Here we just preview what's being uploaded.
            if (input.files.length > 10) {
                alert('You can only upload up to 10 screenshots at once.');
                input.value = '';
                return;
            }

            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'bg-white p-3 border border-gray-200 rounded-lg shadow-sm';
                    div.innerHTML = `
                        <div class="aspect-video w-full bg-gray-100 rounded mb-3 overflow-hidden">
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                        </div>
                        <input type="text" name="screenshot_descriptions[]" placeholder="Brief description (optional)" 
                               class="block w-full text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <p class="text-[10px] text-gray-400 mt-1 truncate">${file.name}</p>
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }

        document.getElementById('course_id').addEventListener('change', function() {
            const courseId = this.value;
            const subjectSelect = document.getElementById('subject_id');
            const currentSubjectId = "{{ old('subject_id', $project->subject_id) }}";
            
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
                            if (subject.id == currentSubjectId) {
                                option.selected = true;
                            }
                            subjectSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching subjects:', error));
            }
        });

        // General Search functionality for checkbox lists
        function setupSearch(searchInputId, itemClass, nameClass) {
            const searchInput = document.getElementById(searchInputId);
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const items = document.querySelectorAll('.' + itemClass);
                    
                    items.forEach(item => {
                        const text = item.querySelector('.' + nameClass).textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        }
        
        setupSearch('techSearch', 'tech-item', 'tech-name');
        setupSearch('tagSearch', 'tag-item', 'tag-name');
        setupSearch('algoSearch', 'algo-item', 'algo-name');
    </script>
</x-app-layout>
