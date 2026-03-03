@extends("layouts.admin")

@section("content")
    <main>
        <section class="admin-container">
            <div class="admin-header flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $row->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">Full college details and presence.</p>
                </div>
                <a href="{{ route('admin.colleges.index') }}" class="btn btn-outline">Back to List</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 p-8 shadow-xl border border-gray-800 dark:border-gray-200">
                        <div class="flex items-start gap-6">
                            @if($row->logo)
                                <img src="{{ asset('storage/' . $row->logo) }}"
                                     alt="{{ $row->name }}"
                                     class="w-32 h-32 object-contain p-2">
                            @else
                                <div class="w-32 h-32 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-4xl font-bold border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                    {{ strtoupper(substr($row->name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="flex-1">
                                <h3 class="text-lg font-bold mb-6 border-b border-gray-700 dark:border-gray-300 pb-2">
                                    About the College
                                </h3>

                                <p class="text-gray-100 dark:text-gray-900">
                                    {{ $row->description ?: 'No description provided.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 p-8 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3 class="text-lg font-bold mb-6 border-b border-gray-200 dark:border-gray-700 pb-2 text-gray-900 dark:text-white">Institutional Connections</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Affiliated University</h4>
                                <p class="font-bold text-gray-900 dark:text-white">{{ $row->university->name ?? 'None' }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Administrative User</h4>
                                <p class="font-bold text-gray-900 dark:text-white">{{ $row->createdBy->name ?? 'System' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Details -->
                <div class="space-y-6">
                    <div class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 p-8 shadow-xl border border-gray-800 dark:border-gray-200">
                        <h3 class="text-lg font-bold mb-6 border-b border-gray-700 dark:border-gray-300 pb-2">Contact Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-400 dark:text-gray-600 text-xs font-bold uppercase">Address</label>
                                <p class="text-gray-100 dark:text-gray-900">{{ $row->address ?: 'Not Available' }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-400 dark:text-gray-600 text-xs font-bold uppercase">Phone</label>
                                <p class="text-gray-100 dark:text-gray-900">{{ $row->phone ?: 'Not Available' }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-400 dark:text-gray-600 text-xs font-bold uppercase">Email</label>
                                <p class="text-gray-100 dark:text-gray-900">{{ $row->email ?: 'Not Available' }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-400 dark:text-gray-600 text-xs font-bold uppercase">Website</label>
                                @if($row->website)
                                    <a href="{{ $row->website }}" target="_blank" class="text-blue-400 dark:text-blue-600 hover:underline break-all">{{ $row->website }}</a>
                                @else
                                    <p class="text-gray-100 dark:text-gray-900">Not Available</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 p-8 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3 class="text-lg font-bold mb-6 border-b border-gray-200 dark:border-gray-700 pb-2 text-gray-900 dark:text-white">Social Presence</h3>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'] as $social)
                                @if($row->$social)
                                    <a href="{{ $row->$social }}" target="_blank" class="w-10 h-10 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white flex items-center justify-center hover:bg-gray-900 dark:hover:bg-white hover:text-white dark:hover:text-gray-900 transition-colors border border-gray-200 dark:border-gray-700">
                                        <i class="fab fa-{{ $social }}"></i>
                                    </a>
                                @endif
                            @endforeach
                            @if(!$row->facebook && !$row->twitter && !$row->instagram && !$row->youtube && !$row->linkedin)
                                <p class="text-gray-500 dark:text-gray-400 text-sm italic">No social links added.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
