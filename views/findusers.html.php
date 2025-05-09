<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 xl:pl-[20%] 2xl:pl-[23%] 3xl:pl-[23%] 4xl:pl-[18%] 4xl:pr-[1%] transition-all bg-white dark:bg-gray-900">
    <h1 class="text-text text-2xl font-semibold lg:text-4xl dark:text-gray-400 animate-postSlideIn">Users</h1>

    <div class="relative flex text-3xl font-light dark:text-gray-400 mt-4 animate-postSlideIn">
        <span class="material-symbols-rounded custom-icon absolute h-6 left-2 top-1/5">
            search
        </span>
        <input type="text" name="userInput" id="user-search" placeholder="Search tags by name" class="bg-transparent border-1 border-secondary rounded-lg pl-12 p-2 flex-1 text-lg font-normal dark:border-gray-600 dark:text-gray-400">
    </div>

    <div id="users-container" class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-4 mt-6">





    </div>
</main>

<script type="module" src="../controllers/render&events/findusers.js"></script>