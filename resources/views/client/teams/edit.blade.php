<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Team') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('client.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Team Name *</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('name', $team->name) }}">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">{{ old('description', $team->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Team Logo</label>
                            @if($team->logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-16 h-16 object-cover rounded shadow">
                                </div>
                            @endif
                            <input type="file" name="logo" id="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-medium mb-4">Social Links</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="website" class="block text-sm font-medium text-gray-700">Website URL</label>
                                <input type="url" name="website" id="website" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('website', $team->website) }}">
                                @error('website') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="facebook" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                                <input type="url" name="facebook" id="facebook" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('facebook', $team->facebook) }}">
                                @error('facebook') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="twitter" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                                <input type="url" name="twitter" id="twitter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('twitter', $team->twitter) }}">
                                @error('twitter') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="instagram" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                                <input type="url" name="instagram" id="instagram" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('instagram', $team->instagram) }}">
                                @error('instagram') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                                <input type="url" name="linkedin" id="linkedin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('linkedin', $team->linkedin) }}">
                                @error('linkedin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="youtube" class="block text-sm font-medium text-gray-700">YouTube URL</label>
                                <input type="url" name="youtube" id="youtube" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('youtube', $team->youtube) }}">
                                @error('youtube') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('client.teams.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow-sm hover:bg-gray-300 mr-2">Cancel</a>
                            <button type="submit" class="bg-black text-white px-4 py-2 rounded shadow-sm hover:bg-gray-800">Update Team</button>
                        </div>
                    </form>
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

                    <form action="{{ route('client.teams.members.store', $team->id) }}" method="POST" class="mb-6 flex gap-2 w-full md:w-1/2">
                        @csrf
                        <input type="email" name="email" placeholder="Invite member by email" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded text-sm font-bold shadow hover:bg-gray-800 whitespace-nowrap">Invite</button>
                    </form>

                    @if(\App\Models\TeamMember::where('team_id', $team->id)->count() === 0)
                        <p class="text-gray-500 italic">No members in this team yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="py-3 px-2 font-bold text-sm text-gray-600">USER</th>
                                        <th class="py-3 px-2 font-bold text-sm text-gray-600">STATUS</th>
                                        <th class="py-3 px-2 font-bold text-sm text-gray-600">JOINED</th>
                                        <th class="py-3 px-2 font-bold text-sm text-gray-600 text-right">ACTION</th>
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
                                            <td class="py-3 px-2 text-right">
                                                <form action="{{ route('client.teams.members.destroy', [$team->id, $memberRow->id]) }}" method="POST" onsubmit="return confirm('Remove this user from the team?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">Remove</button>
                                                </form>
                                            </td>
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
