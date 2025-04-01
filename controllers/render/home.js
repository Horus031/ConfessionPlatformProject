import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#question-container');
    const addQuestionButton = document.querySelector('#addques-btn');
    const eventListener = new EventListener();

    if (addQuestionButton) {
        addQuestionButton.addEventListener('click', function() {
            window.location.href = '../../views/main.html.php?page=newpost';
        });
    }

    try {
        const questions = await renderer.fetchData('../controllers/list_question.php');
        renderer.renderQuestions(questions, eventListener.userId);


        eventListener.start();
    } catch (error) {
        console.error('Error loading data:', error);
    }
});