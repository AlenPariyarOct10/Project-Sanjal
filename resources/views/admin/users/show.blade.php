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
    <div class="max-w-4xl mx-auto px-4">
        <a href="{{ route($base_route . 'index') }}"
           class="inline-block border border-black px-6 py-1 mt-2 mb-4 go-back-btn text-sm">
            ← Go Back
        </a>

        <!-- USER DETAILS -->
        <section class="border border-black p-8 hover-glow mb-6">
            <h1 class="text-3xl font-bold mb-4">User Profile: {{ $row->name }}</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <p><strong>Email:</strong> {{ $row->email }}</p>
                <p><strong>Role:</strong> {{ $row->role->title ?? 'N/A' }}</p>
                <p><strong>College:</strong> {{ $row->college->name ?? 'N/A' }}</p>
                <p><strong>Status:</strong> 
                    <span class="{{ $row->status ? 'text-green-600' : 'text-red-600' }}">
                        {{ $row->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
                <p><strong>Joined:</strong> {{ $row->created_at->format('M d, Y') }}</p>
            </div>
        </section>

        <!-- ACTIVITY OR ADDITIONAL INFO COULD GO HERE -->
    </div>
</main>
@endsection
