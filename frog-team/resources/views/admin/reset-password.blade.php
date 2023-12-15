<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel>
            <h1 class="text-center font-bold text-xl">Reset Password</h1>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="col-md-6">
                        <x-form.input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus/>
                    </div>
                
                    <div class="col-md-6">
                        <x-form.input id="password" type="password" class="form-control" name="password" required/>
                    </div>

                    <div class="col-md-6">
                        <x-form.input id="password-confirm" type="password" class="form-control" name="password confirmation" required/>
                    </div>

                    <x-form.button>Reset My password</x-form.button>
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>
