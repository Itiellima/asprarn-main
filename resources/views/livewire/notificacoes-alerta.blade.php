<div wire:poll.5s>
    {{-- The whole world belongs to you. --}}

    @auth()
        @if (auth()->user()->hasAnyRole(['admin|moderador']))
            @if ($notificacoes->count() > 0)
                <div class="elementor-button alert alert-info mt-3 text-center">
                    <a href="#"
                    class="elementor-button btn btn-warning">Novas Notificações - ({{ $notificacoes->count() }})</a>
                </div>
            @endif
        @endif
    @endauth
</div>
