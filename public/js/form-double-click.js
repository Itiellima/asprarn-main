document.addEventListener('DOMContentLoaded', function () {
    let enviando = false;

    document.querySelectorAll('form').forEach(form => {
        const submitBtn = form.querySelector('[type="submit"]');

        form.addEventListener('submit', function (e) {

            // 🔥 valida antes de qualquer coisa
            if (!form.checkValidity()) {
                enviando = false;

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Salvar';
                }

                return; // deixa o Bootstrap tratar
            }

            // evita duplo envio
            if (enviando) {
                e.preventDefault();
                return;
            }

            enviando = true;

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Enviando...';
            }
        });

        // reset (caso use modal)
        form.closest('.modal')?.addEventListener('hidden.bs.modal', function () {
            enviando = false;

            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Salvar';
            }

            form.reset();
        });
    });
});