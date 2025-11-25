<div>
    <style>
        .insta-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .insta-post {
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 10px;
            width: 280px;
            overflow: hidden;
        }
        .insta-post img,
        .insta-post video {
            width: 100%;
            border-radius: 10px;
        }
    </style>

    <h2>Posts do Instagram</h2>

    <div id="instaContainer" class="insta-container"></div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            try {
                const response = await fetch("/api/instagram/media");
                const data = await response.json();
                
                const postsLimitados = data.data.slice(0, 10);

                const container = document.getElementById("instaContainer");

                postsLimitados.forEach(post => {
                    const div = document.createElement("div");
                    div.classList.add("insta-post");

                    let mediaHtml = "";

                    if (post.media_type === "IMAGE" || post.media_type === "CAROUSEL_ALBUM") {
                        mediaHtml = `<img src="${post.media_url}" alt="">`;
                    } else if (post.media_type === "VIDEO") {
                        mediaHtml = `<video src="${post.media_url}" controls></video>`;
                    }

                    div.innerHTML = `
                        ${mediaHtml}
                        <p>${post.caption ?? ""}</p>
                        <a href="${post.permalink}" target="_blank">Abrir no Instagram</a>
                    `;

                    container.appendChild(div);
                });

            } catch (err) {
                console.error("Erro ao carregar posts:", err);
            }
        });
    </script>
</div>
