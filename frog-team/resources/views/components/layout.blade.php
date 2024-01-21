<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" href="{{ asset('images/bulgaria_favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/bulgaria_favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body style="font-family: Open Sans, sans-serif">
    <section class="px-6 py-8">
        <nav class="md:flex md:justify-between md:items-center">
            <div>
                <a href="/">
                    <img src="/images/logo.svg" alt="Laracasts Logo" width="165" height="16">
                </a>
            </div>

            <div class="mt-8 md:mt-0 flex items-center">
                @auth
                <x-dropdown>
                    <x-slot name="trigger">
                        <button class="text-xs font-bold uppercase">Welcome Back, {{ auth()->user()->name }}!</button>
                    </x-slot>
                    <x-dropdown-item href="/account" :active="request()->is('/account')">My Account</x-dropdown-item>

                    <x-dropdown-item href="#" x-data="{}" @click.prevent="document.querySelector('#logout-form').submit()">Log Out</x-dropdown-item>

                    <form id="logout-form" method="POST" action="/logout" class="hidden">
                        @csrf
                    </form>
                </x-dropdown>

                @else
                <a href="/register" class="text-xs font-bold uppercase">Register</a>
                <a href="/login" class="ml-6 text-xs font-bold uppercase">Log In</a>
                @endauth

                <a href="#newsletter" class="bg-blue-500 ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-5">
                    Subscribe for Updates
                </a>

                <a href="/admin/users" class="bg-blue-500 ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-5">
                    All Users
                </a>
            </div>
        </nav>

        {{ $slot }}

        <footer id="newsletter" class="bg-gray-100 border border-black border-opacity-5 rounded-xl text-center py-16 px-10 mt-16">
            <img src="/images/lary-newsletter-icon.png" alt="" class="mx-auto mb-3" style="width: 145px;">
            <h5 class="text-3xl">Contact us</h5>
            <p class="text-sm mt-3 mt-4">You can contact us using the form below</p>

            <div class="mt-10">
                <div class="relative inline-block mx-auto rounded-full w-full">
            
                    <form action="#" method="post" class="contact-form">
                        @csrf
                        <div class="mb-4">
                            {{-- <label for="email" class="block text-gray-600 text-sm font-semibold mb-2">Email:</label> --}}
                            <input placeholder="Enter your email here" type="email" id="contact_email" name="contact_email" class="border border-gray-300 rounded-md p-2 w-1/2 md:w-1/3" required>
                            <!-- Adjusted width using w-1/2 for small screens and w-1/3 for medium screens -->
                        </div>
            
                        <div class="mb-4">
                            {{-- <label for="message" class="block text-gray-600 text-sm font-semibold mb-2">Message:</label> --}}
                            <textarea id="message" placeholder="Enter your message here..." name="message" class="border border-gray-300 rounded-md p-2 w-full md:w-1/2" rows="4" maxlength="1000" required></textarea>
                            <!-- Adjusted width using w-full for small screens and w-1/2 for medium screens -->
                        </div>
            
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mx-auto mt-4">Submit</button>
                    </form>
                    
                </div>
            </div>
            
        </footer>
    </section>
    <x-flash />
</body>

</html>
