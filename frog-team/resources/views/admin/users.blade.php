<x-layout>
    <x-users-setting heading="All Users">
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
                                @foreach ($users as $user)
                                    <tr id="userRow{{ $user->id }}" class="transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center relative">
                                                <div class="text-sm font-medium text-gray-900 cursor-pointer">
                                                    <button type="button" id="userDropdown{{ $user->id }}" onclick="toggleDropdown('userDropdown{{ $user->id }}', 'userRow{{ $user->id }}', event)">
                                                        {{ $user->username }}
                                                    </button>
                                                </div>
                                                <div id="dropdownContent{{ $user->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                                                    <a href="{{ route('profiles.show', ['user' => $user]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View</a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add Friend</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $user->status }}
                                                Not a friend
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
    </x-users-setting>
    <script src="{{asset('js/dropdown.js')}}"></script>
</x-layout>
