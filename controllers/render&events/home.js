import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#question-container');
    const eventListener = new EventListener();

    try {
        const questions = await renderer.fetchData('../controllers/list_question.php');
        renderer.renderQuestions(questions, eventListener.userId);


        eventListener.start();
    } catch (error) {
        console.error('Error loading data:', error);
    }
});