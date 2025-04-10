import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
document.addEventListener('DOMContentLoaded', async function() {
    const tagName = sessionStorage.getItem('editUserTagName');
    const renderer = new QuestionRenderer('#edit-container');
    const eventListener = new EventListener();
    await eventListener.initSessionData();

    try {
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

        eventListener.start();
    } catch (error) {
        console.error('Error loading data:', error);
    }
})