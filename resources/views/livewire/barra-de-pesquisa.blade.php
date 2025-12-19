    <div class="container mb-3">
        <form wire:submit.prevent="pesquisar">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Pesquisar posts..."
                    wire:model.defer="search"
                >
                <button class="btn btn-primary" type="submit">
                    Buscar
                </button>
            </div>
        </form>
    </div>
