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

        <!-- COURSE DETAILS -->
        <section class="border border-black p-8 hover-glow mb-6">
            <h1 class="text-3xl font-bold mb-2">{{ $row->name }} ({{ $row->code ?? 'N/A' }})</h1>
            <p class="text-sm text-gray-600 mb-4"><strong>University:</strong> {{ $row->university->name ?? 'N/A' }}</p>
            
            @if($row->description)
                <div class="text-sm leading-relaxed mb-4">
                    <strong>Description:</strong>
                    <p>{{ $row->description }}</p>
                </div>
            @endif

            <p class="text-sm"><strong>Status:</strong> 
                <span class="{{ $row->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $row->status ? 'Active' : 'Inactive' }}
                </span>
            </p>
        </section>

        <!-- ASSOCIATED SUBJECTS -->
        <section>
            <h2 class="text-2xl font-bold mb-4">Subjects in this Course</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($row->subjects as $subject)
                    <div class="border border-black p-4 hover-glow">
                        <h3 class="font-bold">{{ $subject->name }}</h3>
                        <p class="text-xs text-gray-600">Code: {{ $subject->code ?? 'N/A' }}</p>
                        <a href="{{ route('admin.subjects.show', $subject->id) }}" class="text-xs underline mt-2 inline-block">View Subject</a>
                    </div>
                @empty
                    <p class="col-span-full text-gray-500 italic">No subjects added to this course yet.</p>
                @endforelse
            </div>
        </section>
    </div>
</main>
@endsection
