<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/mywebsite/src/output.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="font-poppins">
    <div class="relative overflow-x-hidden transition-all">
        <div id="overlay" class="fixed bg-black/60 w-full h-full z-2 hidden">

        </div>

        <aside id="menu" class="absolute w-2/3 bg-white -translate-x-full z-50 border-r border-gray-200 md:flex md:flex-col md:w-64 md:static md:-translate-x-0 transition-all">
            <nav class="bg-white h-screen z-2">
                <div class="flex items-center border-b border-secondary px-3 pt-3 pb-2">
                    <img loading="lazy" src="../assets/weblogo.png" alt="" class="h-16 -mt-4 -mb-4 -ml-4">
                    <span class="text-sm">Knowledge Nexus</span>
                </div>

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


                <button id="closeMenu" class="absolute -right-8 top-1/2 bg-white p-4 border-1 border-text-light rounded-full -translate-y-1/2 z-10 hidden">
                    <img  loading="lazy" src="../assets/left-chevron.png" alt="" class="h-6">
                </button>

                <div class="flex justify-center items-center mt-6">
                    <button class="bg-black text-white font-medium rounded-xl py-1.5 px-8 mt-1">Add question</button>
                </div>
            </nav>
        </aside>


        <header class="fixed top-0 w-full flex justify-between items-center p-3 shadow-lg bg-white">
            <button id="openMenu" class="md:hidden p-2 rounded-lg hover-bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                    <path d="M4 6H20M4 12H20M4 18H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="grow-1">
                <input type="text" name="searchInput" id="searchInput" class="border-2 rounded-lg h-10 pl-3 border-gray-400 w-50" placeholder="Search question...">
            </div>

            <div class="flex items-center space-x-4">
                <button>
                    <img loading="lazy" src="../assets/bell.png" alt="" class="h-6">
                </button>
                <button class="relative">
                    <img  loading="lazy" src="../assets/user.png" alt="" class="h-10">
                    <div class="absolute">
                        
                    </div>
                </button>
            </div>
        </header>

        

        <main class="px-2 mt-18">
            <div class="flex mt-2 justify-between items-center rounded-xl p-3 bg-linear-160 from-[#4CAF50] via-[#A5B82C] to-[#FFC107]">
                <div>
                    <h1 class="text-2xl text-white font-bold leading-9">Welcome to Knowledge Nexus, Users</h1>
                    <button class="bg-black text-white font-medium rounded-xl py-1.5 px-8 mt-1">Add question</button>
                </div>
                <div>
                    <?php
                        include '../assets/logo.html.php';
                    ?>
                </div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3">
                <div class="mt-2 border-2 p-4 rounded-md border-gray-200">
                    <div class="flex flex-col">
                        <span class="w-fit rounded-full text-xs text-[#02542D] bg-[#CFF7D3] px-2 font-medium">Mathematic</span>

                        <h2 class="mt-3 font-semibold text-lg w-56">Understanding Linear Algebra Transformation</h2>

                        <p class="mt-3 text-xs text-text-light font-medium">I'm having trouble visualizing how linear transformation work in 3D...</p>

                        <div class="mt-3 border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="../assets/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                        </div>
                        
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/user.png" alt="" class="h-10">
                                <span class="text-xs">John Doe</span>
                                <span class="text-xs">2 hours ago</span>
                            </div>


                            <div class="flex items-center space-x-2 text-sm">
                                <span class="bg-tags p-1 rounded-md">#DSA</span>
                                <span class="bg-tags p-1 rounded-md">+2</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-3">
                            <div class="flex border-2 border-text-light rounded-md px-3 space-x-3">
                                <div class="flex items-center">
                                    <img loading="lazy" src="../assets/like.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img loading="lazy" src="../assets/comments.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/bookmark.png" alt="" class="h-10 p-2">
                                <img loading="lazy" src="..//assets/link.png" alt="" class="h-10 p-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2 border-2 p-4 rounded-md border-gray-200">
                    <div class="flex flex-col">
                        <span class="w-fit rounded-full text-xs text-[#02542D] bg-[#CFF7D3] px-2 font-medium">Mathematic</span>

                        <h2 class="mt-3 font-semibold text-lg w-56">Understanding Linear Algebra Transformation</h2>

                        <p class="mt-3 text-xs text-text-light font-medium">I'm having trouble visualizing how linear transformation work in 3D...</p>

                        <div class="mt-3 border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="../assets/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                        </div>
                        
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/user.png" alt="" class="h-10">
                                <span class="text-xs">John Doe</span>
                                <span class="text-xs">2 hours ago</span>
                            </div>


                            <div class="flex items-center space-x-2 text-sm">
                                <span class="bg-tags p-1 rounded-md">#DSA</span>
                                <span class="bg-tags p-1 rounded-md">+2</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-3">
                            <div class="flex border-2 border-text-light rounded-md px-3 space-x-3">
                                <div class="flex items-center">
                                    <img loading="lazy" src="../assets/like.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img loading="lazy" src="../assets/comments.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/bookmark.png" alt="" class="h-10 p-2">
                                <img loading="lazy" src="..//assets/link.png" alt="" class="h-10 p-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2 border-2 p-4 rounded-md border-gray-200">
                    <div class="flex flex-col">
                        <span class="w-fit rounded-full text-xs text-[#02542D] bg-[#CFF7D3] px-2 font-medium">Mathematic</span>

                        <h2 class="mt-3 font-semibold text-lg w-56">Understanding Linear Algebra Transformation</h2>

                        <p class="mt-3 text-xs text-text-light font-medium">I'm having trouble visualizing how linear transformation work in 3D...</p>

                        <div class="mt-3 border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="../assets/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                        </div>
                        
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/user.png" alt="" class="h-10">
                                <span class="text-xs">John Doe</span>
                                <span class="text-xs">2 hours ago</span>
                            </div>


                            <div class="flex items-center space-x-2 text-sm">
                                <span class="bg-tags p-1 rounded-md">#DSA</span>
                                <span class="bg-tags p-1 rounded-md">+2</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-3">
                            <div class="flex border-2 border-text-light rounded-md px-3 space-x-3">
                                <div class="flex items-center">
                                    <img loading="lazy" src="../assets/like.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img loading="lazy" src="../assets/comments.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/bookmark.png" alt="" class="h-10 p-2">
                                <img loading="lazy" src="..//assets/link.png" alt="" class="h-10 p-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2 border-2 p-4 rounded-md border-gray-200">
                    <div class="flex flex-col">
                        <span class="w-fit rounded-full text-xs text-[#02542D] bg-[#CFF7D3] px-2 font-medium">Mathematic</span>

                        <h2 class="mt-3 font-semibold text-lg w-56">Understanding Linear Algebra Transformation</h2>

                        <p class="mt-3 text-xs text-text-light font-medium">I'm having trouble visualizing how linear transformation work in 3D...</p>

                        <div class="mt-3 border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="../assets/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                        </div>
                        
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/user.png" alt="" class="h-10">
                                <span class="text-xs">John Doe</span>
                                <span class="text-xs">2 hours ago</span>
                            </div>


                            <div class="flex items-center space-x-2 text-sm">
                                <span class="bg-tags p-1 rounded-md">#DSA</span>
                                <span class="bg-tags p-1 rounded-md">+2</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-3">
                            <div class="flex border-2 border-text-light rounded-md px-3 space-x-3">
                                <div class="flex items-center">
                                    <img loading="lazy" src="../assets/like.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img loading="lazy" src="../assets/comments.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/bookmark.png" alt="" class="h-10 p-2">
                                <img loading="lazy" src="..//assets/link.png" alt="" class="h-10 p-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2 border-2 p-4 rounded-md border-gray-200">
                    <div class="flex flex-col">
                        <span class="w-fit rounded-full text-xs text-[#02542D] bg-[#CFF7D3] px-2 font-medium">Mathematic</span>

                        <h2 class="mt-3 font-semibold text-lg w-56">Understanding Linear Algebra Transformation</h2>

                        <p class="mt-3 text-xs text-text-light font-medium">I'm having trouble visualizing how linear transformation work in 3D...</p>

                        <div class="mt-3 border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="../assets/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                        </div>
                        
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/user.png" alt="" class="h-10">
                                <span class="text-xs">John Doe</span>
                                <span class="text-xs">2 hours ago</span>
                            </div>


                            <div class="flex items-center space-x-2 text-sm">
                                <span class="bg-tags p-1 rounded-md">#DSA</span>
                                <span class="bg-tags p-1 rounded-md">+2</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-3">
                            <div class="flex border-2 border-text-light rounded-md px-3 space-x-3">
                                <div class="flex items-center">
                                    <img loading="lazy" src="../assets/like.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img loading="lazy" src="../assets/comments.png" alt="" class="h-10 p-2">
                                    <span>12</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="../assets/bookmark.png" alt="" class="h-10 p-2">
                                <img loading="lazy" src="..//assets/link.png" alt="" class="h-10 p-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div> 


    <script src="../src/js/events.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>



