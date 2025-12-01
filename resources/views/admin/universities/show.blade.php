@extends('layouts.admin')

@section('css')
    <style>
        /* Glow Border Hover */
        .hover-glow:hover {
            box-shadow: 0 0 0 0.5px black inset;
            cursor: pointer;
        }

        .small-btn {
            transition: all 0.2s linear;
            cursor: pointer;
        }

        .small-btn:hover{
            background: black;
            color: white;
            border-color: black;
            box-shadow: 0 0 6px rgba(0,0,0,0.5);
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

<!-- MAIN CONTENT -->
<main class="">


    <div class="max-w-6xl mx-auto px-4">
        <a href="{{ route($base_route . 'index') }}"
           class="inline-block border border-black px-6 py-1 mt-2 mb-4 go-back-btn text-sm">
            ← Go Back
        </a>
        <!-- UNIVERSITY DETAILS -->
        <section class="border border-black p-8 hover-glow">
            <h1 class="text-3xl font-bold mb-4">{{ $row->name }} ({{ collect(explode(' ', $row->name))->map(fn($w) => strtoupper($w[0]))->implode('') }})</h1>

            @isset($row->description)
            <p class="text-sm leading-relaxed">
                {{ $row->description }}
            </p>
            @endisset

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                @isset($row->address)
                    <p><strong>Address:</strong> <a href="https://www.google.com/maps/search/{{ urlencode($row->address) }}" target="_blank">{{ $row->address }}</a></p>
                @endisset

                @isset($row->website)
                    <p><strong>Website:</strong> <a href="{{ $row->website }}" target="_blank" rel="noopener noreferrer">Visit</a></p>
                @endisset

                @isset($row->phone)
                    <p><strong>Phone:</strong> <a href="tel:{{ $row->phone }}">{{ $row->phone }}</a></p>
                @endisset

                @isset($row->email)
                    <p><strong>Email:</strong> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a></p>
                @endisset
            </div>
        </section>


        <!-- PROJECT STATISTICS CARDS -->
        <section class="mt-2">
            <h2 class="text-2xl font-bold mb-6">University Stats</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-black p-6 hover-glow">
                    <h3 class="text-lg font-bold">Total Projects</h3>
                    <p class="text-3xl font-bold mt-3">324+</p>
                </div>

                <div class="border border-black p-6 hover-glow">
                    <h3 class="text-lg font-bold">Active Colleges</h3>
                    <p class="text-3xl font-bold mt-3">85</p>
                </div>

                <div class="border border-black p-6 hover-glow">
                    <h3 class="text-lg font-bold">Registered Students</h3>
                    <p class="text-3xl font-bold mt-3">40,000+</p>
                </div>
            </div>
        </section>



        <!-- COLLEGES -->
        <section class="mt-2">
            <h2 class="text-2xl font-bold mb-6">Colleges Under This University</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="border border-black p-4 hover-glow">
                    <h3 class="font-bold">Pulchowk Campus</h3>
                    <p class="text-sm mt-1">Lalitpur, Nepal</p>
                </div>

                <div class="border border-black p-4 hover-glow">
                    <h3 class="font-bold">ASCOL</h3>
                    <p class="text-sm mt-1">Kathmandu</p>
                </div>

                <div class="border border-black p-4 hover-glow">
                    <h3 class="font-bold">RR Campus</h3>
                    <p class="text-sm mt-1">Kathmandu</p>
                </div>
            </div>
        </section>


        <!-- PROJECTS -->
        <section class="mt-2">
            <h2 class="text-2xl font-bold mb-6">Top Projects</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="border border-black p-4 hover-glow">
                    <h3 class="font-bold">AI-Based Crop Detection</h3>
                    <p class="text-sm mt-2">Pulchowk Campus</p>
                </div>

                <div class="border border-black p-4 hover-glow">
                    <h3 class="font-bold">Smart Parking System</h3>
                    <p class="text-sm mt-2">ASCOL</p>
                </div>

                <div class="border border-black p-4 hover-glow">
                    <h3 class="font-bold">Hospital Queue Management</h3>
                    <p class="text-sm mt-2">RR Campus</p>
                </div>

            </div>
        </section>



        <!-- POPULAR TECHNOLOGIES -->
        <section class="mt-2">
            <h2 class="text-2xl font-bold mb-6">Popular Technologies</h2>

            <div class="flex flex-wrap gap-4">

                <div class="border border-black px-4 py-2 small-btn">Laravel</div>
                <div class="border border-black px-4 py-2 small-btn">React</div>
                <div class="border border-black px-4 py-2 small-btn">Django</div>
                <div class="border border-black px-4 py-2 small-btn">Flutter</div>
                <div class="border border-black px-4 py-2 small-btn">Node.js</div>
                <div class="border border-black px-4 py-2 small-btn">TensorFlow</div>

            </div>
        </section>



        <!-- TRENDING ALGORITHMS -->
        <section class="mt-2">
            <h2 class="text-2xl font-bold mb-6">Trending Algorithms</h2>

            <div class="flex flex-wrap gap-4">

                <div class="border border-black px-4 py-2 small-btn">A*</div>
                <div class="border border-black px-4 py-2 small-btn">Dijkstra</div>
                <div class="border border-black px-4 py-2 small-btn">K-Means</div>
                <div class="border border-black px-4 py-2 small-btn">Random Forest</div>
                <div class="border border-black px-4 py-2 small-btn">CNN</div>

            </div>
        </section>



        <!-- RESEARCH AREAS -->
        <section class="mt-2">
            <h2 class="text-2xl font-bold mb-6">Research Areas</h2>

            <ul class="list-disc ml-6 text-sm space-y-2">
                <li>Artificial Intelligence</li>
                <li>Software Engineering</li>
                <li>Robotics</li>
                <li>Distributed Systems</li>
                <li>Networking & Security</li>
            </ul>
        </section>



        <!-- ACTIVITY LOG -->
        <section class="mt-2">
            <h2 class="text-2xl font-bold mb-6">Recent Activities</h2>

            <div class="border border-black p-4 space-y-4">

                <p class="hover-glow p-2">📢 TU published new curriculum updates – Jan 2025</p>
                <p class="hover-glow p-2">🚀 20 new final-year projects uploaded</p>
                <p class="hover-glow p-2">🏆 RR Campus won the Hackathon 2025</p>
                <p class="hover-glow p-2">🎓 500+ students completed internship programs</p>

            </div>
        </section>

    </div>
</main>
@endsection
