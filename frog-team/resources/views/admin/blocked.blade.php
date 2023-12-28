<x-layout>
    <x-blocked-setting heading="Blocked Users">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
                                @foreach ($blockedUsers as $blockedUser)
                                    <tr id="friendRow{{ $blockedUser->id }}" class="transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center relative">
                                                <div class="text-sm font-medium text-gray-900 cursor-pointer">
                                                    <button type="button" id="friendDropdown{{ $blockedUser->id }}" onclick="toggleDropdown('friendDropdown{{ $blockedUser->id }}', 'friendRow{{ $blockedUser->id }}', event)">
                                                        {{ $blockedUser->username }}
                                                    </button>
                                                </div>
                                                <div id="dropdownContent{{ $blockedUser->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                                                    <a href="{{ route('unblock.user', ['user' => $blockedUser]) }}" onclick="event.preventDefault(); document.getElementById('unblock-user-form-{{ $blockedUser->id }}').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        Unblock
                                                    </a>
                                                    
                                                    <form id="unblock-user-form-{{ $blockedUser->id }}" action="{{ route('unblock.user', ['user' => $blockedUser]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @php
                                                    $friendship = auth()->user()->getFriendship($blockedUser);
                                                @endphp
                                                @if ($friendship)
                                                    @if ($friendship->status == Multicaret\Acquaintances\Status::BLOCKED)
                                                        Blocked
                                                    @else
                                                        Unknown Status    
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/friendsDropdown.js') }}"></script>
    </x-blocked-setting>
</x-layout>
