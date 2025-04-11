<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[20%] transition-all">
    <h1 class="text-text text-2xl font-semibold lg:text-4xl animate-postSlideIn transition-all dark:text-gray-400">Tags</h1>

    <div class="mt-4 space-y-4 transition-all">
        <div class="relative flex text-3xl font-light dark:text-gray-400 animate-postSlideIn">
            <span class="material-symbols-rounded custom-icon absolute h-6 left-2 top-1/5">
                search
            </span>
            <input type="text" name="tagInput" id="tag-search" placeholder="Search tags by name" class="text-black bg-transparent border-1 border-secondary rounded-lg pl-12 p-2 flex-1 text-lg font-normal dark:border-gray-600 dark:text-gray-400">
        </div>

        <div class="flex flex-col items-end animate-postSlideIn">
            <h4 class="text-right text-text font-medium dark:text-gray-400">Tag Filters</h4>

            <div class="border border-text rounded-md text-right w-fit ">
                <select name="filter-tags" id="filter-tags" class="text-text w-fit border-0 p-2 rounded-md font-medium dark:text-gray-400 dark:border-1 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-0">
                    <option value="all" class="bg-white text-text dark:bg-gray-800">All</option>
                    <option value="general" class="bg-white text-text dark:bg-gray-800">General Subject</option>
                    <option value="prog&tech" class="bg-white text-text dark:bg-gray-800">Programming & Technology</option>
                    <option value="study" class="bg-white text-text dark:bg-gray-800">Study & Productivity</option>
                    <option value="career" class="bg-white text-text dark:bg-gray-800">Career & Guidance</option>
                </select>
            </div>
        </div>

        <div id="tags-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-2 p-2 mt-2">

        </div>
    </div>
</main>
<script type="module" src="../controllers/render&events/tag.js"></script>