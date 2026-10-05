<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        @session('primeiro_acesso')
            <div class="mb-4 p-4 rounded-md bg-blue-50 border border-blue-200 text-sm text-blue-900" role="alert">
                <p class="font-semibold mb-1">Cadastro realizado com sucesso!</p>
                <p>Para o seu primeiro acesso, use:</p>
                <ul class="list-disc ms-5 mt-1">
                    <li><strong>E-mail:</strong> o e-mail cadastrado ({{ $value }})</li>
                    <li><strong>Senha:</strong> o seu CPF, somente números</li>
                </ul>
                <p class="mt-2">No primeiro acesso, você será solicitado a criar uma nova senha.</p>
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', session('primeiro_acesso'))" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Senha" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">Lembrar-me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Esqueceu sua senha?
                    </a>
                @endif

                <x-button class="ms-4">
                    Entrar
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
