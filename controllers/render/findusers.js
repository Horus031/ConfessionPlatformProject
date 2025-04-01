import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';

document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#users-container');
    const eventListener = new EventListener();

    const users = await renderer.fetchData('../controllers/list_users.php');
    renderer.renderAllUsers(users, eventListener.userId);


    eventListener.start();
})