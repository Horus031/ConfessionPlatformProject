<header class="font-poppins fixed top-0 w-full flex justify-between items-center z-60 p-3 shadow-lg bg-white dark:bg-gray-900  border-b border-gray-400 dark:border-gray-700 animate-postSlideIn">
    <div class="hidden md:flex items-center px-3 pt-3 pb-2">
        <img loading="lazy" src="../assets/images/weblogo.png" alt="" class="-mt-4 -mb-4 -ml-4 h-20">
        <span class="text-sm md:text-lg font-semibold  dark:text-white ">Knowledge Nexus</span>
    </div>

    <button id="openMenu" class="text-3xl rounded-lg hover-bg-gray-100 md:hidden p-2 dark:text-gray-400">
        <span class="material-symbols-rounded custom-icon">
            menu
        </span>
    </button>

    <div class="relative group flex-1 md:mx-4 2xl:mx-8">
        <div class="text-3xl font-light dark:text-gray-400">
            <span class="material-symbols-rounded custom-icon absolute right-4 top-1/6">search</span>
        </div>
        <div class="relative">
            <input type="text" name="searchInput" id="searchInput" class="text-black border-1 text-lg rounded-lg h-10 pl-3 border-secondary w-full flex-1 e dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search question..." autocomplete="off">
            <div id="searchSuggestions" class="absolute bg-white border border-gray-200 rounded-lg shadow-lg px-4 py-2 mt-1 w-full hidden group-focus:block">

            </div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <button class="relative group">
            <div id="notify-btn" class="relative text-3xl font-light dark:text-gray-400 hover:bg-gray-200 p-2 rounded-full active:scale-90">
                <span class="material-symbols-rounded custom-icon">notifications</span>

            </div>
            <div id="notify-container" class="absolute right-0 top-18 shadow-[0_5px_12px_-6px] z-10 rounded-lg bg-white dark:bg-gray-800 dark:border-1 dark:border-gray-400 w-90 hidden before:content-[''] before:absolute before:right-13 before:-top-4 before:w-12 before:h-4 before:bg-transparent">
                <div class="flex w-full justify-between items-center p-2 px-4 space-x-8 border-b border-secondary">
                    <span class="text-sm font-bold dark:text-gray-400">Notification</span>
                    <span id="marknotify-btn" class="text-nowrap text-sm text-blue-500 cursor-pointer">Mark all as read</span>
                </div>

                <div id="notify-popup" class="h-28 overflow-y-auto scroll">

                </div>

                <div class="border-t-1 border-text dark:border-gray-400 py-2">
                    <a href="main.html.php?page=notification" class="text-[#4E87F1]">See your all notification</a>
                </div>
            </div>
        </button>
        <button class="relative group">
            <img id="user-btn" loading="lazy" src="<?= isset($_SESSION['avatarURL']) ? $_SESSION["avatarURL"] : '../assets/images/user.png'; ?>" alt="" class="h-10 rounded-full">
            <div id="users-popup" class="absolute bg-white border-1 rounded-md shadow-[0_4px_12px_-4px] top-12 right-0 w-40 z-70 hidden lg:group-hover:block before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent dark:bg-gray-900 dark:border-gray-600">
                <a href="main.html.php?page=profile&tag_name=<?= $_SESSION['tag_name'] ?>" class="flex items-center rounded-md text-3xl font-light space-x-4 p-3 hover:bg-gray-200 cursor-pointer dark:text-gray-400">
                    <span class="material-symbols-rounded custom-icon">account_circle</span>
                    <span class="text-lg font-normal">Profile</span>
                </a>
                <a href="../controllers/logout.php" class="flex items-center rounded-md text-3xl font-light space-x-4 p-3 hover:bg-gray-200 cursor-pointer dark:text-gray-400">
                    <span class="material-symbols-rounded custom-icon">logout</span>
                    <span class="text-lg font-normal">Logout</span>
                </a>
            </div>
        </button>
    </div>
</header>

<!-- Menu mobile -->
<aside id="menu" class="font-poppins w-2/3 bg-white dark:bg-gray-900  -translate-x-full  h-full z-80 border-r border-gray-400 dark:border-gray-700  transition-all fixed md:block md:fixed md:mt-23.5 md:w-46 md:-translate-x-0 lg:w-46 xl:w-56 2xl:w-72">
    <nav id="navbar" class="flex-1 bg-white dark:bg-gray-900  md:h-full z-2 animate-slideRight">
        <div>
            <div class="flex flex-col mt-4 space-y-2 text-3xl font-light transition-all">
                <a href="main.html.php?page=home" id="home-btn" class="flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <span class="material-symbols-rounded custom-icon">home</span>
                    <span class="text-lg font-normal">Home</span>
                </a>

                <a href="main.html.php?page=question" id="ques-btn" class="flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <span class="material-symbols-rounded custom-icon">quiz</span>
                    <span class="text-lg font-normal">Questions</span>
                </a>

                <a href="main.html.php?page=tag" id="tag-btn" class="flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <span class="material-symbols-rounded custom-icon">sell</span>
                    <span class="text-lg font-normal">Tags</span>
                </a>

                <a href="main.html.php?page=history" id="history-btn" class="flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <span class="material-symbols-rounded custom-icon">history</span>
                    <span class="text-lg font-normal">History</span>
                </a>

                <a href="main.html.php?page=saved" id="saved-btn" class="flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <span class="material-symbols-rounded custom-icon">bookmark</span>
                    <span class="text-lg font-normal">Saved</span>
                </a>

                <a href="main.html.php?page=findusers" id="findusers-btn" class="flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <span class="material-symbols-rounded custom-icon">groups</span>
                    <span class="text-lg font-normal">Users</span>
                </a>


                <a href="main.html.php?page=contact" id="home-btn" class="flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <span class="material-symbols-rounded custom-icon">contact_support</span>
                    <span class="text-lg font-normal">Contact</span>
                </a>

                <button id="darkmode-btn" class="text-3xl w-full flex text-gray-700 dark:text-gray-400 items-center space-x-3 px-3 py-2 transition-all">
                    <div class="font-light transition-all dark:text-amber-300 dark:fill-amber-300">
                        <span class="material-symbols-rounded custom-icon darkmode-icon">dark_mode</span>
                    </div>
                    <span class="text-lg font-normal">Dark Mode</span>
                </button>

            </div>


            <button id="closeMenu" class="absolute -right-8 top-[65%] bg-white p-4 border-1 text-3xl text-light border-text-light rounded-full -translate-y-1/2 z-10 hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                <span class="material-symbols-rounded custom-icon">
                    chevron_left
                </span>
            </button>

            <div class="flex justify-center items-center mt-6">
                <a href="main.html.php?page=newpost" class="bg-black text-white dark:border-1 hover:bg-black/80 dark:border-white dark:bg-transparent dark:hover:bg-white/20 font-medium rounded-xl py-1.5 px-8 mt-1 cursor-pointer w-fit text-center text-nowrap">Add question</a>
            </div>

            <div class="text-3xl font-light">

            </div>
        </div>

        <div class="fixed items-center left-2 bottom-30 z-90 lg:w-64 hidden lg:hidden md:flex md:text-sm md:space-x-4 2xl:flex">
            <div class="dark:text-gray-400">
                &#169; 2025 KnowledgeNexus. <br> All rights reserved.
            </div>
        </div>
    </nav>
</aside>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';

    const userId = <?= $_SESSION['user_id'] ?>

    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer('#notify-popup');

        try {
            const notifications = await renderer.fetchData('../controllers/get_notifications.php', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    userId: userId
                })
            })

            renderer.renderNotificationsPopup(notifications, userId)


        } catch (error) {
            console.log('Error fetching data', error);
        }
    })
</script>