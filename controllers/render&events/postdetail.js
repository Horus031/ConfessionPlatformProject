import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
import ValidateUsers from '../../src/js/validate_users.js';

document.addEventListener('DOMContentLoaded', async function() {
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');
    const renderer = new QuestionRenderer('#post-container');
    const eventListener = new EventListener();
    const validation = new ValidateUsers();
    await eventListener.initSessionData();

    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');

        await validation.checkUserPermissions();

        const postInfo = await renderer.fetchData(`../controllers/get_postdetails.php?id=${postId}`)
        renderer.renderPostDetail(postInfo, eventListener.userId);
    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }


    eventListener.start();



});