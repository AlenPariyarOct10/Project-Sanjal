@extends('layouts.admin')

@section('css')
    <style>
        .hover-glow:hover {
            box-shadow: 0 0 0 1.5px black inset;
            cursor: pointer;
        }
        .small-btn {
            transition: all 0.2s linear;
            cursor: pointer;
        }
        .small-btn:hover {
            background: black;
            color: white;
            border-color: black;
        }
        .go-back-btn {
            transition: all 0.2s linear;
        }
        .go-back-btn:hover {
            background: black;
            color: white;
            text-decoration: none;
        }
        .stat-card {
            transition: box-shadow 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 0 0 2px black inset;
        }
    </style>
@endsection

@section('content')
<main class="pb-16">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Back Button -->
        <a href="{{ route($base_route . 'index') }}"
           class="inline-block border border-black px-6 py-1 mt-4 mb-6 go-back-btn text-sm">
            ← Back to Universities
        </a>

        <!-- ═══════════════════════════════════════════ -->
        <!-- HEADER: Logo + Name + Description + Links  -->
        <!-- ═══════════════════════════════════════════ -->
        <section class="border border-black p-8 mb-4 hover-glow">
            <div class="flex flex-col md:flex-row items-start gap-8">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    @if($row->logo)
                        <img src="{{ asset($row->logo) }}"
                             alt="{{ $row->name }} Logo"
                             class="w-28 h-28 object-contain border border-gray-200 p-2 bg-white">
                    @else
                        <div class="w-28 h-28 border border-gray-300 bg-gray-100 flex items-center justify-center">
                            <span class="text-3xl font-black text-gray-400">
                                {{ strtoupper(substr($row->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1">
                    @php
                        $initials = collect(explode(' ', $row->name))
                            ->map(fn($w) => strtoupper($w[0] ?? ''))
                            ->implode('');
                    @endphp
                    <h1 class="text-3xl font-bold mb-1">
                        {{ $row->name }}
                        <span class="text-lg font-normal text-gray-500">({{ $initials }})</span>
                    </h1>

                    @if($row->description)
                        <p class="text-sm text-gray-600 leading-relaxed mt-2 mb-4 max-w-2xl">{{ $row->description }}</p>
                    @endif

                    <!-- Contact Details -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-1 text-sm mt-3">
                        @if($row->address)
                            <div class="flex items-start gap-2">
                                <span class="font-semibold text-gray-500 min-w-[60px]">Address</span>
                                <a href="https://www.google.com/maps/search/{{ urlencode($row->address) }}"
                                   target="_blank"
                                   class="text-gray-800 hover:underline">{{ $row->address }}</a>
                            </div>
                        @endif
                        @if($row->phone)
                            <div class="flex items-start gap-2">
                                <span class="font-semibold text-gray-500 min-w-[60px]">Phone</span>
                                <a href="tel:{{ $row->phone }}" class="text-gray-800 hover:underline">{{ $row->phone }}</a>
                            </div>
                        @endif
                        @if($row->email)
                            <div class="flex items-start gap-2">
                                <span class="font-semibold text-gray-500 min-w-[60px]">Email</span>
                                <a href="mailto:{{ $row->email }}" class="text-gray-800 hover:underline">{{ $row->email }}</a>
                            </div>
                        @endif
                        @if($row->website)
                            <div class="flex items-start gap-2">
                                <span class="font-semibold text-gray-500 min-w-[60px]">Website</span>
                                <a href="{{ $row->website }}" target="_blank" rel="noopener noreferrer"
                                   class="text-blue-600 hover:underline truncate max-w-[220px]">{{ $row->website }}</a>
                            </div>
                        @endif
                    </div>

                    <!-- Social Links -->
                    @php
                        $socials = [
                            'facebook'  => ['label' => 'Facebook',  'icon' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                            'twitter'   => ['label' => 'Twitter',   'icon' => 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z'],
                            'instagram' => ['label' => 'Instagram',  'icon' => 'M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M6.5 2h11A4.5 4.5 0 0122 6.5v11a4.5 4.5 0 01-4.5 4.5h-11A4.5 4.5 0 012 17.5v-11A4.5 4.5 0 016.5 2z'],
                            'linkedin'  => ['label' => 'LinkedIn',   'icon' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],
                            'youtube'   => ['label' => 'YouTube',    'icon' => 'M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z'],
                        ];
                    @endphp
                    @php $hasSocials = collect(['facebook','twitter','instagram','linkedin','youtube'])->filter(fn($k) => !empty($row->$k))->isNotEmpty(); @endphp
                    @if($hasSocials)
                        <div class="flex items-center gap-3 mt-4">
                            @foreach($socials as $key => $info)
                                @if(!empty($row->$key))
                                    <a href="{{ $row->$key }}" target="_blank" rel="noopener noreferrer"
                                       title="{{ $info['label'] }}"
                                       class="w-8 h-8 border border-gray-300 flex items-center justify-center hover:border-black hover:bg-black hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $info['icon'] }}"/>
                                        </svg>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- ═══════════════════════ -->
        <!-- STATS CARDS            -->
        <!-- ═══════════════════════ -->
        <section class="mb-4">
            <h2 class="text-xl font-bold mb-4">University Stats</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="border border-black p-5 stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Total Projects</p>
                    <p class="text-3xl font-black">{{ number_format($totalProjects) }}</p>
                </div>
                <div class="border border-black p-5 stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Active Colleges</p>
                    <p class="text-3xl font-black">{{ number_format($activeColleges) }}</p>
                </div>
                <div class="border border-black p-5 stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Registered Students</p>
                    <p class="text-3xl font-black">{{ number_format($totalStudents) }}</p>
                </div>
                <div class="border border-black p-5 stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Total Likes</p>
                    <p class="text-3xl font-black">{{ number_format($totalLikes) }}</p>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════ -->
        <!-- COLLEGES UNDER THIS UNIVERSITY  -->
        <!-- ═══════════════════════════════ -->
        <section class="mb-4">
            <h2 class="text-xl font-bold mb-4">
                Colleges Under This University
                <span class="text-sm font-normal text-gray-500 ml-2">({{ $row->colleges->count() }} total)</span>
            </h2>

            @if($row->colleges->isEmpty())
                <p class="text-sm text-gray-500 italic">No colleges registered under this university yet.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($row->colleges as $college)
                        <a href="{{ route('admin.colleges.show', $college->id) }}"
                           class="border border-black p-4 hover-glow flex items-start gap-3 group transition-all">
                            <!-- College Logo -->
                            @if($college->logo)
                                <img src="{{ asset('storage/' . $college->logo) }}"
                                     alt="{{ $college->name }}"
                                     class="w-10 h-10 object-contain flex-shrink-0 border border-gray-100 bg-white p-1">
                            @else
                                <div class="w-10 h-10 flex-shrink-0 bg-gray-100 border border-gray-200 flex items-center justify-center">
                                    <span class="text-xs font-black text-gray-500">{{ strtoupper(substr($college->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h3 class="font-bold text-sm group-hover:underline truncate">{{ $college->name }}</h3>
                                @if($college->address)
                                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $college->address }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $college->users->count() }} {{ Str::plural('student', $college->users->count()) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- ═══════════════════════ -->
        <!-- TOP PROJECTS           -->
        <!-- ═══════════════════════ -->
        <section class="mb-4">
            <h2 class="text-xl font-bold mb-4">Top Projects</h2>

            @if($topProjects->isEmpty())
                <p class="text-sm text-gray-500 italic">No projects from this university yet.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($topProjects as $project)
                        <a href="{{ route('admin.projects.show', $project->id) }}"
                           class="border border-black p-4 hover-glow group transition-all block">
                            <h3 class="font-bold text-sm group-hover:underline line-clamp-1">{{ $project->name }}</h3>
                            @if($project->user?->college)
                                <p class="text-xs text-gray-500 mt-1">{{ $project->user->college->name }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                <span title="Likes">♥ {{ $project->likes_count }}</span>
                                <span title="Views">👁 {{ number_format($project->views) }}</span>
                                <span class="ml-auto text-gray-400">{{ $project->created_at->format('M Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- ═══════════════════════════════════════ -->
        <!-- POPULAR TECHNOLOGIES & ALGORITHMS ROW  -->
        <!-- ═══════════════════════════════════════ -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <!-- Popular Technologies (Tags) -->
            <section>
                <h2 class="text-xl font-bold mb-4">Popular Technologies</h2>
                @if($topTags->isEmpty())
                    <p class="text-sm text-gray-500 italic">No tags data available yet.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach($topTags as $tag)
                            <span class="border border-black px-3 py-1 small-btn text-sm flex items-center gap-1.5">
                                {{ $tag->name }}
                                <span class="text-xs text-gray-400 font-normal">({{ $tag->projects_count }})</span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Trending Algorithms -->
            <section>
                <h2 class="text-xl font-bold mb-4">Trending Algorithms</h2>
                @if($topAlgorithms->isEmpty())
                    <p class="text-sm text-gray-500 italic">No algorithm data available yet.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach($topAlgorithms as $algo)
                            <span class="border border-black px-3 py-1 small-btn text-sm flex items-center gap-1.5">
                                {{ $algo->name }}
                                <span class="text-xs text-gray-400 font-normal">({{ $algo->projects_count }})</span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <!-- ═══════════════════════════════════ -->
        <!-- META INFO (Timestamps, Status, Key) -->
        <!-- ═══════════════════════════════════ -->
        <section class="border border-gray-200 p-6 mt-2 text-sm text-gray-500 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="font-semibold text-gray-700 mb-0.5">Status</p>
                <span class="inline-block px-2 py-0.5 text-xs font-bold border
                    {{ $row->status ? 'border-green-500 text-green-700 bg-green-50' : 'border-red-400 text-red-600 bg-red-50' }}">
                    {{ $row->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div>
                <p class="font-semibold text-gray-700 mb-0.5">Slug</p>
                <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded">{{ $row->slug }}</code>
            </div>
            <div>
                <p class="font-semibold text-gray-700 mb-0.5">Created</p>
                <p>{{ $row->created_at->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700 mb-0.5">Last Updated</p>
                <p>{{ $row->updated_at->format('M d, Y') }}</p>
            </div>
        </section>

    </div>
</main>
@endsection
