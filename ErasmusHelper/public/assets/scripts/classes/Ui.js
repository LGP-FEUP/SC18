/**
 * Ui class
 *
 * Gère les interactions classiques avec l'utilisateur
 */
class Ui {

    /**
     * Déclenche une notification textuelle
     *
     * @param message
     * @param type
     */
     static notify(message, type) {
        const container = document.getElementById("notification-container");

        const notification = document.createElement("div");
        notification.classList.add("notification");
        notification.classList.add(type);
        notification.innerText = message;

        container.appendChild(notification);

        setTimeout(() => {
            notification.classList.add("fade");
            setTimeout(() => {
                container.removeChild(notification);
            }, 500);
        }, 5000);
     }

}
