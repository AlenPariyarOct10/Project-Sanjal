<x-app-layout>
    @php $currentUserId = auth('client')->id() ?? auth()->id(); @endphp
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Team Details') }}
            </h2>
            <a href="{{ route('client.teams.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm font-bold shadow hover:bg-gray-300">
                Back to Teams
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-1/3 text-center">
                            <div class="w-32 h-32 mx-auto bg-gray-100 rounded-full overflow-hidden shadow">
                                @if($team->logo)
                                    <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <h3 class="mt-4 text-xl font-bold">{{ $team->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Created on {{ $team->created_at->format('M d, Y') }}</p>
                            @if($currentUserId === $team->created_by)
                                <div class="mt-4 flex justify-center gap-2">
                                    <a href="{{ route('client.teams.edit', $team->id) }}" class="bg-black text-white px-4 py-2 rounded text-sm hover:bg-gray-800 shadow">Edit Team</a>
                                </div>
                            @endif
                        </div>

                        <div class="w-full md:w-2/3 border-t md:border-t-0 md:border-l border-gray-200 pt-6 md:pt-0 md:pl-6">
                            <h4 class="text-lg font-semibold mb-2">Description</h4>
                            <p class="text-gray-700 whitespace-pre-line">{{ $team->description ?: 'No description provided.' }}</p>

                            <hr class="my-6">
                            <h4 class="text-lg font-semibold mb-4">Social Links</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($team->website)
                                    <div><span class="font-bold text-gray-600 block">Website</span><a href="{{ $team->website }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $team->website }}</a></div>
                                @endif
                                @if($team->facebook)
                                    <div><span class="font-bold text-gray-600 block">Facebook</span><a href="{{ $team->facebook }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $team->facebook }}</a></div>
                                @endif
                                @if($team->twitter)
                                    <div><span class="font-bold text-gray-600 block">Twitter</span><a href="{{ $team->twitter }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $team->twitter }}</a></div>
                                @endif
                                @if($team->instagram)
                                    <div><span class="font-bold text-gray-600 block">Instagram</span><a href="{{ $team->instagram }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $team->instagram }}</a></div>
                                @endif
                                @if($team->linkedin)
                                    <div><span class="font-bold text-gray-600 block">LinkedIn</span><a href="{{ $team->linkedin }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $team->linkedin }}</a></div>
                                @endif
                                @if($team->youtube)
                                    <div><span class="font-bold text-gray-600 block">YouTube</span><a href="{{ $team->youtube }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $team->youtube }}</a></div>
                                @endif
                            </div>
                            
                            @if(empty($team->website) && empty($team->facebook) && empty($team->twitter) && empty($team->instagram) && empty($team->linkedin) && empty($team->youtube))
                                <p class="text-gray-500 italic">No social links provided.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="text-xl font-bold mb-4">Team Members</h4>
                    
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ $errors->first() }}</div>
                    @endif

                    @if($currentUserId === $team->created_by)
                        <form action="{{ route('client.teams.members.store', $team->id) }}" method="POST" class="mb-6 flex gap-2 w-full md:w-1/2">
                            @csrf
                            <input type="email" name="email" placeholder="Invite member by email" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">
                            <button type="submit" class="bg-black text-white px-4 py-2 rounded text-sm font-bold shadow hover:bg-gray-800 whitespace-nowrap">Invite</button>
                        </form>
                    @endif

                    @if($team->members->isEmpty() && \App\Models\TeamMember::where('team_id', $team->id)->count() === 0)
                        <p class="text-gray-500 italic">No members in this team yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="py-3 px-2 font-bold text-sm text-gray-600">USER</th>
                                        <th class="py-3 px-2 font-bold text-sm text-gray-600">STATUS</th>
                                        <th class="py-3 px-2 font-bold text-sm text-gray-600">JOINED</th>
                                        @if($currentUserId === $team->created_by)
                                            <th class="py-3 px-2 font-bold text-sm text-gray-600 text-right">ACTION</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $allMembers = \App\Models\TeamMember::where('team_id', $team->id)->with('user')->get();
                                    @endphp
                                    @foreach($allMembers as $memberRow)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                            <td class="py-3 px-2">
                                                <div class="font-bold text-gray-900">{{ $memberRow->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $memberRow->user->email }}</div>
                                            </td>
                                            <td class="py-3 px-2">
                                                @if($memberRow->status === 'approved')
                                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded">APPROVED</span>
                                                @elseif($memberRow->status === 'pending')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded">PENDING</span>
                                                @else
                                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded">REJECTED</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-2 text-sm text-gray-600">
                                                {{ $memberRow->created_at->format('M d, Y') }}
                                            </td>
                                            @if($currentUserId === $team->created_by)
                                                <td class="py-3 px-2 text-right">
                                                    <form action="{{ route('client.teams.members.destroy', [$team->id, $memberRow->id]) }}" method="POST" onsubmit="return confirm('Remove this user from the team?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">Remove</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
