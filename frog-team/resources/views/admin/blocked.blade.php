<x-layout>
    <x-blocked-users-setting heading="Blocked Users">
        <div class="flex flex-col">
            <div class="mb-4">
                <form action="{{ route('blocked.users') }}" method="GET">
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
                    @if ($blockedUsers->isEmpty())
                        <p class="text-center text-gray-500 py-5 mt-5">
                            @if ($search)
                                No blocked users found.
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
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($blockedUsers as $blockedUser)
                                    @if (auth()->user()->hasBlocked($blockedUser))
                                        <tr id="friendRow{{ $blockedUser->id }}" class="transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center relative">
                                                    <div class="text-sm font-medium text-gray-900 cursor-pointer">
                                                        <button type="button" id="friendDropdown{{ $blockedUser->id }}" onclick="toggleDropdown('friendDropdown{{ $blockedUser->id }}', 'friendRow{{ $blockedUser->id }}', event)">
                                                            {{ $blockedUser->username }}
                                                        </button>
                                                    </div>
                                                    {{-- <div id="dropdownContent{{ $blockedUser->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                                                        <a href="{{ route('unblock.user', ['user' => $blockedUser]) }}" onclick="event.preventDefault(); document.getElementById('unblock-user-form-{{ $blockedUser->id }}').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            Unblock
                                                        </a>
                                                        <form id="unblock-user-form-{{ $blockedUser->id }}" action="{{ route('unblock.user', ['user' => $blockedUser]) }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </div> --}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @php
                                                        $friendship = auth()->user()->getFriendship($blockedUser);
                                                    @endphp
                                                    @if ($friendship && $friendship->status == Multicaret\Acquaintances\Status::BLOCKED)
                                                        <form method="POST" action="{{ route('unblock.user', ['user' => $blockedUser]) }}" onclick="return confirm('Are you sure you want to unblock {{$blockedUser->username}}?');" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-10 rounded-2xl hover:bg-blue-600">Unblock</button>
                                                        </form>
                                                    @else
                                                        Unknown Status    
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $blockedUsers->links() }}
        </div>
        <script src="{{ asset('js/friendsDropdown.js') }}"></script>
    </x-blocked-users-setting>
</x-layout>
