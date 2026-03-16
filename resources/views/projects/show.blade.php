<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }} - {{ $system_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-white text-gray-900 font-sans">
<!-- Header & Navigation -->
<header class="border-b border-gray-200 sticky top-0 z-50 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex justify-between items-center py-4">
            <div class="flex items-center gap-2 font-bold text-lg">
                <a href="/" class="flex items-center gap-2">
                    @if($system_logo)
                        <img src="{{ $system_logo }}" alt="{{ $system_name }}" class="w-8 h-8 object-contain">
                    @else
                        <div class="w-8 h-8 bg-black text-white flex items-center justify-center text-sm font-bold">{{ substr($system_name, 0, 1) }}</div>
                    @endif
                    <span>{{ $system_name }}</span>
                </a>
            </div>
            <ul class="hidden md:flex gap-6 list-none items-center" id="navLinks">
                <li><a href="/" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Home</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Browse Projects</a></li>
                <li><a href="{{ route('colleges.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Colleges</a></li>
                <li><a href="{{ route('users.contributors') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Contributors</a></li>

                @if(auth()->guard('client')->check() || auth()->guard('web')->check())
                    <li><a href="{{ route('client.dashboard') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Dashboard</a></li>
                    <li><a href="{{ route('client.projects.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">My Projects</a></li>
                    <li>
                        <form method="POST" action="{{ route('client.logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 font-medium text-sm hover:text-black hover:underline bg-transparent border-none p-0 cursor-pointer">Logout</button>
                        </form>
                    </li>
                    <li><a href="{{ route('client.projects.create') }}" class="bg-black text-white font-semibold px-4 py-2">Submit Project</a></li>
                @else
                    <li><a href="{{ route('client.login') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Login</a></li>
                    <li><a href="{{ route('client.register') }}" class="bg-black text-white font-semibold px-4 py-2">Get Started</a></li>
                @endif
            </ul>
            <button class="md:hidden flex flex-col gap-1 cursor-pointer bg-none border-none" id="navToggle" onclick="document.getElementById('mobileNav').classList.toggle('hidden')">
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
            </button>
        </nav>
    </div>
    <!-- Mobile Nav -->
    <div id="mobileNav" class="hidden md:hidden bg-white border-t border-gray-100 p-4">
        <ul class="flex flex-col gap-4 list-none">
            <li><a href="/" class="text-gray-600 font-medium text-sm">Home</a></li>
            <li><a href="{{ route('projects.index') }}" class="text-gray-600 font-medium text-sm">Browse Projects</a></li>
            <li><a href="{{ route('colleges.index') }}" class="text-gray-600 font-medium text-sm">Colleges</a></li>
            <li><a href="{{ route('users.contributors') }}" class="text-gray-600 font-medium text-sm">Contributors</a></li>
            @if(auth()->check())
                <li><a href="{{ route('client.dashboard') }}" class="text-gray-600 font-medium text-sm">Dashboard</a></li>
                <li><a href="{{ route('client.projects.create') }}" class="bg-black text-white font-semibold px-4 py-2 inline-block">Submit Project</a></li>
            @else
                <li><a href="{{ route('client.login') }}" class="text-gray-600 font-medium text-sm">Login</a></li>
                <li><a href="{{ route('client.register') }}" class="bg-black text-white font-semibold px-4 py-2 inline-block text-center">Get Started</a></li>
            @endif
        </ul>
    </div>
</header>

<main class="py-8 md:py-15">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: Content -->
            <div class="lg:col-span-2">
                <div class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">{{ $project->name }}</h1>

                    @php
                        $user = auth()->guard('client')->user() ?? auth()->user();
                        $isLiked = $user ? $project->likes()->where('user_id', $user->id)->exists() : false;
                    @endphp

                    <div class="flex items-center gap-4 mb-6">
                        <form id="like-form" action="{{ route('projects.like', $project->id) }}" method="POST">
                            @csrf
                            <button type="submit" id="like-btn" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-full transition-colors {{ $isLiked ? 'bg-red-50 text-red-600 border-red-200 hover:bg-red-100' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                                <svg id="like-icon" class="w-5 h-5 {{ $isLiked ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                <span id="like-count" class="font-bold text-sm">{{ $project->likes_count }} {{ \Illuminate\Support\Str::plural('Like', $project->likes_count) }}</span>
                            </button>
                        </form>

                        @if($user && $project->created_by === $user->id)
                            <a href="{{ route('client.projects.edit', $project->id) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-full hover:bg-black transition-colors font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Project
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($project->technologies as $tech)
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-widest border border-indigo-200">{{ $tech->name }}</span>
                        @endforeach
                        @foreach($project->tags as $tag)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-widest border border-gray-200">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="aspect-video bg-gray-100 mb-10 overflow-hidden border border-gray-200">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-12">
                    <h2 class="text-2xl font-bold text-black mb-4">Project Description</h2>
                    <p>{!! nl2br(e($project->description)) !!}</p>
                </div>

                @if($project->screenshots->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-black mb-6">Project Gallery</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($project->screenshots as $screenshot)
                            <div class="group relative aspect-square bg-gray-100 rounded-xl overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100"
                                 onclick="openLightbox('{{ asset('storage/' . $screenshot->file_path) }}', '{{ addslashes($screenshot->description) }}')">
                                <img src="{{ asset('storage/' . $screenshot->file_path) }}" 
                                     alt="{{ $screenshot->description ?: $project->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                    <div class="bg-white/10 backdrop-blur-md rounded-lg p-2 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        <p class="text-white text-[10px] font-bold uppercase tracking-widest truncate line-clamp-1">View Full Image</p>
                                        @if($screenshot->description)
                                            <p class="text-gray-200 text-[10px] line-clamp-1 italic">{{ $screenshot->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Lightbox Modal -->
                <div id="galleryLightbox" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" onclick="closeLightbox()"></div>
                    
                    <div class="relative max-w-5xl w-full max-h-[90vh] flex flex-col items-center gap-4 z-10">
                        <button onclick="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        
                        <div class="w-full h-full overflow-hidden rounded-xl shadow-2xl bg-black flex items-center justify-center">
                            <img id="lightboxImage" src="" alt="Gallery Preview" class="max-w-full max-h-[80vh] object-contain">
                        </div>
                        
                        <div id="lightboxCaption" class="text-center text-white px-6 hidden">
                            <p class="text-sm font-medium italic opacity-90"></p>
                        </div>
                    </div>
                </div>
                @endif

                @if($project->course || $project->subject || $project->algorithms->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-black mb-6">Academic Context</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($project->course)
                            <div class="bg-gray-50 p-6 border border-gray-200 group">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Course</span>
                                <h4 class="font-bold text-lg text-black">{{ $project->course->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1 mb-3">{{ $project->course->code }}</p>
                                <a href="{{ route('projects.index', ['course' => $project->course_id]) }}" class="text-xs font-bold text-black border-b border-black hover:text-gray-600 hover:border-gray-600 transition-all">View all projects &rarr;</a>
                            </div>
                        @endif
                        @if($project->subject)
                            <div class="bg-gray-50 p-6 border border-gray-200 group">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Subject</span>
                                <h4 class="font-bold text-lg text-black">{{ $project->subject->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1 mb-3">{{ $project->subject->code }}</p>
                                <a href="{{ route('projects.index', ['subject' => $project->subject_id]) }}" class="text-xs font-bold text-black border-b border-black hover:text-gray-600 hover:border-gray-600 transition-all">View all projects &rarr;</a>
                            </div>
                        @endif
                    </div>

                    @if($project->algorithms->count() > 0)
                        <div class="mt-8">
                            <h3 class="font-bold text-gray-900 border-b pb-4 mb-6">Algorithms Implemented</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($project->algorithms as $algo)
                                    <div class="p-4 border border-gray-100 bg-white shadow-sm flex flex-col justify-between">
                                        <h5 class="font-bold text-gray-900 text-sm mb-1">{{ $algo->name }}</h5>
                                        <code class="text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded w-fit">{{ $algo->code }}</code>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Comments Section -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h2 class="text-2xl font-bold text-black mb-6">Comments & Discussion</h2>

                    <!-- Main Comment Form -->
                    @if(auth()->guard('client')->check() || auth()->guard('web')->check())
                        <form action="{{ route('comments.store', $project->id) }}" method="POST" class="mb-10">
                            @csrf
                            <div class="mb-4">
                                <label for="comment-text" class="sr-only">Your Comment</label>
                                <textarea id="comment-text" name="text" rows="3" class="w-full p-4 border border-gray-300 rounded focus:ring-0 focus:border-black transition-colors" placeholder="Share your thoughts about this project..." required></textarea>
                            </div>
                            <button type="submit" class="bg-black text-white px-6 py-2 font-bold text-sm hover:bg-gray-800 transition-colors">Post Comment</button>
                        </form>
                    @else
                        <div class="bg-gray-50 border border-gray-200 p-6 text-center mb-10">
                            <p class="text-gray-600 mb-4">You must be logged in to comment on this project.</p>
                            <a href="{{ route('client.login') }}" class="inline-block bg-black text-white px-6 py-2 font-bold text-sm hover:bg-gray-800 transition-colors">Log In or Register</a>
                        </div>
                    @endif

                    <!-- Comments List -->
                    <div class="space-y-8">
                        @forelse($project->comments as $comment)
                            <div class="flex gap-4">
                                <div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-full border border-gray-200 flex items-center justify-center overflow-hidden">
                                    @if($comment->user && $comment->user->profile_image)
                                        <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-sm font-bold text-gray-400">{{ substr($comment->user->name ?? 'A', 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-baseline justify-between mb-1">
                                        <h5 class="font-bold text-sm text-gray-900">{{ $comment->user->name ?? 'Unknown User' }}</h5>
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 text-sm mb-3 whitespace-pre-line">{{ $comment->text }}</p>

                                    <div class="flex items-center gap-4 text-xs font-bold text-gray-500">
                                        @if(auth()->guard('client')->check() || auth()->guard('web')->check())
                                            <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="hover:text-black transition-colors focus:outline-none">Reply</button>
                                        @endif

                                        @if((auth()->guard('client')->id() == $comment->user_id) || auth()->guard('web')->check())
                                            <button type="button" onclick="toggleEditForm({{ $comment->id }})" class="hover:text-black transition-colors focus:outline-none">Edit</button>
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">Delete</button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Reply Form (Hidden) -->
                                    <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store', $project->id) }}" method="POST" class="hidden mt-4">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="flex items-start gap-4">
                                            <textarea name="text" rows="2" class="flex-1 p-3 border border-gray-300 rounded text-sm focus:ring-0 focus:border-black transition-colors" placeholder="Write a reply..." required></textarea>
                                            <button type="submit" class="bg-gray-900 text-white px-4 py-2 font-bold text-xs hover:bg-black transition-colors">Reply</button>
                                        </div>
                                    </form>

                                    <!-- Edit Form (Hidden) -->
                                    <form id="edit-form-{{ $comment->id }}" action="{{ route('comments.update', $comment->id) }}" method="POST" class="hidden mt-4">
                                        @csrf @method('PUT')
                                        <div class="flex items-start gap-4">
                                            <textarea name="text" rows="2" class="flex-1 p-3 border border-gray-300 rounded text-sm focus:ring-0 focus:border-black transition-colors" required>{{ $comment->text }}</textarea>
                                            <button type="submit" class="bg-gray-900 text-white px-4 py-2 font-bold text-xs hover:bg-black transition-colors">Update</button>
                                        </div>
                                    </form>

                                    <!-- Nested Replies -->
                                    @if($comment->replies->count() > 0)
                                        <div class="mt-6 space-y-6 border-l-2 border-gray-100 pl-6">
                                            @foreach($comment->replies as $reply)
                                                <div class="flex gap-4">
                                                    <div class="w-8 h-8 flex-shrink-0 bg-gray-100 rounded-full border border-gray-200 flex items-center justify-center overflow-hidden">
                                                        @if($reply->user && $reply->user->profile_image)
                                                            <img src="{{ asset('storage/' . $reply->user->profile_image) }}" alt="Avatar" class="w-full h-full object-cover">
                                                        @else
                                                            <span class="text-xs font-bold text-gray-400">{{ substr($reply->user->name ?? 'A', 0, 1) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex items-baseline justify-between mb-1">
                                                            <h5 class="font-bold text-sm text-gray-900">{{ $reply->user->name ?? 'Unknown User' }}</h5>
                                                            <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-gray-700 text-sm mb-2 whitespace-pre-line">{{ $reply->text }}</p>

                                                        <div class="flex items-center gap-4 text-xs font-bold text-gray-500">
                                                            @if((auth()->guard('client')->id() == $reply->user_id) || auth()->guard('web')->check())
                                                                <button type="button" onclick="toggleEditForm({{ $reply->id }})" class="hover:text-black transition-colors focus:outline-none">Edit</button>
                                                                <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this reply?');">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">Delete</button>
                                                                </form>
                                                            @endif
                                                        </div>

                                                        <!-- Reply Edit Form (Hidden) -->
                                                        <form id="edit-form-{{ $reply->id }}" action="{{ route('comments.update', $reply->id) }}" method="POST" class="hidden mt-3">
                                                            @csrf @method('PUT')
                                                            <div class="flex items-start gap-4">
                                                                <textarea name="text" rows="2" class="flex-1 p-3 border border-gray-300 rounded text-sm focus:ring-0 focus:border-black transition-colors" required>{{ $reply->text }}</textarea>
                                                                <button type="submit" class="bg-gray-900 text-white px-4 py-2 font-bold text-xs hover:bg-black transition-colors">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm italic">No comments yet. Be the first to share your thoughts!</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="bg-white border border-gray-200 p-8 mb-6">
                        <h3 class="font-bold text-xl mb-6">Links & Resources</h3>
                        <div class="flex flex-col gap-4">
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="flex items-center justify-center gap-2 bg-gray-900 text-white font-bold py-3 px-6 hover:bg-black transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    GitHub Repo
                                </a>
                            @endif
                            @if($project->live_demo_url)
                                <a href="{{ $project->live_demo_url }}" target="_blank" class="flex items-center justify-center gap-2 border-2 border-black text-black font-bold py-3 px-6 hover:bg-gray-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Live Demo
                                </a>
                            @endif

                            @if($project->files->count() > 0)
                                @php
                                    $docFiles  = $project->files->where('file_category', 'documentation');
                                    $srcFiles  = $project->files->where('file_category', 'source_code');
                                    $otherFiles = $project->files->whereNotIn('file_category', ['documentation', 'source_code']);
                                    $totalFiles = $project->files->count();
                                @endphp
                                <div class="border border-indigo-100 bg-indigo-50 rounded p-4">
                                    <h4 class="font-bold text-sm text-indigo-900 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        Project Files ({{ $totalFiles }})
                                    </h4>
                                    <div class="space-y-1 mb-4 text-xs">
                                        @if($docFiles->count() > 0)
                                            <div class="flex items-center gap-2 text-blue-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <span>{{ $docFiles->count() }} Documentation {{ Str::plural('file', $docFiles->count()) }}</span>
                                            </div>
                                        @endif
                                        @if($srcFiles->count() > 0)
                                            <div class="flex items-center gap-2 text-purple-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                                <span>{{ $srcFiles->count() }} Source code {{ Str::plural('file', $srcFiles->count()) }}</span>
                                            </div>
                                        @endif
                                        @if($otherFiles->count() > 0)
                                            <div class="flex items-center gap-2 text-gray-600">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <span>{{ $otherFiles->count() }} Other {{ Str::plural('file', $otherFiles->count()) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if(!$project->allow_download)
                                        <button disabled class="flex items-center justify-center gap-2 bg-gray-300 text-gray-500 font-bold py-3 px-6 w-full rounded cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Downloads Disabled
                                        </button>
                                    @elseif(auth()->guard('client')->check() || auth()->guard('web')->check())
                                        <a href="{{ route('projects.download', $project->slug) }}" class="flex items-center justify-center gap-2 bg-indigo-600 text-white font-bold py-3 px-6 hover:bg-indigo-700 transition-colors w-full rounded shadow hover:shadow-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            {{ $totalFiles > 1 ? 'Download All as ZIP' : 'Download File' }}
                                        </a>
                                        @if($totalFiles > 1)
                                            <p class="text-xs text-indigo-500 text-center mt-2">All {{ $totalFiles }} files packaged in one ZIP</p>
                                        @endif
                                    @else
                                        <a href="{{ route('client.login') }}" class="flex items-center justify-center gap-2 bg-gray-800 text-white font-bold py-3 px-6 hover:bg-black transition-colors w-full rounded shadow">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                            Log in to Download
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 p-8">
                        <h3 class="font-bold text-lg mb-4">Project Details</h3>
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Submitted By</span>
                                @if($project->user)
                                    <a href="{{ route('users.show', $project->user->id) }}" class="font-bold hover:text-blue-600 hover:underline transition">{{ $project->user->name }}</a>
                                @else
                                    <span class="font-bold">Anonymous</span>
                                @endif
                            </div>

                            @if($project->teams->count() > 0)
                                <div class="flex flex-col gap-2 border-t pt-4 border-gray-200">
                                    <span class="text-gray-500 font-bold uppercase text-xs tracking-widest">Team(s)</span>
                                    @foreach($project->teams as $team)
                                        <a href="{{ route('teams.show', $team->id) }}" class="flex items-center gap-3 p-2 bg-white rounded border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition-colors group">
                                            <div class="w-8 h-8 flex-shrink-0 bg-gray-100 rounded-full border border-gray-200 overflow-hidden flex items-center justify-center">
                                                @if($team->logo)
                                                    <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-xs text-gray-400 font-bold uppercase">{{ substr($team->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <span class="font-bold text-gray-700 group-hover:text-blue-600 transition-colors">{{ $team->name }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            @if($project->user && $project->user->college)
                                <div class="flex justify-between items-center border-t pt-4 border-gray-200 mt-2">
                                    <span class="text-gray-500">College</span>
                                    <a href="{{ route('colleges.show', $project->user->college->id) }}" class="font-bold text-gray-700 hover:text-blue-600 hover:underline transition text-right">{{ $project->user->college->name }}</a>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-500">Date</span>
                                <span class="font-bold">{{ $project->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Visibility</span>
                                <span class="font-bold">{{ $project->is_private ? 'Private' : 'Public' }}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-100 pt-4">
                                <span class="text-gray-500">Views</span>
                                <span class="font-bold">{{ number_format($project->views) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Downloads</span>
                                <span class="font-bold">{{ number_format($project->downloads) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@if($relatedProjects->count() > 0)
<section class="py-20 bg-gray-50 border-t border-gray-200">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold mb-10 text-center">More Related Projects</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedProjects as $relProject)
                <div class="bg-white border border-gray-200 rounded overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col group">
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        @if($relProject->image)
                            <img src="{{ asset('storage/' . $relProject->image) }}" alt="{{ $relProject->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-lg font-bold mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $relProject->name }}</h4>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $relProject->description }}</p>
                        <div class="mt-auto pt-4 border-t border-gray-50">
                            <a href="{{ route('projects.show', $relProject->slug) }}" class="text-black font-bold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
                                View Details <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Footer -->
<footer class="bg-black text-white py-16 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 font-bold text-2xl mb-6">
                    @if($system_logo)
                        <img src="{{ $system_logo }}" alt="{{ $system_name }}" class="w-10 h-10 object-contain">
                    @else
                        <div class="w-10 h-10 bg-white text-black flex items-center justify-center text-lg font-black">{{ substr($system_name, 0, 1) }}</div>
                    @endif
                    <span>{{ $system_name }}</span>
                </div>
                <p class="text-gray-400 text-lg leading-relaxed max-w-md">Bridging the gap between academic learning and industry visibility for the next generation of Nepalese developers.</p>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase tracking-widest mb-6 text-gray-500">Quick Links</h4>
                <ul class="text-gray-300 space-y-4 font-medium">
                    <li><a href="{{ route('projects.index') }}" class="hover:text-white transition-colors">Browse Projects</a></li>
                    <li><a href="{{ route('client.projects.create') }}" class="hover:text-white transition-colors">Submit Project</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Community Guidelines</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase tracking-widest mb-6 text-gray-500">Contact</h4>
                <ul class="text-gray-300 space-y-4 font-medium">
                    <li>support@projecthub.com.np</li>
                    <li>Kathmandu, Nepal</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm gap-4">
            <p>&copy; {{ date('Y') }} {{ $system_name }}. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script>
    function openLightbox(src, caption) {
        const lightbox = document.getElementById('galleryLightbox');
        const img = document.getElementById('lightboxImage');
        const captionDiv = document.getElementById('lightboxCaption');
        const captionText = captionDiv.querySelector('p');

        img.src = src;
        if (caption && caption !== 'null' && caption !== 'undefined') {
            captionText.innerText = caption;
            captionDiv.classList.remove('hidden');
        } else {
            captionDiv.classList.add('hidden');
        }

        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('galleryLightbox');
        lightbox.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const likeForm = document.getElementById('like-form');
        if (likeForm) {
            likeForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const url = likeForm.action;
                const token = likeForm.querySelector('input[name="_token"]').value;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = "{{ route('client.login') }}";
                        throw new Error('Unauthorized');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.success) {
                        const btn = document.getElementById('like-btn');
                        const icon = document.getElementById('like-icon');
                        const countSpan = document.getElementById('like-count');

                        if (data.isLiked) {
                            btn.className = "flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-full transition-colors bg-red-50 text-red-600 border-red-200 hover:bg-red-100";
                            icon.setAttribute('class', "w-5 h-5 fill-current");
                        } else {
                            btn.className = "flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-full transition-colors bg-white text-gray-600 hover:bg-gray-50";
                            icon.setAttribute('class', "w-5 h-5 fill-none stroke-current");
                        }

                        countSpan.innerText = `${data.likesCount} ${data.likesCount === 1 ? 'Like' : 'Likes'}`;
                    }
                })
                .catch(error => {
                    if (error.message !== 'Unauthorized') {
                        console.error('Error:', error);
                    }
                });
            });
        }
    });

    function toggleReplyForm(id) {
        document.getElementById('reply-form-' + id).classList.toggle('hidden');
        const editForm = document.getElementById('edit-form-' + id);
        if(editForm) editForm.classList.add('hidden');
    }

    function toggleEditForm(id) {
        document.getElementById('edit-form-' + id).classList.toggle('hidden');
        const replyForm = document.getElementById('reply-form-' + id);
        if(replyForm) replyForm.classList.add('hidden');
    }
</script>
</body>
</html>
