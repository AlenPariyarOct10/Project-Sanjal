<x-app-layout>
    @php $currentUserId = auth('client')->id() ?? auth()->id(); @endphp
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Teams') }}
            </h2>
            <a href="{{ route('client.teams.create') }}" class="bg-black text-white px-4 py-2 rounded text-sm font-bold">
                Create New Team
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Actions -->
            <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <form action="{{ route('client.teams.index') }}" method="GET" class="w-full md:w-96 flex gap-2">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black sm:text-sm" placeholder="Search my teams...">
                    </div>
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-black transition-colors text-sm font-semibold">Search</button>
                    @if(request('search'))
                        <a href="{{ route('client.teams.index') }}" class="text-gray-500 hover:text-black py-2 text-sm">Clear</a>
                    @endif
                </form>
            </div>
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($teams->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">You haven't created any teams yet.</p>
                            <a href="{{ route('client.teams.create') }}" class="text-blue-600 font-bold hover:underline">Create your first team</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="py-4 px-2 font-bold text-sm text-gray-600">TEAM</th>
                                        <th class="py-4 px-2 font-bold text-sm text-gray-600">DATE CREATED</th>
                                        <th class="py-4 px-2 font-bold text-sm text-gray-600 text-right">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $team)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                            <td class="py-4 px-2">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-12 h-12 bg-gray-100 flex-shrink-0 rounded-full overflow-hidden">
                                                        @if($team->logo)
                                                            <img src="{{ asset('storage/' . $team->logo) }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-gray-900">{{ $team->name }}</div>
                                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $team->description }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-sm text-gray-600">
                                                {{ $team->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-4 px-2 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('client.teams.show', $team->id) }}" class="p-2 text-gray-400 hover:text-green-600" title="View">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                    @if($currentUserId === $team->created_by)
                                                        <a href="{{ route('client.teams.edit', $team->id) }}" class="p-2 text-gray-400 hover:text-blue-600" title="Edit">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                        </a>
                                                        <form action="{{ route('client.teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this team?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600" title="Delete">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $teams->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
