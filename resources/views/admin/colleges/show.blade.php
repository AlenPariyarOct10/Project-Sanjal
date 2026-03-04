@extends("layouts.admin")

@section("css")
    <style>
        .hover-glow {
            transition: all 0.2s linear;
        }
        .hover-glow:hover {
            box-shadow: 0 0 0 1px var(--primary) inset !important;
            border-color: var(--primary) !important;
            cursor: pointer;
        }
        .go-back-btn {
            transition: all 0.2s linear;
            cursor: pointer;
        }
    </style>
@endsection

@section("content")
<main class="admin-container">
    <div class="max-w-6xl mx-auto px-4">
        <!-- HEADER / NAVIGATION -->
        <a href="{{ route('admin.colleges.index') }}"
           class="inline-block border border-black px-6 py-1 mt-2 mb-4 go-back-btn text-sm">
            &larr; Go Back
        </a>

        <!-- COLLEGE DETAILS -->
        <section class="border border-black p-8 hover-glow mb-6 bg-white">
            <div class="flex flex-col md:flex-row gap-6 items-start">
                
                @if($row->logo)
                    <div class="w-32 h-32 flex-shrink-0 bg-gray-50 border border-gray-200 shadow-sm p-1 rounded">
                        <img src="{{ asset('storage/' . $row->logo) }}" alt="{{ $row->name }}" class="w-full h-full object-contain">
                    </div>
                @else
                    <div class="w-24 h-24 lg:w-32 lg:h-32 flex-shrink-0 bg-gray-50 border border-gray-200 shadow-sm p-1 rounded flex items-center justify-center text-gray-400 font-bold text-4xl">
                        {{ strtoupper(substr($row->name, 0, 1)) }}
                    </div>
                @endif
                
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ $row->name }}</h1>
                    
                    @if($row->university)
                        <p class="text-sm text-gray-600 mb-2">
                            <strong>Affiliated University:</strong> 
                            <span class="font-semibold">{{ $row->university->name }}</span>
                        </p>
                    @endif

                    @if($row->description)
                        <div class="text-sm leading-relaxed mb-4 text-gray-700">
                            <strong>About the College:</strong>
                            <p class="mt-1">{{ $row->description }}</p>
                        </div>
                    @endif

                    <!-- Quick Contact / Info -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-100">
                        @if($row->address)
                        <div>
                            <strong class="text-xs text-gray-500 uppercase tracking-widest block mb-1">Address</strong>
                            <p class="text-sm">{{ $row->address }}</p>
                        </div>
                        @endif

                        @if($row->phone)
                        <div>
                            <strong class="text-xs text-gray-500 uppercase tracking-widest block mb-1">Phone</strong>
                            <p class="text-sm">{{ $row->phone }}</p>
                        </div>
                        @endif

                        @if($row->email)
                        <div>
                            <strong class="text-xs text-gray-500 uppercase tracking-widest block mb-1">Email</strong>
                            <p class="text-sm"><a href="mailto:{{ $row->email }}" class="text-blue-600 hover:underline">{{ $row->email }}</a></p>
                        </div>
                        @endif

                        @if($row->website)
                        <div>
                            <strong class="text-xs text-gray-500 uppercase tracking-widest block mb-1">Website</strong>
                            <p class="text-sm"><a href="{{ $row->website }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $row->website }}</a></p>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </section>

        <!-- RELATED INFOS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- SOCIAL PRESENCE -->
            <section class="border border-black p-6 hover-glow bg-white">
                <h3 class="text-xl font-bold mb-4">Social Presence</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach(['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'] as $social)
                        @if($row->$social)
                            <a href="{{ $row->$social }}" target="_blank" class="w-10 h-10 bg-gray-50 text-gray-700 flex items-center justify-center hover:bg-black hover:text-white transition-colors border border-gray-200">
                                <i class="fab fa-{{ $social }}"></i>
                            </a>
                        @endif
                    @endforeach
                    @if(!$row->facebook && !$row->twitter && !$row->instagram && !$row->youtube && !$row->linkedin)
                        <p class="text-gray-500 text-sm italic">No social links added.</p>
                    @endif
                </div>
            </section>

            <!-- META INFO -->
            <section class="border border-black p-6 hover-glow bg-white">
                <h3 class="text-xl font-bold mb-4">System Details</h3>
                <div class="space-y-3">
                    <div>
                        <strong class="text-xs text-gray-500 uppercase tracking-widest block mb-1">Administrative User</strong>
                        <p class="text-sm">{{ $row->createdBy->name ?? 'System' }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
