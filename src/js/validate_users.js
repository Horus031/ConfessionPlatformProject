import QuestionRenderer from "./render.js";
import EventListener from "./events.js";

class ValidateUsers {
    constructor() {
        this.currentURL = window.location.href;
    }
    // Check if the user is logged in and has the right permissions
    async checkUserPermissions() {
        const renderer = new QuestionRenderer();

        const sessionData = await renderer.fetchData('../controllers/session_data.php');

        if (this.currentURL.includes('main')) {
            if (this.currentURL.includes('admin')) {
                if (sessionData.role_id !== '2') {
                    // Redirect to 404 page if not an admin
                    window.location.href = '../views/404notfound.html.php';
                    return false;
                }
            }

            if (!sessionData.user_id || !sessionData.role_id) {
                window.location.href = '../views/login.html.php';
                return false;
            }
        }

        

        return true;
    }
}

export default ValidateUsers;
