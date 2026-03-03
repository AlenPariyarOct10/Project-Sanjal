<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Projects -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Projects</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_projects'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Likes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Likes Received</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_likes'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Files -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Project Files</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_files'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Public vs Private -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Reach</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['public_projects'] }} <span class="text-sm font-normal text-gray-400">Public</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Projects List -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg">My Recent Projects</h3>
                            <a href="{{ route('client.projects.index') }}" class="text-sm text-blue-600 font-semibold hover:underline">View All</a>
                        </div>
                        <div class="p-0">
                            @if($recent_projects->isEmpty())
                                <div class="p-12 text-center text-gray-500">
                                    <p>No projects yet. Start by creating one!</p>
                                    <a href="{{ route('client.projects.create') }}" class="mt-4 inline-block bg-black text-white px-4 py-2 rounded font-bold">New Project</a>
                                </div>
                            @else
                                <div class="divide-y divide-gray-50">
                                    @foreach($recent_projects as $project)
                                        <div class="p-6 hover:bg-gray-50 transition-colors flex items-center gap-4">
                                            <div class="w-16 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                                @if($project->image)
                                                    <img src="{{ asset('storage/' . $project->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-900">{{ $project->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $project->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="flex items-center gap-4 text-sm font-medium">
                                                <div class="flex items-center text-red-500">
                                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                                                    {{ $project->likes_count }}
                                                </div>
                                                <a href="{{ route('client.projects.edit', $project->id) }}" class="text-gray-400 hover:text-black">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar / Quick Links -->
                <div class="space-y-8">
                    <div class="bg-black text-white p-6 rounded-lg shadow-lg">
                        <h3 class="font-bold text-lg mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('client.projects.create') }}" class="flex items-center justify-center gap-2 bg-white text-black py-2 rounded font-bold hover:bg-gray-100 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Submit New Project
                            </a>
                            <a href="{{ route('projects.index') }}" class="flex items-center justify-center gap-2 border border-white text-white py-2 rounded font-bold hover:bg-white hover:text-black transition-all">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Explore Hub
                            </a>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Project Reports</h3>
                        <div class="space-y-4">
                            <!-- Public vs Private Distribution -->
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500 uppercase font-bold tracking-tighter">Visibility Distribution</span>
                                    <span class="text-gray-900 font-bold">
                                        {{ $stats['total_projects'] > 0 ? round(($stats['public_projects'] / $stats['total_projects']) * 100) : 0 }}% Public
                                    </span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    @php
                                        $publicPercentage = $stats['total_projects'] > 0 ? ($stats['public_projects'] / $stats['total_projects']) * 100 : 0;
                                    @endphp
                                    <div class="bg-black h-2 rounded-full" style="width: {{ $publicPercentage }}%"></div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm pt-2 border-t border-gray-50">
                                <span class="text-gray-500">Member Since</span>
                                @php
                                    $user = auth('client')->user() ?? auth()->user();
                                @endphp
                                <span class="font-bold text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Account Status</span>
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded uppercase">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
