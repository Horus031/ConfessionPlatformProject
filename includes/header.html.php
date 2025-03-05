<?php 
    session_start();
?>

<header class="fixed top-0 w-full flex justify-between items-center p-3 shadow-lg bg-white border-b border-secondary">
    <div class="hidden md:flex items-center px-3 pt-3 pb-2">
        <img loading="lazy" src="../assets/weblogo.png" alt="" class="-mt-4 -mb-4 -ml-4 h-20">
        <span class="text-sm md:text-lg">Knowledge Nexus</span>
    </div>  

    <button id="openMenu" class="md:hidden p-2 rounded-lg hover-bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
            <path d="M4 6H20M4 12H20M4 18H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div class="relative flex-1 md:mx-4">
        <img src="../assets/magnify.png" alt="" class="absolute h-6 right-4 top-1/5">
        <input type="text" name="searchInput" id="searchInput" class="text-black border-2 rounded-lg h-10 pl-3 border-black w-50 md:w-full" placeholder="Search question...">
    </div>

    <div class="flex items-center space-x-4">
        <button class="relative group">
            <img loading="lazy" src="../assets/bell.png" alt="" class="h-10 p-2">
            <div class="absolute -right-16 top-10 shadow-[0_5px_12px_-6px] z-10 rounded-lg bg-white w-90 group-hover:block hidden before:content-[''] before:absolute before:right-13 before:-top-4 before:w-12 before:h-4 before:bg-transparent">
                <div class="flex w-full justify-between items-center p-2 px-4 space-x-8 border-b border-secondary">
                    <span class="text-sm text-text-light font-bold">Notification</span>
                    <span class="text-nowrap text-sm text-blue-500">Mark all as read</span>
                </div>

                <div class="mt-2 space-y-4">
                    <div class="flex px-2 text-left space-x-2">
                        <img loading="lazy" src="../assets/user.png" alt="" class="h-8">
                        
                        <div class="flex flex-col space-y-1">
                            <span>Users has sent you a message</span>

                            <span class="text-text-light break-all line-clamp-1">This is an automatically message</span>
                        </div>

                        <div class="flex flex-col space-y-1 text-nowrap mt-1 text-right">
                            <span class="text-xs">Feb 27</span>
                            <span class="text-xs">12:43</span>
                        </div>
                    </div>

                    <div class="flex px-2 text-left space-x-2">
                        <img loading="lazy" src="../assets/user.png" alt="" class="h-8">
                        
                        <div class="flex flex-col space-y-1">
                            <span>Users has sent you a message</span>

                            <span class="text-text-light break-all line-clamp-1">This is an automatically message</span>
                        </div>

                        <div class="flex flex-col space-y-1 text-nowrap mt-1 text-right">
                            <span class="text-xs">Feb 27</span>
                            <span class="text-xs">12:43</span>
                        </div>
                    </div>
                </div>
            </div>
        </button>
        <button class="relative group">
            <img  loading="lazy" src="../assets/user.png" alt="" class="h-10">
            <div class="absolute bg-white rounded-md shadow-[0_4px_12px_-4px] top-12 right-0 w-40 hidden lg:group-hover:block before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent">
                <div class="flex items-center space-x-4 p-3 hover:bg-gray-200">
                    <img loading="lazy" src="../assets/profile.png" alt="" class="h-6">
                    <span>Profile</span>
                </div> 
                <div class="flex items-center space-x-4 p-3 hover:bg-gray-200">
                    <img loading="lazy" src="../assets/settings.png" alt="" class="h-6">
                    <span>Settings</span>
                </div>
                <div class="flex items-center space-x-4 p-3 hover:bg-gray-200">
                    <img loading="lazy" src="../assets/logout.png" alt="" class="h-6">
                    <span>Logout</span>
                </div>
            </div>
        </button>
    </div>
</header>

<!-- Menu mobile -->
<aside id="menu" class="w-2/3 bg-white -translate-x-full h-full z-50 border-r border-gray-200 transition-all fixed md:hidden">  
    <nav class="flex-1 bg-white md:h-full z-2">
        <div class="flex flex-col mt-4 space-y-2">
            <div class="flex items-center space-x-3 px-3 py-2 bg-gray-200">
                <img loading="lazy" src="../assets/home.png" alt="" class="h-6">
                <span>Home</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/question.png" alt="" class="h-6">
                <span>Questions</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/tag.png" alt="" class="h-6">
                <span>Tags</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/history.png" alt="" class="h-6">
                <span>History</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/bookmark.png" alt="" class="h-6">
                <span>Saved</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/group.png" alt="" class="h-6">
                <span>Users</span>
            </div>
        </div>


        <button id="closeMenu" class="absolute -right-8 top-[50%] bg-white p-4 border-1 border-text-light rounded-full -translate-y-1/2 z-10 hidden">
            <img  loading="lazy" src="../assets/left-chevron.png" alt="" class="h-6">
        </button>

        <div class="flex justify-center items-center mt-6">
            <button class="bg-black text-white font-medium rounded-xl py-1.5 px-8 mt-1">Add question</button>
        </div>
    </nav>
</aside>

<aside id="menu" class="bg-white h-full z-50 hidden mt-23 w-46 border-r-2 border-t-2 border-secondary md:block md:fixed lg:w-42 2xl:w-72">  
    <nav class="flex-1 bg-white md:h-full z-2">
        <div class="flex flex-col mt-4 space-y-2">
            <div class="flex items-center space-x-3 px-3 py-2 bg-gray-200">
                <img loading="lazy" src="../assets/home.png" alt="" class="h-6">
                <span>Home</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/question.png" alt="" class="h-6">
                <span>Questions</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/tag.png" alt="" class="h-6">
                <span>Tags</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/history.png" alt="" class="h-6">
                <span>History</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/bookmark.png" alt="" class="h-6">
                <span>Saved</span>
            </div>

            <div class="flex items-center space-x-3 px-3 py-2">
                <img loading="lazy" src="../assets/group.png" alt="" class="h-6">
                <span>Users</span>
            </div>
        </div>


        <button id="closeMenu" class="absolute -right-8 top-[50%] bg-white p-4 border-1 border-text-light rounded-full -translate-y-1/2 z-10 hidden">
            <img  loading="lazy" src="../assets/left-chevron.png" alt="" class="h-6">
        </button>

        <div class="flex justify-center items-center mt-6">
            <button class="bg-black text-white font-medium rounded-xl py-1.5 px-8 mt-1 lg:text-nowrap lg:px-4 2xl:px-8">Add question</button>
        </div>
    </nav>
</aside>