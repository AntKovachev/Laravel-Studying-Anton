@props(['heading'])

<section class="py-8 max-w-4xl mx-auto">
    <h1 class="text-lg font-bold mb-8 pb-2 border-b">
        {{ $heading }}
    </h1>
    <div class="flex">
        <aside class="w-48 flex-shrink-0">
            <ul>
                <li class="mb-2 mt-2 py-3">
                    <button type="button" class="transition-colors duration-300 bg-blue-500 hover:bg-blue-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8" onclick="window.location.href='/admin/users'">
                        All Users
                    </button>
                </li>

                <li class="mt-5 mb-2">
                    <button type="button" class="transition-colors duration-300 bg-blue-500 hover:bg-blue-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8" onclick="window.history.back()">
                        Go Back
                    </button>
                </li>
            </ul>
        </aside>
    
        <main class="flex-1">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>
</section>
