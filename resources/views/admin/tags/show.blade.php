@extends('layouts.admin')

@section('css')
    <style>
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
        <a href="{{ route($base_route . 'index') }}"
           class="inline-block border border-black px-6 py-1 mt-2 mb-4 go-back-btn text-sm">
            ← Go Back
        </a>

        <!-- TAG DETAILS -->
        <section class="border border-black p-8 hover-glow mb-6">
            <h1 class="text-3xl font-bold mb-2">{{ $row->name }}</h1>
            <div class="flex gap-4 text-sm text-gray-600">
                <p><strong>Key:</strong> {{ $row->key }}</p>
                <p><strong>Slug:</strong> {{ $row->slug }}</p>
                <p><strong>Status:</strong> 
                    <span class="{{ $row->status ? 'text-green-600' : 'text-red-600' }}">
                        {{ $row->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- ASSOCIATED PROJECTS -->
            <section>
                <h2 class="text-2xl font-bold mb-4">Projects with this Tag</h2>
                <div class="space-y-4">
                    @forelse($row->projects as $project)
                        <div class="border border-black p-4 hover-glow">
                            <h3 class="font-bold">{{ $project->title ?? $project->name }}</h3>
                            <p class="text-sm mt-1 text-gray-600">{{ Str::limit($project->description, 100) }}</p>
                            <a href="{{ route('admin.projects.show', $project->id) }}" class="text-xs underline mt-2 inline-block">View Project</a>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">No projects associated with this tag yet.</p>
                    @endforelse
                </div>
            </section>

            <!-- ASSOCIATED ALGORITHMS -->
            <section>
                <h2 class="text-2xl font-bold mb-4">Algorithms with this Tag</h2>
                <div class="space-y-4">
                    @forelse($row->algorithms as $algorithm)
                        <div class="border border-black p-4 hover-glow">
                            <h3 class="font-bold">{{ $algorithm->name }}</h3>
                            <p class="text-sm mt-1 text-gray-600">{{ Str::limit($algorithm->description, 100) }}</p>
                            <a href="{{ route('admin.algorithms.show', $algorithm->slug) }}" class="text-xs underline mt-2 inline-block">View Algorithm</a>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">No algorithms associated with this tag yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
