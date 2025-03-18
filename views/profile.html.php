<main class="mt-28 w-full px-4 md:pl-[26%] lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <div id="profile-container" class="flex flex-col md:flex-row md:items-center">
        <div id="profile-actions" class="flex  justify-between items-start px-2 md:flex-col md:items-center md:justify-start bg-white z-30">
            <img id="user-img" alt="" aspect-ratio="1/1" class="h-30 w-30 rounded-full mb-4">

            <a id="edit-profile" class="border-1 border-secondary rounded-lg px-3 py-1 font-semibold cursor-pointer hidden">Edit profile</a>
            <a id="follow-btn" class="border-1 bg-blue-500 text-white border-secondary rounded-lg px-3 py-1 font-semibold cursor-pointer hidden">Follow</a>
        </div>

        <div class="space-y-2 mt-1">
            <div id="info-container" class="flex flex-col space-y-2 animate-infoSlide">
                <h2 id="username" class="text-2xl my-1"></h2>

                <div id="social-container" class="space-x-2">
                    <a id="Facebook-link" href=""></a>
                    <a id="Github-link" href=""></a>
                    <a id="LinkedIn-link" href=""></a>

                </div>

            </div>
        </div>
    </div>

    <div id="bio-container" class="mt-4 animate-fadeIn">

    </div>

    <div class="mt-4 space-y-2 transition-all">
        <h2 class="font-medium animate-fadeIn">Top tags by reading days</h2>
        <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg animate-slideRight ">
            <div class="flex justify-between text-sm">
                <span class="text-sm text-text-light font-semibold">#frondend</span>
                <span class="font-semibold">80%</span>
            </div>
            <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
        </div>
        <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg animate-slideRight ">
            <div class="flex justify-between text-sm">
                <span class="text-sm text-text-light font-semibold">#frondend</span>
                <span class="font-semibold">80%</span>
            </div>
            <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
        </div>
        <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg animate-slideRight ">
            <div class="flex justify-between text-sm">
                <span class="text-sm text-text-light font-semibold">#frondend</span>
                <span class="font-semibold">80%</span>
            </div>
            <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
        </div>

    </div>

    <div class="mt-4 font-medium">
        <h2 id="your-post" class="animate-fadeIn">Your posts</h2>
        <div id="mypost-container" class="grid w-full lg:grid-cols-2 2xl:grid-cols-3 gap-4">

        </div>
    </div>
</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';

    const myUserId = <?= $_SESSION['user_id'] ?>

    document.addEventListener('DOMContentLoaded', async function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tagName = urlParams.get('tag_name');
        const renderer = new QuestionRenderer('#profile-container');
        const eventListener = new EventListener(myUserId);

        try {
            const userInfo = await renderer.fetchData(`../controllers/get_userinfo.php?tag_name=${tagName}`);
            renderer.renderUserProfile(userInfo);

            const otherUserId = document.querySelector('#profile-actions').getAttribute('data-value');

            const userPosts = await renderer.fetchData('../controllers/list_question.php');
            renderer.renderUserPosts(userPosts, otherUserId);


            eventListener.start();
        } catch (error) {
            console.error('Error loading data:', error);
        }
    });
</script>