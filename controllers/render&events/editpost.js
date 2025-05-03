import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';
import ValidateUsers from '../../src/js/validate_users.js';
document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    const validation = new ValidateUsers();

    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');

        await validation.checkUserPermissions();

        const postId = sessionStorage.getItem('editPostId');
        const renderer = new QuestionRenderer(null, '#modules');
         
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

    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }

    eventListener.start();

})