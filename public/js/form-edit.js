document.getElementById('enableEdit')?.addEventListener('click', function() {
    document.getElementById('formFields').disabled = false;
    this.disabled = true;
});