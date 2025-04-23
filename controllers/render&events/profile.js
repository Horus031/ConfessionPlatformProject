import QuestionRenderer from '../../src/js/render.js';
import EventListener from '../../src/js/events.js';

document.addEventListener('DOMContentLoaded', async function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tagName = urlParams.get('tag_name');
    const renderer = new QuestionRenderer('#profile-container');
    const tagsRenderer = new QuestionRenderer('#top-tags-container');
    const eventListener = new EventListener();
    await eventListener.initSessionData();

    try {
        const userInfo = await renderer.fetchData(`../controllers/get_userinfo.php?tag_name=${tagName}`);
        renderer.renderUserProfile(userInfo);

        if (!userInfo['404']) {
            const otherUserId = document.querySelector('#profile-actions').getAttribute('data-value');

            const userPosts = await renderer.fetchData('../controllers/list_question.php');
            renderer.renderUserPosts(userPosts, otherUserId);

            const topTagsReading = await tagsRenderer.fetchData(
                `../controllers/get_top_tags.php?user_id=${tagName === username ? eventListener.userId : otherUserId}`
            );
            tagsRenderer.renderTopTags(topTagsReading);

            const followCounts = await renderer.fetchData(`../controllers/get_follow_counts.php?user_id=${otherUserId}`);
            document.getElementById('follower-count').textContent = followCounts.follower_count;
            document.getElementById('following-count').textContent = followCounts.following_count;

            const userPostCounts = await renderer.fetchData(`../controllers/get_user_counts.php?user_id=${otherUserId}`);
            document.getElementById('view-count').textContent = userPostCounts.total_view_count;
            document.getElementById('like-count').textContent = userPostCounts.total_like_count;
        }

        eventListener.start();
    } catch (error) {
        console.error('Error loading data:', error);
    }
});