import EventListener from '../../src/js/events.js';
import QuestionRenderer from '../../src/js/render.js';

document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    const renderer = new QuestionRenderer('#user-container');

    const userList = await renderer.fetchData('../controllers/admin/get_users.php');
    
    renderer.renderAdminUsers(userList);


    eventListener.start();
});