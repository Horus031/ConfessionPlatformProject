import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';

document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer(null, '#modules');
    const eventListener = new EventListener();
    await eventListener.initSessionData();
    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');
        await eventListener.start();

        const modules = await renderer.fetchData('../controllers/list_modules.php');
        renderer.renderModules(modules);

    } catch (error) {
        console.error(error)
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }
})