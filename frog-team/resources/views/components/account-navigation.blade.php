@props(['heading'])

<section class="py-8 max-w-4xl mx-auto">
    <h1 class="text-lg font-bold mb-8 pb-2 border-b">
        {{ $heading }}
    </h1>
    <div class="flex">
        <aside class="w-48 flex-shrink-0">
            <h4 class="font-semibold mb-4">Links</h4>
            <ul>
                <li class="mb-2">
                    <a href="/admin/posts" class="block {{ request()->is('admin/posts') }}">Dashboard</a>
                </li>
            
                <li class="mb-2">
                    <a href="#" x-data="{}" @click.prevent="document.querySelector('#logout-form').submit()">Log Out</a>
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
