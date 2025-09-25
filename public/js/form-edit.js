document.getElementById('enableEdit').addEventListener('click', function() {
            document.getElementById('formFields').disabled = false; // habilita os campos
            document.getElementById('submitBtn').disabled = false; // habilita o botão de submit
            this.disabled = true; // desabilita o botão de habilitar edição
        });