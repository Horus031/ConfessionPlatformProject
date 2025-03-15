<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%] transition-all">
    <div class="flex items-center">
        <a href="main.html.php?page=home">
            <img src="../assets/images/left-chevron.png" alt="" class="h-12 hover:bg-secondary rounded-full p-2">
        </a>
        <span class="font-semibold text-xl">Back to home</span>
    </div>

    <div id="postdetail-container" class="mt-2 border-2 p-4 rounded-md border-secondary">
        <div class="flex flex-col">
            <input type="hidden" name="post_id" id="post_id" value="">

            <div id="module-container" class="flex justify-between items-center">
                <span id="module-name" class="w-fit rounded-full text-xs px-2 font-medium"></span>


            </div>

            <div class="flex flex-col space-y-4">
                <h2 id="post-title" class="font-semibold text-lg lg:text-2xl"></h2>
                <div id="user-tag" class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-2">
                        <img id="user-avatar" loading="lazy" src="../assets/images/user.png" alt="" class="h-10 rounded-full md:h-14 2xl:h-16">
                        <span id="username" class="text-xs md:text-md lg:text-lg"></span>
                        <span id="created-at" class="text-xs md:text-md lg:text-lg"></span>
                    </div>




                </div>
            </div>

            <hr class="mt-4 text-secondary">

            <p id="post-content" class="mt-3 text-xl text-text"></p>

            <div id="post-image-container" class="mt-3 border-2 border-gray-200 rounded-md lg:w-2/3 2xl:w-1/3">
                <img id="post-image" loading="lazy" src="" alt="Post image" class="w-full rounded-md h-1/3">
            </div>

            <div id="postdetail-action" class="flex justify-between items-center mt-3">
                <div class="flex justify-between w-fit rounded-md space-x-2">
                    <button type="button" id="like-btn" class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                        <img id="like-img" loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                        <span class="like-count"></span>
                    </button>

                </div>

                <div class="flex items-center space-x-2 ">
                    <button id="save-btn">
                        <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2 rounded-md hover:bg-gray-300 transition-all">
                    </button>
                    <button id="link-btn">
                        <img loading="lazy" src="../assets/images/link.png" alt="" class="h-10 p-2 rounded-md hover:bg-gray-300 transition-all">
                    </button>
                </div>
            </div>

            <hr class="mt-4 text-secondary">

            <div class="mt-2 space-y-4">
                <div class="font-semibold text-lg">
                    <span>Comment</span>
                    <span class="comment-count">()</span>
                </div>

                <form id="post-form" class="relative w-full p-2 text-wrap rounded-md border border-secondary h-40">
                    <textarea name="commentValues" id="commentValues" placeholder="Write something..." class="w-full h-2/3"></textarea>

                    <button id="post-comment" class="absolute bottom-2 right-4 border py-2 px-6 font-medium rounded-full bg-black text-white">Post</button>
                </form>

                <div id="comment-container" class="flex flex-col space-y-2">

                </div>
            </div>
        </div>
    </div>
</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';

    const userId = <?= $_SESSION['user_id'] ?>;

    document.addEventListener('DOMContentLoaded', async function() {
        const urlParams = new URLSearchParams(window.location.search);
        const postId = urlParams.get('id');
        const renderer = new QuestionRenderer('#post-container');
        const eventListener = new EventListener(userId);

        try {
            const postInfo = await renderer.fetchData(`../controllers/get_postdetails.php?id=${postId}`)
            renderer.renderPostDetail(postInfo, userId);
        } catch (error) {
            console.error('Error loading data:', error);
        }


        eventListener.start();
    });
</script>