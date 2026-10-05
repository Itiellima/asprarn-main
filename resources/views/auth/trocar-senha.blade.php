<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            Por segurança, troque sua senha antes de continuar.
            A senha padrão (seu CPF) não poderá mais ser usada.
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('senha.trocar.salvar') }}">
            @csrf

            <div>
                <x-label for="password" value="Nova senha" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus autocomplete="new-password" />
                <p class="mt-1 text-xs text-gray-500">Mínimo de 8 caracteres.</p>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="Confirme a nova senha" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit" form="form-sair" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Sair
                </button>

                <x-button>
                    Salvar nova senha
                </x-button>
            </div>
        </form>

        <form id="form-sair" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    </x-authentication-card>
</x-guest-layout>
