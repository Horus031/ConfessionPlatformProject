import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';


document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#tags-container');
    const eventListener = new EventListener();

    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');
        await eventListener.start();

        const tags = await renderer.fetchData('../controllers/list_tags.php');
        renderer.renderTags(tags);

    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }
}); 