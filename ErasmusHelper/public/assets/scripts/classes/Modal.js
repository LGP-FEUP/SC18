/**
 * Modal class
 *
 * Un modal permet d'afficher une vue par dessus la vue courante dans une fenêtre modale
 */
class Modal {

    /**
     * Modal constructor
     *
     * @param view_url URL de la vue correspondante
     * @param view_data Paramètres a passer à la vue
     * @param title Titre optionnel du modal
     */
    constructor({ view_url, view_data, title }) {
        this.viewUrl = view_url;
        this.viewData = view_data;
        this.container = null;
        this.title = title;
    }

    /**
     * Construit le corps du Modal
     *
     * @return {Promise<void>}
     */
    build() {
        this.container = document.createElement("div");
        this.container.classList.add("modal-container");
        const body = document.createElement("div");
        body.classList.add("modal-body");
        this.container.appendChild(body);
        document.body.appendChild(this.container);
        this.container.addEventListener("click", (e) => {
            if (e.target === this.container) this.hide();
        });

        if (this.title) {
            const title = document.createElement("h3");
            title.classList.add("modal-title");
            title.innerText = this.title;
            body.appendChild(title);
        }

        if (this.viewUrl) {
            return ajx(this.viewUrl, "GET", this.viewData ?? []).then(data => {
                body.innerHTML += data;
            });
        }
    }

    /**
     * Affiche le modal
     */
    show() { this.container.classList.add("visible"); }

    /**
     * Cache le modal
     */
    hide() { this.container.classList.remove("visible"); }

}
