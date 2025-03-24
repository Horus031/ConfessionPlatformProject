<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl dark:text-gray-400">Reading History</h1>

    <div class="relative flex text-3xl text-light dark:text-gray-400 mt-4">
        <span class="material-symbols-rounded custom-icon absolute h-6 left-2 top-1/5">
            search
        </span>
        <input type="text" name="historyInput" id="" placeholder="Search reading history" class="border-1 border-secondary rounded-lg pl-12 p-2 flex-1 text-lg font-normal dark:border-gray-700">
    </div>

    <div id="history-container" class="mt-4 space-y-4 dark:text-gray-400">

    </div>


</main>

<script type="module">
    const userId = <?= $_SESSION['user_id'] ?>;
    import EventListener from '../src/js/events.js';
    import QuestionRenderer from '../src/js/render.js';

    document.addEventListener('DOMContentLoaded', async function() {
        const eventListener = new EventListener(userId);
        eventListener.start();

        const renderer = new QuestionRenderer('#history-container');
        const history = await renderer.fetchData(`../controllers/get_reading_history.php?user_id=${userId}`);
        renderer.renderReadingHistory(history);
    });
</script>