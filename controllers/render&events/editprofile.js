import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
import ValidateUsers from '../../src/js/validate_users.js';
document.addEventListener('DOMContentLoaded', async function() {
    const tagName = sessionStorage.getItem('editUserTagName');
    const renderer = new QuestionRenderer('#edit-container');
    const eventListener = new EventListener();
    const validation = new ValidateUsers();

    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');

        await validation.checkUserPermissions();

        await eventListener.initSessionData();


        const editUserInfo = await renderer.fetchData(`../controllers/get_editinfo.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                userId: eventListener.userId
            })
        });
        renderer.renderEditUser(editUserInfo);

    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }
    eventListener.start();

})