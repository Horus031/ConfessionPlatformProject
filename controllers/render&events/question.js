import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';

document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#question-container', '#question-filter');
    const eventListener = new EventListener();
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query');

    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');
        await eventListener.start();

        let questions;
        let questionType;
        if (query) {
            questionType = await renderer.fetchData(`../controllers/check_searchvalues.php?query=${encodeURIComponent(query)}`);
            questions = await renderer.fetchData(`../controllers/search_question.php?query=${encodeURIComponent(query)}`);
            console.log(questions);
            document.querySelector('#question-title').textContent = `Questions by ${questionType[0].type}`;
        } else {
            questions = await renderer.fetchData('../controllers/list_question.php');
            document.querySelector('#question-title').textContent = `Question`;
        }

        renderer.renderQuestions(questions, eventListener.userId);
        document.querySelector('#total-question').textContent = `${questions.length}`;
        document.querySelectorAll('div[id^="question-"]').forEach(question => {
            question.classList.add('animate-postScale');
        });

        setTimeout(async () => {
            const modules = await renderer.fetchData('../controllers/list_modules.php');
            renderer.renderModules(modules);
        }, 100);

    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }

});