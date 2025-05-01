import EventListener from '../../src/js/events.js';
import QuestionRenderer from '../../src/js/render.js';

document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    const renderer = new QuestionRenderer('#history-container');
    await eventListener.initSessionData();

    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');
        await eventListener.start();

        const history = await renderer.fetchData(`../controllers/get_reading_history.php?user_id=${eventListener.userId}`);
        renderer.renderReadingHistory(history);
    } catch (error) {
        console.error('Error loading data:', error);
    }
    finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }
});