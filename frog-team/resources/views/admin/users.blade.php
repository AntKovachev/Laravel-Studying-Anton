<x-layout>
    <x-users-setting heading="All Users">
        <div class="flex flex-col">
            <div class="mb-4">
                <form action="{{ route('all.users') }}" method="GET">
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
                @if ($users->count() > 0)
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    @if ($user->username === auth()->user()->username)
                                        @continue;
                                    @endif
                                    <tr id="userRow{{ $user->id }}" class="transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center relative">
                                                <div class="text-sm font-medium text-gray-900 cursor-pointer">
                                                    <button type="button" id="userDropdown{{ $user->id }}" onclick="toggleDropdown('userDropdown{{ $user->id }}', 'userRow{{ $user->id }}', event)">
                                                        {{ $user->username }}
                                                    </button>
                                                </div>
                                                <div id="dropdownContent{{ $user->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                                                    @if (!auth()->user()->hasBlocked($user))
                                                        <a href="{{ route('profiles.show', ['user' => $user]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View</a>
                                                    @endif
                                                    @if ($user->isFriend(auth()->user()))
                                                        <a href="{{ route('remove.friend', ['friend' => $user]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Remove Friend</a>
                                                    @elseif (auth()->user()->hasSentFriendRequestTo($user))
                                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="event.preventDefault(); document.getElementById('cancel-friend-request-form-{{ $user->id }}').submit();">Cancel Friend Request</a>
                                                        <form id="cancel-friend-request-form-{{ $user->id }}" action="{{ route('cancel.friend.request', ['user' => $user]) }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    @elseif (auth()->user()->hasBlocked($user))
                                                        <a href="{{ route('unblock.user', ['user' => $user]) }}" onclick="event.preventDefault(); document.getElementById('unblock-user-form-{{ $user->id }}').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Unblock</a>
                                                        <form id="unblock-user-form-{{ $user->id }}" action="{{ route('unblock.user', ['user' => $user]) }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    @else
                                                        <a href="{{ route('add.friend', ['user' => $user]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Send Friend Request</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @php
                                                    $friendship = auth()->user()->getFriendship($user);
                                                @endphp
                                                @if ($friendship)
                                                    @if ($friendship->status == Multicaret\Acquaintances\Status::PENDING)
                                                        Friend request sent
                                                    @elseif ($friendship->status == Multicaret\Acquaintances\Status::ACCEPTED)
                                                        Friend
                                                    @elseif ($friendship->status == Multicaret\Acquaintances\Status::DENIED)
                                                        Friend request declined
                                                    @elseif ($friendship->status == Multicaret\Acquaintances\Status::BLOCKED)
                                                        Blocked
                                                    @else
                                                        Unknown Status
                                                    @endif
                                                @else
                                                    Not a friend
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500 py-5 mt-5">No users found.</p>
                @endif
            </div>

            <div class="mt-4">
                {{ $users->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </x-users-setting>
    <script src="{{ asset('js/dropdown.js') }}"></script>
</x-layout>
