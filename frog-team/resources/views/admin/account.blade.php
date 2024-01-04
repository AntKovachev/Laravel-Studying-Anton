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
                                                    <button type="submit" class="transition-colors duration-300 bg-red-500 hover:bg-red-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8">Unsubscribe</button>
                                                </form>
                                            @else
                                                Not Subscribed
                                                <form id="subscribeForm" method="post" action="{{ route('newsletter.subscribe') }}" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                                    <button type="submit" class="transition-colors duration-300 bg-blue-500 hover:bg-blue-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8">Subscribe</button>
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

    @push('scripts')
        <script>
            document.getElementById('subscribeForm').addEventListener('submit', function (event) {
                event.preventDefault();
                subscribeUser();
            });
            
            function subscribeUser() {
                fetch("{{ route('newsletter.subscribe') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        email: "{{ auth()->user()->email }}",
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    document.getElementById('subscribeForm').innerHTML = "Subscribed";
                })
                .catch(error => {
                    console.error('Error:', error.message);
                });
            }
        </script>
    @endpush    
</x-layout>
