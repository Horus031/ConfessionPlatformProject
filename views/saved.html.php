<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 xl:pl-[20%] 2xl:pl-[16%] transition-all">
    <h1 class="text-2xl font-semibold lg:text-4xl dark:text-gray-400 animate-postSlideIn">Your saved posts</h1>

    <div class="relative flex mt-4 text-3xl font-light dark:text-gray-400 animate-postSlideIn">
        <span class="material-symbols-rounded custom-icon absolute h-6 left-2 top-1/5">
            search
        </span>
        <input type="text" name="savedInput" id="saved-search" placeholder="Search your saved posts" class="border-1 border-secondary rounded-lg pl-12 p-2 flex-1 text-lg font-normal dark:border-gray-600 dark:text-gray-400">
    </div>

    <div id="saved-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">

    </div>
</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';

    const userId = <?= $_SESSION['user_id'] ?>;
    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer('#saved-container');
        const eventListener = new EventListener(userId);
        try {
            const savedPosts = await renderer.fetchData('../controllers/get_savedposts.php');
            renderer.renderSavedPosts(savedPosts, userId);


            eventListener.start();
        } catch (error) {
            console.log(error);
        }

    })
</script>