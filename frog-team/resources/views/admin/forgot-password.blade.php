<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel>
                <h1 class="text-center font-bold text-xl">Reset Password</h1>
    
                <form method="POST" action="/forgot-password" class="mt-10">
                    @csrf
                    <x-form.input name="email" type="email" autocomplete="username"/>
                    <x-form.button>Send me a password reset link</x-form.button>
    
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>