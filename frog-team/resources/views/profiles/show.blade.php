<x-layout>
    <x-user-navigation heading="Account of {{ $user->name }}">
        <div class="flex flex-col">
            <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center"><p class="mr-2"><b>Username: </b></p> {{ $user->username }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center"><p class="mr-2"><b>Member Since: </b></p> {{ $user->created_at->format('M jS, Y') }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center"><p class="mr-2"><b>Number of posts: </b></p> {{ $user->posts()->count() }}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-user-navigation>
</x-layout>
