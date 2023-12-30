<x-layout>
    <x-friend-requests-setting heading="Friend Requests">
        <div class="flex flex-col">
            <div class="mb-4">
                <form action="{{ route('friend.requests') }}" method="GET">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by username"
                        value="{{ $search }}"
                        class="px-4 py-2 border rounded-md"
                    >
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Search</button>
                </form>
            </div>

            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    @if ($friendRequests->isEmpty())
                        <p class="text-center text-gray-500 py-5 mt-5">
                            @if ($search)
                                No friend requests found.
                            @endif
                        </p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($friendRequests as $friendRequest)
                                    <tr id="userRow{{ $friendRequest->id }}" class="transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center relative">
                                                <div class="text-sm font-medium text-gray-900 cursor-pointer">
                                                    {{ $friendRequest->username }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="mt-2">
                                                <form method="POST" action="{{ route('accept.friend.request', $friendRequest->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-block px-4 py-2 text-sm text-green-500 hover:bg-gray-100 border border-green-500 rounded-xl">Accept</button>
                                                </form>
                                                <form method="POST" action="{{ route('decline.friend.request', $friendRequest->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-block px-4 py-2 text-sm text-red-500 hover:bg-gray-100 border border-red-500 rounded-xl">Decline</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $friendRequests->links() }}
        </div>
    </x-friend-requests-setting>
    <script src="{{ asset('js/dropdown.js') }}"></script>
</x-layout>
