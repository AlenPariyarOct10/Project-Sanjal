<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Top Contributors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900">Ranked Contributors</h3>
                    <p class="text-gray-500 mt-1">Our most active students and researchers contributing to the ecosystem.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Rank</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Contributor</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Projects</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Impact</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Academic Details</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">Score</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($contributors as $index => $user)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        @if($index == 0)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-700 font-bold">1</span>
                                        @elseif($index == 1)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 font-bold">2</span>
                                        @elseif($index == 2)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-700 font-bold">3</span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-8 h-8 text-gray-400 font-bold">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($user->profile_image)
                                                <img src="{{ asset('storage/' . $user->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-gray-100 shadow-sm">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-sm border border-gray-100">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('users.show', $user->id) }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 hover:underline transition-colors">{{ $user->name }}</a>
                                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">{{ $user->created_at->format('M Y') }} Joined</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">{{ $user->projects_count }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1.5 items-center">
                                            <div class="flex items-center gap-1.5 text-xs text-gray-600" title="Likes Received">
                                                <svg class="h-3.5 w-3.5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                                                <span class="font-semibold">{{ $user->total_likes }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5 text-[10px] text-gray-400" title="Views & Downloads">
                                                <span class="flex items-center gap-0.5">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    {{ $user->total_views }}
                                                </span>
                                                <span class="flex items-center gap-0.5">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                    {{ $user->total_downloads }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->college)
                                            <div class="flex flex-col">
                                                <span class="text-xs font-bold text-gray-800">{{ $user->college->name }}</span>
                                                @if($user->college->university)
                                                    <span class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">{{ $user->college->university->name }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No college details</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-black text-gray-900">{{ number_format($user->rank_score) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($contributors->isEmpty())
                    <div class="p-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <p class="text-lg">No contributors found yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
