document.addEventListener('DOMContentLoaded', function () {
    let enviando = false;

    document.querySelectorAll('form').forEach(form => {
        const submitBtn = form.querySelector('[type="submit"]');

        form.addEventListener('submit', function (e) {
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

        // Reset se o formulário estiver dentro de modal Bootstrap
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