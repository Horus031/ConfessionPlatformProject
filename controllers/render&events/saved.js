import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
import ValidateUsers from '../../src/js/validate_users.js';

document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#saved-container');
    const eventListener = new EventListener();
    const validation = new ValidateUsers();
    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');

        await validation.checkUserPermissions();

        const savedPosts = await renderer.fetchData('../controllers/get_savedposts.php');
        renderer.renderSavedPosts(savedPosts, eventListener.userId);

    } catch (error) {
        console.log(error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }

    eventListener.start();


});