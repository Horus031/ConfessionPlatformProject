import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
document.addEventListener('DOMContentLoaded', async function() {
    const postId = sessionStorage.getItem('editPostId');
    const renderer = new QuestionRenderer(null, '#modules');
    const eventListener = new EventListener();

    try {
        const modules = await renderer.fetchData('../controllers/list_modules.php');
        renderer.renderModules(modules);

        if (!postId) {
            alert("There is no post for editing!");
            window.location.href = "../views/main.html.php?page=home"; // Chuyển về trang chính nếu không có post_id
            return;
        }

        const editPost = await renderer.fetchData('../controllers/get_postdetails.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                post_id: postId
            })
        })
        renderer.renderEditPosts(editPost, postId);

        renderer.renderTagsWithType();


        eventListener.start();
    } catch (error) {
        console.error('Error loading data:', error);
    }
})