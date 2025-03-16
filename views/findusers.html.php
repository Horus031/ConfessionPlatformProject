<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl">Users</h1>

    <div class="relative flex mt-4">
        <img src="../assets/images/magnify.png" alt="" class="absolute h-6 left-4 top-1/5">
        <input type="text" name="tagInput" id="" placeholder="Search tags by name" class="border-1 border-secondary rounded-lg pl-12 p-2 flex-1">
    </div>

    <div id="user-container" class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-4 mt-6">





    </div>
</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';

    const userId = <?= $_SESSION['user_id'] ?>;
    document.addEventListener('DOMContentLoaded', async function() {
        const eventListner = new EventListener();
        const renderer = new QuestionRenderer('#user-container');

        try {
            const users = await renderer.fetchData('../controllers/list_users.php');
            renderer.renderAllUsers(users, userId);

            eventListner.start();
        } catch (error) {
            console.log(error);
        }
    })
</script>