/**
 * Modal class
 *
 */
class Modal {

    /**
     * Modal constructor
     *
     * @param view_url URL of the corresponding view
     * @param view_data data to give to the view
     * @param title Optional title for this modal
     */
    constructor({ view_url, view_data, title }) {
        this.viewUrl = view_url;
        this.viewData = view_data;
        this.container = null;
        this.title = title;
    }

    /**
     * Builds the modal
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
            return ajx(this.viewUrl, "POST", this.viewData ?? []).then(data => {
                body.innerHTML += data;
            });
        }
    }

    /**
     * Shows the modal
     */
    show() { this.container.classList.add("visible"); }

    /**
     * Hides the modal
     */
    hide() { this.container.classList.remove("visible"); }

}
