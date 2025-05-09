import EventListener from '../../src/js/events.js';
import QuestionRenderer from '../../src/js/render.js';
import ValidateUsers from '../../src/js/validate_users.js';

document.addEventListener('DOMContentLoaded', async function() {
    const renderer = new QuestionRenderer('#notification-container');
    const eventListener = new EventListener();
    const validation = new ValidateUsers();
    await eventListener.initSessionData();

    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');

        await validation.checkUserPermissions();

        const notifications = await renderer.fetchData('../controllers/get_notifications.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                userId: eventListener.userId
            })
        })

        renderer.renderNotifications(notifications, eventListener.userId)


    } catch (error) {
        console.log('Error fetching data', error);
    }  finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }

    eventListener.start();


})