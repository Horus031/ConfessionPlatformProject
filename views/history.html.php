<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[20%] transition-all">
    <h1 class="text-text text-2xl font-semibold lg:text-4xl dark:text-gray-400 animate-postSlideIn">Reading History</h1>

    <div class="relative flex text-3xl text-light dark:text-gray-400 mt-4 animate-postSlideIn">
        <span class="material-symbols-rounded custom-icon absolute h-6 left-2 top-1/5">
            search
        </span>
        <input type="text" name="historyInput" id="history-search" placeholder="Search reading history" class="bg-transparent border-1 border-secondary rounded-lg pl-12 p-2 flex-1 text-lg font-normal dark:border-gray-700">
    </div>

    <div id="history-container" class="mt-4 space-y-4 dark:text-gray-400">

    </div>


</main>

<script type="module" src="../controllers/render&events/history.js"></script>