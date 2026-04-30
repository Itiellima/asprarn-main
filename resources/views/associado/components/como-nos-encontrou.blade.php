<div class="container">
    <div class="alert alert-light text-black text-center">
        <strong class="text-black">
            <h2>Como nos encontrou?</h2>
        </strong>

        <div class="container">

            <select class="form-control" id="como_nos_encontrou_descricao" name="como_nos_encontrou_descricao">
                <option value="">Selecione uma opção</option>
                <option value="Google" {{ old('como_nos_encontrou_descricao', $associado->comoNosEncontrou->descricao ?? '') == 'Google' ? 'selected' : '' }}>Google</option>
                <option value="Facebook" {{ old('como_nos_encontrou_descricao', $associado->comoNosEncontrou->descricao ?? '') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                <option value="Instagram" {{ old('como_nos_encontrou_descricao', $associado->comoNosEncontrou->descricao ?? '') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                <option value="Indicação" {{ old('como_nos_encontrou_descricao', $associado->comoNosEncontrou->descricao ?? '') == 'Indicação' ? 'selected' : '' }}>Indicação</option>
                <option value="Reportagens" {{ old('como_nos_encontrou_descricao', $associado->comoNosEncontrou->descricao ?? '') == 'Reportagens' ? 'selected' : '' }}>Reportagens</option>
                <option value="Nao sei/Nao lembro" {{ old('como_nos_encontrou_descricao', $associado->comoNosEncontrou->descricao ?? '') == 'Nao sei/Nao lembro' ? 'selected' : '' }}>Não sei/Não lembro</option>
                <option value="Outro" {{ old('como_nos_encontrou_descricao', $associado->comoNosEncontrou->descricao ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
            </select>

            <label for="como_nos_encontrou_indicacao">Indicação:</label>
            <input type="text" class="form-control" id="como_nos_encontrou_indicacao" name="como_nos_encontrou_indicacao"
                value="{{ old('como_nos_encontrou_indicacao', $associado->comoNosEncontrou->indicacao ?? '') }}" placeholder="Se for indicação, informe quem indicou">

        </div>

    </div>

</div>
