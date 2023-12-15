<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel>
                <h1 class="text-center font-bold text-xl">Log in!</h1>
    
                <form method="POST" action="/login" class="mt-10">
                    @csrf
                    <x-form.input name="email" type="email" autocomplete="email"/>
                    <x-form.input name="password" type="password" autocomplete="new-password"/>
                    <x-form.button>Log In</x-form.button>
                </form>
                <form method="GET"action="/forgot-password" class="mt-10">
                    <x-form.button>Forgot Password?</x-form.button>
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>