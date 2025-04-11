<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[20%] transition-all">
    <h1 class="text-2xl text-text font-semibold lg:text-4xl dark:text-white animate-slideRight">Edit your post</h1>


    <form id="edit-form" action="../controllers/edit_userinfo.php" method="post" enctype="multipart/form-data" class="animate-slideRight">
        <input type="hidden" name="postValues" id="post-value">
        <div class="mt-2 space-y-4">
            <input type="text" name="titleValue" id="title" class="border-1 text-text border-text rounded-lg p-2 q px-4 w-full md:w-5/8 lg:w-4/9 dark:border-gray-600 dark:text-gray-400" placeholder="Post title">
        </div>

        <div class="mt-6 flex flex-col w-fit">
            <textarea name="contentValue" id="content" cols="40" rows="8" class="p-2 text-text border-1 border-text rounded-lg dark:border-gray-600 dark:text-gray-400" placeholder="Post content"></textarea>

            <div class="mt-4">
                <label for="imageURL" class="block py-1.5 px-3 cursor-pointer border-1 border-secondary rounded-md bg-[#f8f8f8] text-text text-center hover:bg-[#e8e8e8] dark:bg-transparent dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700">
                    <input type="file" name="imageURL" id="imageURL" class="hidden">
                    <span id="file-name" class="w-44 text-wrap line-clamp-1 m-auto">Upload your image</span>
                </label>
            </div>
        </div>

        <div class="mt-4 flex flex-col">
            <label for="select-tag-type" class="text-text dark:text-gray-400">Select your tag here</label>
            <select name="selectTagType" id="select-tag-type" class="text-text border-1 border-black rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9 dark:text-gray-400 dark:border-gray-700 focus:outline-0 focus:ring-0">
                <option value="" selected class="bg-transparent text-text dark:text-gray-400 dark:bg-gray-900"></option>
                <option value="general" class="bg-transparent text-text dark:text-gray-400 dark:bg-gray-900">General Subject</option>
                <option value="prog&tech" class="bg-transparent text-text dark:text-gray-400 dark:bg-gray-900">Programming & Technology</option>
                <option value="study" class="bg-transparent text-text dark:text-gray-400 dark:bg-gray-900">Study Tips</option>
                <option value="career" class="bg-transparent text-text dark:text-gray-400 dark:bg-gray-900">Career & Guidance</option>
            </select>

            <div class="flex items-center mt-4 space-x-6">
                <select name="tagList" id="tag-list" class="border-1 border-black text-text rounded-lg py-1 px-4 overflow-y-scroll w-full  md:w-5/8 lg:w-4/9 dark:text-gray-400 dark:border-gray-700 focus:outline-0">

                </select>

                <div id="button-container" class="space-x-2 flex">
                    <button type="button" id="add-btn" class="bg-blue-500 p-2 rounded-md text-white">Add</button>
                    <button type="button" id="remove-btn" class="bg-red-500 p-2 rounded-md text-white">Remove</button>
                </div>
            </div>

            <div id="tag-container" class="mt-4">
                <input type="text" name="tagInput" id="tag-input" class="bg-transparent text-text border-1 border-black rounded-lg py-1 px-4 w-full md:w-5/8 lg:w-4/9 dark:text-gray-400 dark:border-gray-700" readonly>
            </div>
        </div>

        <div class="mt-4 flex flex-col">
            <h2 class="text-lg text-text dark:text-gray-400">Select modules</h2>
            <select name="moduleValues" id="modules" class="border-1 border-black text-text rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9 dark:text-gray-400 dark:border-gray-700">

            </select>
        </div>

        <div class="flex justify-between md:w-2/3 lg:w-4/9">
            <button id="cancel-btn" type="button" class="border border-black rounded-lg px-4 py-2 mt-4">
                Cancel
            </button>
            <button type="submit" name="submit" class="bg-black text-white rounded-lg px-4 py-2 mt-4">
                Save
            </button>
        </div>
    </form>

</main>

<script type="module" src="../controllers/render&events/editpost.js"></script>