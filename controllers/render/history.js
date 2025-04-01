import EventListener from '../../src/js/events.js';
import QuestionRenderer from '../../src/js/render.js';

document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    const renderer = new QuestionRenderer('#history-container');
    await eventListener.initSessionData();

    const history = await renderer.fetchData(`../controllers/get_reading_history.php?user_id=${eventListener.userId}`);
    renderer.renderReadingHistory(history);


    eventListener.start();
});