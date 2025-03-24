<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl dark:text-white">New post</h1>


    <form id="newpost-form" action="../controllers/add_newpost.php" method="post" enctype="multipart/form-data">
        <div class="mt-2 space-y-4">
            <input type="text" name="titleValue" id="title" class="border-1 border-text rounded-lg p-2 q px-4 w-full md:w-5/8 lg:w-4/9 dark:border-gray-600 dark:text-gray-400" placeholder="Post title">
        </div>

        <div class="mt-6 flex flex-col w-fit">
            <textarea name="contentValue" id="content" cols="40" rows="8" class="p-2 border-1 border-text rounded-lg dark:border-gray-600 dark:text-gray-400" placeholder="Post content"></textarea>

            <div class="mt-4">
                <label for="imageURL" class="block py-1.5 px-3 cursor-pointer border-1 border-secondary rounded-md bg-[#f8f8f8] text-text text-center hover:bg-[#e8e8e8] dark:bg-transparent dark:border-gray-600 dark:text-gray-400">
                    <input type="file" name="imageURL" id="imageURL" class="hidden">
                    <span id="file-name">Upload your image</span>
                </label>
            </div>
        </div>

        <div class="mt-4 flex flex-col">
            <label for="select-tag-type" class="dark:text-gray-400">Select your tag here</label>
            <select name="selectTagType" id="select-tag-type" class="border-1 border-secondary rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9 dark:text-gray-400 dark:border-gray-700 focus:outline-0">
                <option value="" selected class="dark:text-gray-400 dark:bg-gray-900"></option>
                <option value="general" class="dark:bg-gray-900">General Subject</option>
                <option value="prog&tech" class="dark:bg-gray-900">Programming & Technology</option>
                <option value="study" class="dark:bg-gray-900">Study Tips</option>
                <option value="career" class="dark:bg-gray-900">Career & Guidance</option>
            </select>

            <div class="flex items-center mt-4 space-x-6">
                <select name="tagList" id="tag-list" class="border-1 border-secondary rounded-lg py-1 px-4 overflow-y-scroll md:w-5/8 lg:w-4/9 dark:text-gray-400 dark:border-gray-700 focus:outline-0 hidden">

                </select>

                <div id="button-container" class="space-x-2 hidden">
                    <button type="button" id="add-btn" class="bg-blue-500 p-2 rounded-md text-white">Add</button>
                    <button type="button" id="remove-btn" class="bg-red-500 p-2 rounded-md text-white">Remove</button>
                </div>
            </div>

            <div id="tag-container" class="mt-4">
                <input type="text" name="tagInput" id="tag-input" class="border-1 border-text-light dark:text-gray-400 dark:border-gray-700 hidden rounded-lg py-1 px-4 md:w-5/8 lg:w-4/9" readonly>
            </div>
        </div>

        <div class="mt-4 flex flex-col">
            <h2 class="text-lg dark:text-gray-400">Select modules</h2>
            <select name="moduleValues" id="modules" class="border-1 border-secondary rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9 dark:text-gray-400 dark:border-gray-700">

            </select>
        </div>

        <div class="text-right md:text-left">
            <button type="submit" name="submit" class="bg-black text-white rounded-lg px-4 py-2 mt-4">
                Post
            </button>
        </div>
    </form>

</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';
    const userId = <?= $_SESSION['user_id'] ?>;

    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer(null, '#modules');
        const eventListener = new EventListener(userId);
        try {
            const modules = await renderer.fetchData('../controllers/list_modules.php');
            renderer.renderModules(modules);

            eventListener.start();
        } catch (error) {
            console.error(error)
        }

    })
</script>