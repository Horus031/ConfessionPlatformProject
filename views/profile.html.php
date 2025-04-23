<main id="userprofile-container" class="mt-28 w-full px-4 md:pl-[26%] lg:pl-[20%] xl:pl-[20%] 2xl:pl-[20%]">
    <div id="profile-container" class="flex flex-col md:flex-row md:items-center">
        <div id="profile-actions" class="flex  justify-between items-start px-2 md:flex-col md:items-center md:justify-start dark:bg-transparent z-30">
            <img id="user-img" alt="" aspect-ratio="1/1" class="h-30 w-30 rounded-full mb-4">

            <a id="edit-profile" class="text-text border-1 border-secondary rounded-lg px-3 py-1 font-semibold cursor-pointer dark:border-gray-600 dark:text-gray-400 hidden">Edit profile</a>
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

    <div id="top-tags-container" class="mt-4 space-y-2 transition-all">
        <h2 class="text-text font-medium animate-fadeIn dark:text-white">Top tags by reading days</h2>


    </div>

    <div class="mt-4 font-medium">
        <h2 id="your-post" class="text-text animate-fadeIn dark:text-white">Your posts</h2>
        <div id="mypost-container" class="grid w-full lg:grid-cols-2 2xl:grid-cols-3 gap-4">

        </div>
    </div>
</main>

<div id="follow-overlay" class="font-poppins absolute items-center justify-center bg-black/60 h-full top-0 bottom-0 left-0 right-0 z-90 hidden">
    <div class=" ">

    </div>
</div>

<script type="module" src="../controllers/render&events/profile.js"></script>