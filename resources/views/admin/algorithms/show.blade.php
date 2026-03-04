@extends('layouts.admin')

@section('css')
    <style>
        .hover-glow {
            transition: all 0.2s linear;
        }
        .hover-glow:hover {
            box-shadow: 0 0 0 0.5px black inset;
            cursor: pointer;
        }
        .go-back-btn {
            transition: all 0.2s linear;
            cursor: pointer;
        }
        .go-back-btn:hover {
            background: black;
            color: white;
            box-shadow: 0 0 6px rgba(0,0,0,0.6);
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
<main class="admin-container">
    <div class="max-w-6xl mx-auto px-4">
        <!-- HEADER / NAVIGATION -->
        <a href="{{ route($base_route . 'index') }}"
           class="inline-block border border-black px-6 py-1 mt-2 mb-4 go-back-btn text-sm">
            &larr; Go Back
        </a>

        <!-- ALGORITHM DETAILS -->
        <section class="border border-black p-8 hover-glow mb-6">
            <div class="flex flex-col md:flex-row gap-6 items-start">
                
                @if($row->image)
                    <div class="w-32 h-32 flex-shrink-0 bg-gray-100 border border-gray-200 shadow-sm p-1 rounded">
                        <img src="{{ asset($row->image) }}" alt="{{ $row->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-32 h-32 flex-shrink-0 bg-gray-50 border border-gray-200 shadow-sm p-1 rounded flex items-center justify-center text-gray-400">
                        <i class="fas fa-microchip fa-3x"></i>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ $row->name }}</h1>
                    
                    @if($row->resource_url)
                        <p class="text-sm text-gray-600 mb-2">
                            <strong>Resource URL:</strong> 
                            <a href="{{ $row->resource_url }}" target="_blank" class="underline text-blue-600 hover:text-blue-800">{{ $row->resource_url }}</a>
                        </p>
                    @endif

                    @if($row->description)
                        <div class="text-sm leading-relaxed mb-4 text-gray-700">
                            <strong>Description:</strong>
                            <p class="mt-1">{{ $row->description }}</p>
                        </div>
                    @endif

                    <div class="text-sm mb-4">
                        <strong>Status:</strong> 
                        <span class="{{ $row->status ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                            {{ $row->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Categories & Tags -->
                    <div class="flex flex-col sm:flex-row gap-6">
                        @if($row->categories->count() > 0)
                            <div>
                                <strong class="text-sm block mb-1">Categories:</strong>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($row->categories as $category)
                                        <span class="bg-gray-800 text-white px-2 py-1 text-xs rounded shadow">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div>
                                <strong class="text-sm block mb-1">Categories:</strong>
                                <span class="text-xs text-gray-500 italic">No Categories Assigned</span>
                            </div>
                        @endif

                        @if($row->tags->count() > 0)
                            <div>
                                <strong class="text-sm block mb-1">Tags:</strong>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($row->tags as $tag)
                                        <span class="bg-blue-100 text-blue-800 border border-blue-200 px-2 py-1 text-xs rounded shadow-sm">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div>
                                <strong class="text-sm block mb-1">Tags:</strong>
                                <span class="text-xs text-gray-500 italic">No Tags Assigned</span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </section>

        <!-- PROJECTS USING THIS ALGORITHM -->
        <section>
            <h2 class="text-2xl font-bold mb-4">Associated Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($row->projects as $project)
                    <div class="border border-black p-4 hover-glow bg-white flex flex-col h-full rounded shadow-sm">
                        <h3 class="font-bold text-lg mb-1 line-clamp-1">{{ $project->name }}</h3>
                        
                        <p class="text-xs text-gray-500 mb-3 flex-1 line-clamp-2">
                            {{ $project->description ?: 'No description provided.' }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-t border-gray-100">
                             <a href="{{ route('admin.projects.show', $project->id) }}" class="text-sm font-bold hover:underline flex items-center justify-between">
                                 View Project <span>&rarr;</span>
                             </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border border-gray-200 bg-gray-50 p-6 text-center rounded">
                        <p class="text-gray-500 italic">No projects are using this algorithm yet.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</main>
@endsection
