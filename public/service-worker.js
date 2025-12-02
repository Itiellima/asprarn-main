self.addEventListener("fetch", (event) => {
    if (!navigator.onLine) {
        event.respondWith(
            new Response(
                `<html><body style="display:flex;align-items:center;justify-content:center;height:100vh;font-family:sans-serif;text-align:center;">
                    <div>
                        <h2>Sem conexão</h2>
                        <p>Este aplicativo só funciona online.</p>
                    </div>
                </body></html>`,
                { headers: { "Content-Type": "text/html" } }
            )
        );
    } else {
        event.respondWith(fetch(event.request));
    }
});
