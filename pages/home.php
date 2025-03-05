<main class="flex flex-col overflow-hidden px-2 mt-24 items-end">
    <div class="flex mt-2 justify-between items-center rounded-xl p-3 bg-linear-160 from-[#4CAF50] via-[#A5B82C] to-[#FFC107] md:w-3/4 lg:w-5/6 lg:px-8">
        <div class="md:w-72 lg:w-96">
            <h1 class="text-2xl text-white font-bold leading-10 lg:leading-15 lg:text-6xl">Welcome to Knowledge Nexus, Users</h1>
            <button class="bg-black text-white font-medium rounded-xl py-1.5 px-8 mt-4">Add question</button>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" class="-m-10 h-44 md:h-72 lg:h-96">
                <!-- Background -->
                <rect width="300" height="300" fill="white" opacity="0"/>

                <!-- Gradient definitions -->
                <defs>
                    <linearGradient id="centralGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#2962FF"/>
                    <stop offset="100%" stop-color="#1E88E5"/>
                    </linearGradient>
                    
                    <linearGradient id="node1Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#43A047"/>
                    <stop offset="100%" stop-color="#2E7D32"/>
                    </linearGradient>
                    
                    <linearGradient id="node2Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#FB8C00"/>
                    <stop offset="100%" stop-color="#EF6C00"/>
                    </linearGradient>
                    
                    <linearGradient id="node3Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#E53935"/>
                    <stop offset="100%" stop-color="#C62828"/>
                    </linearGradient>
                    
                    <linearGradient id="node4Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#8E24AA"/>
                    <stop offset="100%" stop-color="#6A1B9A"/>
                    </linearGradient>
                    
                    <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
                    <feGaussianBlur stdDeviation="5" result="blur"/>
                    <feComposite in="SourceGraphic" in2="blur" operator="over"/>
                    </filter>
                </defs>

                <!-- Connection lines with animation -->
                <line x1="150" y1="150" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="3s" repeatCount="indefinite"/>
                </line>
                <line x1="250" y1="150" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="2.5s" repeatCount="indefinite"/>
                </line>
                <line x1="150" y1="250" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="3.5s" repeatCount="indefinite"/>
                </line>
                <line x1="250" y1="250" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="4s" repeatCount="indefinite"/>
                </line>

                <!-- Outer ring -->
                <circle cx="200" cy="200" r="110" fill="none" stroke="#2196F3" stroke-width="4" stroke-opacity="0.3"/>

                <!-- Middle ring with pulse animation -->
                <circle cx="200" cy="200" r="90" fill="none" stroke="#2196F3" stroke-width="3" stroke-opacity="0.5">
                    <animate attributeName="r" values="85;95;85" dur="4s" repeatCount="indefinite"/>
                    <animate attributeName="stroke-opacity" values="0.3;0.6;0.3" dur="4s" repeatCount="indefinite"/>
                </circle>

                <!-- Inner ring -->
                <circle cx="200" cy="200" r="75" fill="none" stroke="#2196F3" stroke-width="2" stroke-opacity="0.7"/>

                <!-- Nodes (representing knowledge sources) -->
                <circle cx="150" cy="150" r="28" fill="url(#node1Gradient)" filter="url(#glow)"/>
                <circle cx="250" cy="150" r="28" fill="url(#node2Gradient)" filter="url(#glow)"/>
                <circle cx="150" cy="250" r="28" fill="url(#node3Gradient)" filter="url(#glow)"/>
                <circle cx="250" cy="250" r="28" fill="url(#node4Gradient)" filter="url(#glow)"/>

                <!-- Central hub with glow effect -->
                <circle cx="200" cy="200" r="45" fill="url(#centralGradient)" filter="url(#glow)"/>

                <!-- K letter stylized in the center -->
                <path d="M185,180 L185,220 M185,200 L215,180 M185,200 L215,220" transform="translate(-10, 0)" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>

                <!-- N letter stylized representing connectivity -->
                <path d="M225,180 L225,220 M225,180 L245,220 M245,180 L245,220" transform="translate(-20,0)" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:w-3/4 lg:w-5/6">
        <div class="mt-2 border-2 p-4 rounded-md border-gray-200">
            <div class="flex flex-col">
                <span class="w-fit rounded-full text-xs text-[#02542D] bg-[#CFF7D3] px-2 font-medium">Mathematic</span>

                <h2 class="mt-3 font-semibold text-lg w-56">Understanding Linear Algebra Transformation</h2>

                <p class="mt-3 text-xs text-text-light font-medium">I'm having trouble visualizing how linear transformation work in 3D...</p>

                <div class="mt-3 border-2 border-gray-200 rounded-md">
                    <img loading="lazy" src="../assets/images/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                </div>
                
                <div class="flex justify-between items-center mt-3">
                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/user.png" alt="" class="h-10">
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
                            <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2">
                        <img loading="lazy" src="..//assets/images/link.png" alt="" class="h-10 p-2">
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
                    <img loading="lazy" src="../assets/images/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                </div>
                
                <div class="flex justify-between items-center mt-3">
                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/user.png" alt="" class="h-10">
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
                            <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2">
                        <img loading="lazy" src="..//assets/images/link.png" alt="" class="h-10 p-2">
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
                    <img loading="lazy" src="../assets/images/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                </div>
                
                <div class="flex justify-between items-center mt-3">
                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/user.png" alt="" class="h-10">
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
                            <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2">
                        <img loading="lazy" src="..//assets/images/link.png" alt="" class="h-10 p-2">
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
                    <img loading="lazy" src="../assets/images/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                </div>
                
                <div class="flex justify-between items-center mt-3">
                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/user.png" alt="" class="h-10">
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
                            <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2">
                        <img loading="lazy" src="..//assets/images/link.png" alt="" class="h-10 p-2">
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
                    <img loading="lazy" src="../assets/images/hq720.jpg" alt="" width="100%" height="100px" class="rounded-md">
                </div>
                
                <div class="flex justify-between items-center mt-3">
                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/user.png" alt="" class="h-10">
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
                            <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                            <span>12</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2">
                        <img loading="lazy" src="..//assets/images/link.png" alt="" class="h-10 p-2">
                    </div>
                </div>
            </div>
        </div>
    </div>        

</main>

