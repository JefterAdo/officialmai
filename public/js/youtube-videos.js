/**
 * Script pour récupérer et afficher les vidéos YouTube de la chaîne Rassemblement Web TV
 */
document.addEventListener('DOMContentLoaded', function() {
    const apiKey = 'AIzaSyD9D8xgJOqF6hvB-w6g0o_ev8JbC-v-Jkw';
    const channelId = 'UCZpVrNAWFKdZfbKRVGFNKNw'; // ID de la chaîne @rassemblementwebtv5828
    const maxResults = 6; // Nombre de vidéos à afficher

    // Élément où les vidéos seront affichées
    const videosContainer = document.getElementById('youtube-videos-container');
    
    if (!videosContainer) {
        console.error('Conteneur de vidéos YouTube non trouvé');
        return;
    }

    // Fonction pour formater la date
    function formatDate(isoDate) {
        const date = new Date(isoDate);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('fr-FR', options);
    }

    // Récupérer les vidéos de la chaîne
    fetch(`https://www.googleapis.com/youtube/v3/search?key=${apiKey}&channelId=${channelId}&part=snippet,id&order=date&maxResults=${maxResults}&type=video`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la récupération des vidéos');
            }
            return response.json();
        })
        .then(data => {
            if (data.items && data.items.length > 0) {
                // Créer le HTML pour chaque vidéo
                const videosHTML = data.items.map(item => {
                    const videoId = item.id.videoId;
                    const title = item.snippet.title;
                    const thumbnail = item.snippet.thumbnails.high.url;
                    const publishedAt = formatDate(item.snippet.publishedAt);
                    
                    return `
                    <div class="col-md-4 mb-4">
                        <div class="card video-card h-100">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/${videoId}" allowfullscreen></iframe>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">${title}</h5>
                                <p class="card-text text-muted">Publié le ${publishedAt}</p>
                            </div>
                        </div>
                    </div>
                    `;
                }).join('');
                
                // Ajouter les vidéos au conteneur
                videosContainer.innerHTML = `
                <div class="row">
                    ${videosHTML}
                </div>
                `;
            } else {
                videosContainer.innerHTML = '<div class="alert alert-info">Aucune vidéo trouvée</div>';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            videosContainer.innerHTML = `<div class="alert alert-danger">Impossible de charger les vidéos: ${error.message}</div>`;
        });
});
