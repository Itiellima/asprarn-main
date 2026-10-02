/**
 * Reduz fotos antes do envio.
 *
 * Uso: <input type="file" data-redimensionar-foto>
 *
 * Fotos de celular costumam ter vários MB (e no iPhone vêm em HEIC).
 * Aqui a imagem é redesenhada em um canvas e convertida para JPEG,
 * com no máximo LADO_MAXIMO px no maior lado. Isso também respeita a
 * rotação da câmera e remove os metadados (como localização GPS).
 */
(function () {
    // Evita registrar o listener duas vezes se o script for incluído mais de uma vez
    if (window.redimensionarFotoAtivo) return;
    window.redimensionarFotoAtivo = true;

    const LADO_MAXIMO = 1200;
    const QUALIDADE = 0.85;

    function carregarImagem(arquivo) {
        return new Promise(function (resolve, reject) {
            const url = URL.createObjectURL(arquivo);
            const img = new Image();

            img.onload = function () {
                URL.revokeObjectURL(url);
                resolve(img);
            };
            img.onerror = function () {
                URL.revokeObjectURL(url);
                reject(new Error('Imagem não suportada pelo navegador'));
            };

            img.src = url;
        });
    }

    async function redimensionar(arquivo) {
        const img = await carregarImagem(arquivo);

        const escala = Math.min(1, LADO_MAXIMO / Math.max(img.naturalWidth, img.naturalHeight));
        const largura = Math.round(img.naturalWidth * escala);
        const altura = Math.round(img.naturalHeight * escala);

        const canvas = document.createElement('canvas');
        canvas.width = largura;
        canvas.height = altura;

        const ctx = canvas.getContext('2d');
        // Fundo branco para PNG com transparência não ficar preto no JPEG
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, largura, altura);
        ctx.drawImage(img, 0, 0, largura, altura);

        const blob = await new Promise(function (resolve) {
            canvas.toBlob(resolve, 'image/jpeg', QUALIDADE);
        });

        if (!blob) {
            throw new Error('Falha ao converter a imagem');
        }

        const nome = (arquivo.name || 'foto').replace(/\.[^.]+$/, '') + '.jpg';

        return new File([blob], nome, { type: 'image/jpeg', lastModified: Date.now() });
    }

    function alternarEnvio(form, processando) {
        if (!form) return;

        form.querySelectorAll('[type="submit"]').forEach(function (botao) {
            botao.disabled = processando;
        });
    }

    async function aoSelecionar(event) {
        const input = event.target;
        const arquivo = input.files && input.files[0];

        if (!arquivo) return;

        // Sem suporte a DataTransfer não dá para trocar o arquivo; envia o original
        if (typeof DataTransfer === 'undefined') return;

        alternarEnvio(input.form, true);

        try {
            const reduzido = await redimensionar(arquivo);

            const dt = new DataTransfer();
            dt.items.add(reduzido);
            input.files = dt.files;
        } catch (erro) {
            input.value = '';
            alert('Não foi possível ler essa foto. Tire a foto novamente ou escolha uma imagem JPG ou PNG.');
        } finally {
            alternarEnvio(input.form, false);
        }
    }

    document.addEventListener('change', function (event) {
        if (event.target.matches && event.target.matches('input[type="file"][data-redimensionar-foto]')) {
            aoSelecionar(event);
        }
    });
})();
