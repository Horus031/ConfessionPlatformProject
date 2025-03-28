<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%] transition-all">
    <h1 class="text-2xl font-semibold lg:text-4xl text-text dark:text-gray-400 animate-postSlideIn">Notifications</h1>
    <hr class="border-1 border-secondary mt-2 animate-postSlideIn dark:border-gray-700">
    <button id="clear-notify">
        <h2 class="text-red-500 dark:text-red-300 w-fit mt-2 cursor-pointer active:scale-90">Clear all notifications</h2>
    </button>
    <div id="notification-container" class="mt-4 space-y-4">

    </div>
</main>

<script type="module">
    import EventListener from '../src/js/events.js';
    import QuestionRenderer from '../src/js/render.js';

    const userId = <?= $_SESSION['user_id'] ?>;

    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer('#notification-container');
        const eventListener = new EventListener(userId);

        try {
            const notifications = await renderer.fetchData('../controllers/get_notifications.php', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    userId: userId
                })
            })

            renderer.renderNotifications(notifications, userId)


        } catch (error) {
            console.log('Error fetching data', error);
        }

        eventListener.start();
    })
</script>