document.addEventListener("alpine:init", () => {
    Alpine.data("seoAnalyzer", () => ({
        init() {
            this.$wire.on("seo-analysis-complete", (data) => {
                this.updateAnalysis(data);
            });

            this.$wire.on("apply-seo-recommendation", (data) => {
                this.applyRecommendation(data);
            });
        },

        updateAnalysis(data) {
            // Mettre à jour l'interface avec les résultats de l'analyse
            const { analysis, score } = data;

            // Animer le score
            this.$refs.score.style.transition = "all 0.5s ease-out";
            this.$refs.score.textContent = Math.round(score);

            // Mettre à jour les recommandations
            this.updateRecommendations(analysis);
        },

        updateRecommendations(analysis) {
            Object.entries(analysis).forEach(([category, data]) => {
                const categoryEl = this.$refs[`category-${category}`];
                if (categoryEl) {
                    // Mettre à jour le score de la catégorie
                    categoryEl.querySelector(".score").textContent = data.score;

                    // Mettre à jour les recommandations
                    const recommendationsList =
                        categoryEl.querySelector(".recommendations");
                    if (recommendationsList) {
                        recommendationsList.innerHTML = data.recommendations
                            .map((rec) =>
                                this.createRecommendationElement(category, rec)
                            )
                            .join("");
                    }
                }
            });
        },

        createRecommendationElement(category, recommendation) {
            return `
                <li class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">${recommendation}</span>
                    <button 
                        onclick="$wire.applyRecommendation('${category}', '${recommendation}')"
                        class="px-2 py-1 text-xs text-primary-600 hover:text-primary-800">
                        Appliquer
                    </button>
                </li>
            `;
        },

        applyRecommendation(data) {
            const { category, recommendation } = data;

            // Appliquer la recommandation au contenu
            const editor = window.filamentTiptapEditor?.get("content");
            if (editor) {
                // Logique d'application des recommandations selon la catégorie
                switch (category) {
                    case "keyword_analysis":
                        this.applyKeywordRecommendation(editor, recommendation);
                        break;
                    case "title_optimization":
                        this.applyTitleRecommendation(editor, recommendation);
                        break;
                    // Ajouter d'autres cas selon les besoins
                }
            }
        },

        applyKeywordRecommendation(editor, recommendation) {
            // Exemple : Ajouter des mots-clés manquants
            const content = editor.getHTML();
            // Logique d'application des mots-clés
            editor.commands.setContent(
                this.optimizeKeywords(content, recommendation)
            );
        },

        applyTitleRecommendation(editor, recommendation) {
            // Exemple : Optimiser la structure des titres
            const content = editor.getHTML();
            // Logique d'optimisation des titres
            editor.commands.setContent(
                this.optimizeTitles(content, recommendation)
            );
        },

        optimizeKeywords(content, recommendation) {
            // Implémenter la logique d'optimisation des mots-clés
            return content;
        },

        optimizeTitles(content, recommendation) {
            // Implémenter la logique d'optimisation des titres
            return content;
        },
    }));
});
