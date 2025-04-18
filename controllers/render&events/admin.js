import EventListener from '../../src/js/events.js';
import QuestionRenderer from '../../src/js/render.js';

document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    await eventListener.initSessionData();

    const userRenderer = new QuestionRenderer('#user-container', '#modules', eventListener.userId);
    const questionRenderer = new QuestionRenderer('#question-container');
    const moduleRenderer = new QuestionRenderer('#module-container', '#module-filter');
    const canvasRenderer = new QuestionRenderer('#color-canvas', '#edit-color-canvas')


    const userList = await userRenderer.fetchData('../controllers/admin/get_users.php');
    const questionList = await questionRenderer.fetchData('../controllers/list_question.php');
    const moduleFilter = await moduleRenderer.fetchData('../controllers/list_modules.php');
    let moduleNameArr = [];

    moduleFilter.forEach(module => {
        moduleNameArr.push(module.module_name);
    })

    const moduleList = await moduleRenderer.fetchData('../controllers/admin/get_modules.php', {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ module_name: moduleNameArr })
    })

    userRenderer.renderAdminUsers(userList);
    questionRenderer.renderAdminQuestions(questionList);
    moduleRenderer.renderAdminModulesFilter(moduleFilter);
    moduleRenderer.renderAdminModules(moduleList);
    userRenderer.renderModules(moduleFilter);
    canvasRenderer.renderColorHolder();
    canvasRenderer.renderColorCanvas();
    canvasRenderer.renderEditCanvas();

    eventListener.start();
});