<main id="postdetails-container" class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[20%] transition-all">
    <div class="flex items-center">
        <a href="main.html.php?page=home" class="flex items-center text-text dark:text-gray-400 hover:bg-secondary text-3xl text-light rounded-full">
            <span class="material-symbols-rounded custom-icon">
                chevron_left
            </span>
        </a>
        <span class="font-semibold text-text text-xl dark:text-gray-400">Back to home</span>
    </div>

    <div id="postdetail-container" class="font-poppins bg-transparent mt-2 border-2 p-4 rounded-md border-secondary dark:border-gray-700 dark:bg-gray-800 animate-postScaleTopLeft transition-all">
        <div class="flex flex-col">
            <input type="hidden" name="post_id" id="post_id" value="">

            <div id="module-container" class="flex justify-between items-center h-10">
                <span id="module-name" class="w-fit rounded-full text-xs px-2 font-medium"></span>


            </div>

            <div class="flex flex-col space-y-2">
                <h2 id="post-title" class="font-bold text-lg lg:text-2xl dark:text-white"></h2>
                <div id="usertags" class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-2">
                        <img id="user-avatar" loading="lazy" src="../assets/images/user.png" alt="" class="h-10 rounded-full md:h-14 2xl:h-16">
                        <span id="username" class="text-xs text-text md:text-md lg:text-lg dark:text-gray-400"></span>
                        <span id="created-at" class="text-xs text-text md:text-md lg:text-lg dark:text-gray-400"></span>
                    </div>




                </div>
            </div>

            <hr class="mt-4 text-secondary dark:text-gray-400">

            <p id="post-content" class="font-roboto mt-3 text-md text-text dark:text-gray-400"></p>

            <a id="post-image-container" data-fancybox="gallery" data-caption="Single image" class="mt-3 rounded-md lg:w-2/3 2xl:w-full">
                <img id="post-image" loading="lazy" src="" alt="Post image" class="w-full rounded-md h-1/3 lg:h-full bg-contain">
            </a>

            <div id="postdetail-action" class="flex justify-between items-center mt-3">
                <div class="flex justify-between w-fit rounded-md space-x-2">
                    <button type="button" id="like-btn" class="flex text-text items-center px-2 rounded-md dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 text-3xl font-light w-full space-x-2 transition-all">
                        <span class="material-symbols-rounded custom-icon like-img">
                            thumb_up
                        </span>
                        <span class="like-count text-lg font-normal"></span>
                    </button>

                </div>

                <div class="flex items-center space-x-2 ">
                    <button id="save-btn" class="rounded-md text-4xl text-text p-1 font-light hover:bg-gray-300 dark:text-gray-400 dark:hover:bg-gray-600 transition-all">
                        <span class="material-symbols-rounded custom-icon saved-img">
                            bookmark
                        </span>
                    </button>
                    <button id="link-btn" class="rounded-md text-4xl text-text p-1 font-light hover:bg-gray-300 dark:text-gray-400 dark:hover:bg-gray-600 transition-all">
                        <span class="material-symbols-rounded custom-icon">
                            link
                        </span>
                    </button>
                </div>
            </div>

            <hr class="mt-4 text-secondary dark:text-gray-400">

            <div class="mt-2 space-y-4">
                <div class="font-semibold text-text text-lg dark:text-gray-400">
                    <span>Comment</span>
                    <span class="comment-count">()</span>
                </div>

                <form id="post-form" class="relative w-full p-2 text-wrap rounded-md border border-secondary dark:border-gray-700 h-40">
                    <textarea name="commentValues" id="commentValues" placeholder="Write something..." class="text-text w-full h-2/3 border-0 dark:text-gray-400 focus:outline-0 focus:ring-0"></textarea>

                    <button id="post-comment" class="absolute bottom-2 right-4 py-2 px-6 font-medium rounded-full bg-black text-white cursor-pointer dark:bg-transparent dark:border-1 dark:border-gray-400 active:scale-90">Post</button>
                </form>

                <div id="comment-container" class="flex flex-col space-y-2">

                </div>
            </div>
        </div>
    </div>
</main>

<script type="module" src="../controllers/render&events/postdetail.js"></script>