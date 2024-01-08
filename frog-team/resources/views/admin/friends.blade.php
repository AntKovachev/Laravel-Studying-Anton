<x-layout>
    <x-friends-setting heading="My Friends">
        <div class="flex flex-col">
            <div class="mb-4">
                <form action="{{ route('friends') }}" method="GET">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by username"
                        value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-md"
                    >
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Search</button>
                </form>
            </div>

            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    @if ($friends->isEmpty())
                        <p class="text-center text-gray-500 py-5 mt-5">No friend with that username found.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($friends as $friend)
                                    <tr id="friendRow{{ $friend->id }}" class="transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center relative">
                                                <div class="text-sm font-medium text-gray-900 cursor-pointer">
                                                    <button type="button" id="friendDropdown{{ $friend->id }}" onclick="toggleDropdown('friendDropdown{{ $friend->id }}', 'friendRow{{ $friend->id }}', event)">
                                                        {{ $friend->username }}
                                                    </button>
                                                </div>
                                                <div id="dropdownContent{{ $friend->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                                                    <a href="{{ route('message.friend') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Message</a>
                                                    <a href="{{ route('remove.friend', ['friend' => $friend]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Remove Friend</a>
                                                    <a href="{{ route('block.user', ['user' => $friend]) }}" onclick="return confirm('Are you sure you want to block this user?');" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        Block Friend
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                Online
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
            {{ $friends->links() }}
        </div>
    </x-friends-setting>
    <script src="{{ asset('js/friendsDropdown.js') }}"></script>
</x-layout>
