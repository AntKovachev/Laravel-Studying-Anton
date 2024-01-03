<x-layout>
    <x-account-navigation heading="My Account">
        <div class="flex flex-col">
            <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <p class="mr-2"><b>Username: </b></p> {{ auth()->user()->username }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <p class="mr-2"><b>Member Since: </b></p> {{ auth()->user()->created_at->format('M jS, Y') }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <p class="mr-2"><b>Number of posts: </b></p> {{ auth()->user()->posts()->count() }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <p class="mr-2"><b>Subscription Status: </b></p>
                                            @if($isSubscribed)
                                                Subscribed
                                                <form action="{{ route('unsubscribe') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="ml-2 text-blue-500 underline">Unsubscribe</button>
                                                </form>
                                            @else
                                                Not Subscribed
                                                <form action="{{ route('newsletter.subscribe') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="ml-2 text-blue-500 underline">Subscribe</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-account-navigation>
</x-layout>
