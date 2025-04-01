import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';


document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#tags-container');
    const eventListener = new EventListener();

    try {
        const tags = await renderer.fetchData('../controllers/list_tags.php');
        renderer.renderTags(tags);


        eventListener.start();
    } catch (error) {
        console.error('Error loading data:', error);
    }
});