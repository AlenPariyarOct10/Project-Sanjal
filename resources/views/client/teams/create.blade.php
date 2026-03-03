<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Team') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('client.teams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Team Name *</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('name') }}">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Team Logo</label>
                            <input type="file" name="logo" id="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-medium mb-4">Social Links</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="website" class="block text-sm font-medium text-gray-700">Website URL</label>
                                <input type="url" name="website" id="website" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('website') }}">
                                @error('website') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="facebook" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                                <input type="url" name="facebook" id="facebook" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('facebook') }}">
                                @error('facebook') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="twitter" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                                <input type="url" name="twitter" id="twitter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('twitter') }}">
                                @error('twitter') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="instagram" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                                <input type="url" name="instagram" id="instagram" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('instagram') }}">
                                @error('instagram') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                                <input type="url" name="linkedin" id="linkedin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('linkedin') }}">
                                @error('linkedin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="youtube" class="block text-sm font-medium text-gray-700">YouTube URL</label>
                                <input type="url" name="youtube" id="youtube" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" value="{{ old('youtube') }}">
                                @error('youtube') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-medium mb-4">Team Members</h3>
                        <p class="text-sm text-gray-500 mb-4">Invite members to your team right away via their email address. They must be registered platform users.</p>

                        @if($errors->has('members.*'))
                            <div class="mb-4 text-red-500 text-sm">
                                Please ensure all invited email addresses are valid registered users.
                            </div>
                        @endif

                        <div x-data="{ emails: [''] }">
                            <template x-for="(email, index) in emails" :key="index">
                                <div class="flex gap-2 mb-3">
                                    <input type="email" name="members[]" x-model="emails[index]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" placeholder="User Email Address">
                                    <button type="button" @click="emails.splice(index, 1)" x-show="emails.length > 1" class="bg-red-500 text-white px-3 py-2 rounded text-sm hover:bg-red-600 focus:outline-none transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="emails.push('')" class="mt-2 flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-bold focus:outline-none focus:underline transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Add another member
                            </button>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('client.teams.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow-sm hover:bg-gray-300 mr-2">Cancel</a>
                            <button type="submit" class="bg-black text-white px-4 py-2 rounded shadow-sm hover:bg-gray-800">Create Team</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
