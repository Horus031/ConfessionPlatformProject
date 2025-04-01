import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';

document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#saved-container');
    const eventListener = new EventListener();
    try {
        const savedPosts = await renderer.fetchData('../controllers/get_savedposts.php');
        renderer.renderSavedPosts(savedPosts, eventListener.userId);


        eventListener.start();
    } catch (error) {
        console.log(error);
    }

});