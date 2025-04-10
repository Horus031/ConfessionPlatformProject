<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/mywebsite/src/css/output.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
</head>


<body class="font-poppins h-screen overflow-hidden bg-no-repeat bg-linear-to-br from-gradient1 to-gradient2">
    <div id="toast-container" class="absolute -right-2 top-8 z-50 flex items-center w-full max-w-xs p-4 text-text rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 border-2 border-[#3ea29a] translate-x-full transition-all" role="alert">
        <div class="inline-flex items-center justify-center text-3xl shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">

            <span class="material-symbols-outlined custom-icon">
                priority_high
            </span>
        </div>
        <div id="toast-message" class="ms-3 text-sm font-normal">Please fill out all information!</div>
    </div>


    <div class="absolute right-0 top-0 animate-slideLeft transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="visual" viewBox="0 0 1919 1024" width="1919" height="1024" version="1.1">
            <g transform="translate(-50, 0)">
                <path class="animate-wave-medium" opacity="0.5" xmlns="http://www.w3.org/2000/svg" d="M1081 1600L1072.7 1555.5C1064.3 1511 1047.7 1422 1063.3 1333.2C1079 1244.3 1127 1155.7 1129.2 1066.8C1131.3 978 1087.7 889 1052.5 800C1017.3 711 990.7 622 1015 533.2C1039.3 444.3 1114.7 355.7 1124.2 266.8C1133.7 178 1077.3 89 1049.2 44.5L1021 0L1991 0L1991 44.5C1991 89 1991 178 1991 266.8C1991 355.7 1991 444.3 1991 533.2C1991 622 1991 711 1991 800C1991 889 1991 978 1991 1066.8C1991 1155.7 1991 1244.3 1991 1333.2C1991 1422 1991 1511 1991 1555.5L1991 1600Z" fill="#ffffff" stroke-linecap="round" stroke-linejoin="miter" />
            </g>

            <g transform="translate(-100, 0)">
                <path class="animate-wave-medium" opacity="0.5" xmlns="http://www.w3.org/2000/svg" d="M1081 1600L1072.7 1555.5C1064.3 1511 1047.7 1422 1063.3 1333.2C1079 1244.3 1127 1155.7 1129.2 1066.8C1131.3 978 1087.7 889 1052.5 800C1017.3 711 990.7 622 1015 533.2C1039.3 444.3 1114.7 355.7 1124.2 266.8C1133.7 178 1077.3 89 1049.2 44.5L1021 0L1991 0L1991 44.5C1991 89 1991 178 1991 266.8C1991 355.7 1991 444.3 1991 533.2C1991 622 1991 711 1991 800C1991 889 1991 978 1991 1066.8C1991 1155.7 1991 1244.3 1991 1333.2C1991 1422 1991 1511 1991 1555.5L1991 1600Z" fill="#ffffff" stroke-linecap="round" stroke-linejoin="miter" />
            </g>

            <g transform="translate(-50, -50)">
                <path class="animate-wave-reverse" opacity="0.5" xmlns="http://www.w3.org/2000/svg" d="M1081 1600L1072.7 1555.5C1064.3 1511 1047.7 1422 1063.3 1333.2C1079 1244.3 1127 1155.7 1129.2 1066.8C1131.3 978 1087.7 889 1052.5 800C1017.3 711 990.7 622 1015 533.2C1039.3 444.3 1114.7 355.7 1124.2 266.8C1133.7 178 1077.3 89 1049.2 44.5L1021 0L1991 0L1991 44.5C1991 89 1991 178 1991 266.8C1991 355.7 1991 444.3 1991 533.2C1991 622 1991 711 1991 800C1991 889 1991 978 1991 1066.8C1991 1155.7 1991 1244.3 1991 1333.2C1991 1422 1991 1511 1991 1555.5L1991 1600Z" fill="#ffffff" stroke-linecap="round" stroke-linejoin="miter" />
            </g>

            <g transform="translate(-100, -50)">
                <path class="animate-wave-reverse" opacity="0.5" xmlns="http://www.w3.org/2000/svg" d="M1081 1600L1072.7 1555.5C1064.3 1511 1047.7 1422 1063.3 1333.2C1079 1244.3 1127 1155.7 1129.2 1066.8C1131.3 978 1087.7 889 1052.5 800C1017.3 711 990.7 622 1015 533.2C1039.3 444.3 1114.7 355.7 1124.2 266.8C1133.7 178 1077.3 89 1049.2 44.5L1021 0L1991 0L1991 44.5C1991 89 1991 178 1991 266.8C1991 355.7 1991 444.3 1991 533.2C1991 622 1991 711 1991 800C1991 889 1991 978 1991 1066.8C1991 1155.7 1991 1244.3 1991 1333.2C1991 1422 1991 1511 1991 1555.5L1991 1600Z" fill="#ffffff" stroke-linecap="round" stroke-linejoin="miter" />
            </g>
            <path d="M1042 1024L1034 995.5C1026 967 1010 910 1025 853.2C1040 796.3 1086 739.7 1088 682.8C1090 626 1048 569 1014.2 512C980.3 455 954.7 398 978.2 341.2C1001.7 284.3 1074.3 227.7 1083.5 170.8C1092.7 114 1038.3 57 1011.2 28.5L984 0L1919 0L1919 28.5C1919 57 1919 114 1919 170.8C1919 227.7 1919 284.3 1919 341.2C1919 398 1919 455 1919 512C1919 569 1919 626 1919 682.8C1919 739.7 1919 796.3 1919 853.2C1919 910 1919 967 1919 995.5L1919 1024Z" fill="#FFFFFF" stroke-linecap="round" stroke-linejoin="miter" />
        </svg>

        <!-- Step 1 From -->
        <div id="step1-container" class="absolute top-[5%] right-[14%] w-[26%] animate-slideLeft transition-all">
            <div class="text-[#3ea29a] space-y-4">
                <h1 class="text-4xl font-semibold">
                    Register
                </h1>
                <p>Let's connect together from everywhere, start here!</p>
            </div>
            <form id="step1-form" class="font-poppins mx-auto ml-8 mt-8 space-y-8 w-full">
                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-outlined custom-icon">
                        account_circle
                    </span>
                    <input type="text" id="username" placeholder="Username" class="border-b-1 pb-2 border-[#3ea29a] px-12 w-full text-lg text-black focus:outline-0" autocomplete="true">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>


                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-outlined custom-icon">
                        mail
                    </span>
                    <input type="email" id="email" placeholder="Email" class="border-b-1 pb-2 border-[#3ea29a] px-12 w-full text-lg text-black focus:outline-0" autocomplete="true">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>

                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-rounded custom-icon">
                        lock
                    </span>
                    <input type="password" id="password" placeholder="Password" class="border-b-1 pb-2 border-[#3ea29a] px-12 w-full text-lg text-black focus:outline-0" autocomplete="true">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>


                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-rounded custom-icon">
                        lock
                    </span>
                    <input type="password" id="confirm-password" placeholder="Confirm password" class="border-b-1 pb-2 border-[#3ea29a] px-12 w-full text-lg text-black focus:outline-0" autocomplete="true">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>


                <div class="flex flex-col justify-center items-center">
                    <input type="button" id="registerNextBtn" value="Register" class="bg-linear-to-br from-gradient1 to-gradient2 rounded-full mt-9 p-3 pl-8 w-72 text-white text-xl text-center font-semibold shadow-text shadow-[0_6px_16px_-6px]">
                    <div class="mt-8">
                        <span class="text-text-light">Already have account?</span>
                        <a href="./login.html.php" class="text-form-btn">Login</a>
                    </div>
                </div>
            </form>
        </div>


        <!-- Step 2 Form -->
        <div id="step2-container" class="absolute top-[5%] right-[14%] w-[26%] transition-all hidden">
            <div class="text-[#3ea29a] space-y-4">
                <h1 class="text-4xl font-semibold">
                    Great!
                </h1>
                <p>One more step to connect, let's give us your best tag name so everyone can connect with you.</p>
            </div>
            <form id="step2-form" action="/mywebsite/controllers/register.php" method="post" class="font-poppins mx-auto ml-8 mt-8 space-y-8 w-full">
                <input type="hidden" name="username" id="final-username">
                <input type="hidden" name="email" id="final-email">
                <input type="hidden" name="password" id="final-password">


                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-rounded custom-icon">
                        account_circle
                    </span>
                    <input type="text" name="firstName" id="firstname" placeholder="First Name" class="border-b-1 pb-2 border-[#3ea29a] px-12 w-full text-lg text-black focus:outline-0">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>

                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-rounded custom-icon">
                        account_circle
                    </span>
                    <input type="text" name="lastName" id="lastname" placeholder="Last Name" class="border-b-1 pb-2 border-[#3ea29a] px-12 w-full text-lg text-black focus:outline-0">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>


                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-outlined custom-icon">
                        alternate_email
                    </span>
                    <input type="text" name="tagName" id="tagname" placeholder="Your tag name" class="border-b-1 pb-2 border-[#3ea29a] px-12 w-full text-lg text-black font-normal focus:outline-0">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>


                <div class="flex flex-col justify-center items-center">
                    <input type="submit" name="confirm" value="Confirm" class="bg-linear-to-br from-gradient1 to-gradient2 rounded-full mt-9 p-3 pl-8 w-72 text-white text-xl text-center font-semibold shadow-text shadow-[0_6px_16px_-6px]">
                </div>

            </form>
        </div>
    </div>


    <div class="font-pacifico text-white w-1/2 flex flex-col items-center justify-center animate-slideRight transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" style="height: 500px;">
            <!-- Background -->
            <rect width="400" height="400" fill="white" opacity="0" />

            <!-- Gradient definitions -->
            <defs>
                <linearGradient id="centralGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#2962FF" />
                    <stop offset="100%" stop-color="#1E88E5" />
                </linearGradient>

                <linearGradient id="node1Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#43A047" />
                    <stop offset="100%" stop-color="#2E7D32" />
                </linearGradient>

                <linearGradient id="node2Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#FB8C00" />
                    <stop offset="100%" stop-color="#EF6C00" />
                </linearGradient>

                <linearGradient id="node3Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#E53935" />
                    <stop offset="100%" stop-color="#C62828" />
                </linearGradient>

                <linearGradient id="node4Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#8E24AA" />
                    <stop offset="100%" stop-color="#6A1B9A" />
                </linearGradient>

                <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
                    <feGaussianBlur stdDeviation="5" result="blur" />
                    <feComposite in="SourceGraphic" in2="blur" operator="over" />
                </filter>
            </defs>

            <!-- Connection lines with animation -->
            <line x1="150" y1="150" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                <animate attributeName="opacity" values="0.5;0.8;0.5" dur="3s" repeatCount="indefinite" />
            </line>
            <line x1="250" y1="150" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                <animate attributeName="opacity" values="0.5;0.8;0.5" dur="2.5s" repeatCount="indefinite" />
            </line>
            <line x1="150" y1="250" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                <animate attributeName="opacity" values="0.5;0.8;0.5" dur="3.5s" repeatCount="indefinite" />
            </line>
            <line x1="250" y1="250" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                <animate attributeName="opacity" values="0.5;0.8;0.5" dur="4s" repeatCount="indefinite" />
            </line>

            <!-- Outer ring -->
            <circle cx="200" cy="200" r="110" fill="none" stroke="#2196F3" stroke-width="4" stroke-opacity="0.3" />

            <!-- Middle ring with pulse animation -->
            <circle cx="200" cy="200" r="90" fill="none" stroke="#2196F3" stroke-width="3" stroke-opacity="0.5">
                <animate attributeName="r" values="85;95;85" dur="4s" repeatCount="indefinite" />
                <animate attributeName="stroke-opacity" values="0.3;0.6;0.3" dur="4s" repeatCount="indefinite" />
            </circle>

            <!-- Inner ring -->
            <circle cx="200" cy="200" r="75" fill="none" stroke="#2196F3" stroke-width="2" stroke-opacity="0.7" />

            <!-- Nodes (representing knowledge sources) -->
            <circle cx="150" cy="150" r="28" fill="url(#node1Gradient)" filter="url(#glow)" />
            <circle cx="250" cy="150" r="28" fill="url(#node2Gradient)" filter="url(#glow)" />
            <circle cx="150" cy="250" r="28" fill="url(#node3Gradient)" filter="url(#glow)" />
            <circle cx="250" cy="250" r="28" fill="url(#node4Gradient)" filter="url(#glow)" />

            <!-- Central hub with glow effect -->
            <circle cx="200" cy="200" r="45" fill="url(#centralGradient)" filter="url(#glow)" />

            <!-- K letter stylized in the center -->
            <path d="M185,180 L185,220 M185,200 L215,180 M185,200 L215,220" transform="translate(-10, 0)" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />

            <!-- N letter stylized representing connectivity -->
            <path d="M225,180 L225,220 M225,180 L245,220 M245,180 L245,220" transform="translate(-20,0)" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <h1 class="text-4xl py-2 px-8 -mt-36 text-white/70">Knowledge Nexus</h1>

        <p class="font-poppins text-center text-sm mt-20 text-gray-100 px-8">Knowledge Nexus provides the perfect space for meaningful exchanges. Join our growing community today to ask questions, provide valuable answers, and build your professional network while expanding your knowledge horizon. Together, we're building the most comprehensive knowledge base on the web—one question at a time.</p>
    </div>
</body>


<script type="module" src="../controllers/render&events/login&register.js"></script>

</html>