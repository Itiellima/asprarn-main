/*
 * Service worker do site e do app Android (TWA gerado no PWABuilder).
 *
 * Regra principal: NÃO guarda páginas no cache. O site tem login e dados pessoais
 * (painel, carteirinha, telas da diretoria), que não podem ficar salvos no aparelho.
 * Só a página offline fica no cache, para aparecer quando não há internet.
 *
 * Ao mudar este arquivo ou a offline.html, troque a VERSAO: o navegador instala
 * o service worker novo e o "activate" apaga o cache da versão anterior.
 */
const VERSAO = 'v2';
const CACHE = `asprarn-offline-${VERSAO}`;
const PAGINA_OFFLINE = '/offline.html';

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE)
            .then((cache) => cache.add(new Request(PAGINA_OFFLINE, { cache: 'reload' })))
            // Assume no lugar da versão antiga sem esperar todas as abas fecharem
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((nomes) => Promise.all(
                nomes.filter((nome) => nome !== CACHE).map((nome) => caches.delete(nome))
            ))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    // Só abertura de página (navegação). Imagens, CSS, JS, uploads e requisições
    // do Livewire seguem direto para a rede, sem o service worker no meio.
    if (event.request.mode !== 'navigate') {
        return;
    }

    event.respondWith(
        fetch(event.request).catch(() => caches.match(PAGINA_OFFLINE, { cacheName: CACHE }))
    );
});
