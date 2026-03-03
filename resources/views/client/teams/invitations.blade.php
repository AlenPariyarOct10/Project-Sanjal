<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Invitations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($invitations->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500">You have no pending team invitations.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="py-4 px-2 font-bold text-sm text-gray-600">TEAM</th>
                                        <th class="py-4 px-2 font-bold text-sm text-gray-600">INVITED BY</th>
                                        <th class="py-4 px-2 font-bold text-sm text-gray-600">DATE</th>
                                        <th class="py-4 px-2 font-bold text-sm text-gray-600 text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invitations as $invitation)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                            <td class="py-4 px-2">
                                                <div class="font-bold text-gray-900">{{ $invitation->team->name }}</div>
                                            </td>
                                            <td class="py-4 px-2">
                                                <div class="text-sm text-gray-700">{{ $invitation->team->creator->name ?? 'Unknown' }}</div>
                                            </td>
                                            <td class="py-4 px-2 text-sm text-gray-600">
                                                {{ $invitation->created_at->diffForHumans() }}
                                            </td>
                                            <td class="py-4 px-2 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <form action="{{ route('client.invitations.update', $invitation->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="bg-black text-white px-3 py-1 rounded text-sm hover:bg-gray-800 font-bold shadow">Accept</button>
                                                    </form>
                                                    <form action="{{ route('client.invitations.update', $invitation->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 font-bold shadow">Reject</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $invitations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
