import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';

document.addEventListener('DOMContentLoaded', async function() {
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');
    const renderer = new QuestionRenderer('#post-container');
    const eventListener = new EventListener();
    await eventListener.initSessionData();

    try {
        const postInfo = await renderer.fetchData(`../controllers/get_postdetails.php?id=${postId}`)
        renderer.renderPostDetail(postInfo, eventListener.userId);
    } catch (error) {
        console.error('Error loading data:', error);
    }


    eventListener.start();
});