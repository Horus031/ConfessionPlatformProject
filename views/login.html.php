<!DOCTYPE html>
<html lang="en" class="bg-no-repeat bg-linear-to-br from-gradient1 to-gradient2">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/mywebsite/src/css/output.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="font-poppins h-screen overflow-hidden">
    <div class="absolute right-0 top-0 h-full animate-slideLeft overflow-hidden transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="visual" viewBox="0 0 1919 1024" width="1919" height="1024" version="1.1" class="overflow-hidden lg:translate-x-1/6 xl:translate-x-1/8 2xl:translate-x-0 ">
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

        <div class="absolute top-[30%] right-[14%] w-[26%] animate-slideLeft lg:translate-x-1/3 xl:translate-x-1/3 2xl:translate-x-0 transition-all">
            <div class="text-[#3ea29a] space-y-4">
                <h1 class="text-4xl font-semibold">
                    Login
                </h1>
                <p>Sign in to your account</p>
            </div>
            <form id="login-form" action="../controllers/login.php" method="post" class="font-poppins mx-auto ml-8 mt-8 space-y-8 w-full">
                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-rounded custom-icon">
                        person
                    </span>
                    <input type="text" name="username" id="username" placeholder="Username" class="border-0 border-b-1 border-[#3ea29a] px-12 pb-2 w-full text-lg text-black focus:outline-0 focus:ring-0 valid:border-[#3ea29a]">
                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>

                <div class="relative text-gray-500 text-3xl">
                    <span class="absolute left-2 bottom-2 material-symbols-rounded custom-icon">
                        lock
                    </span>
                    <span class="password-visible absolute right-3 top-1/5 material-symbols-rounded custom-icon text-gray-900 dark:text-gray-400 cursor-pointer select-none">
                        visibility_off
                    </span>
                    <input type="password" name="password" id="password" placeholder="Password" class="border-0 border-b-1 border-[#3ea29a] px-12 pb-2 w-full text-lg text-black focus:outline-0 focus:ring-0">

                    <span class="error-message absolute text-red-500 -bottom-6 left-0 text-xs"></span>
                </div>

                <div class="text-[#3ea29a] flex justify-between items-center accent-amber-50">
                    <div class="flex space-x-2">
                        <input type="checkbox" name="remember_me" id="remember_me" class="accent-[#3ea29a] text-[#3ea29a] focus:outline-0 focus:ring-0">
                        <label for="remember_me" class="text-sm">Remember me</label>
                    </div>

                    <a href="./changepassword.html.php" class="text-right text-sm underline  decoration-solid font-medium">
                        Forgot your password?
                    </a>
                </div>

                <div class="flex flex-col justify-center items-center">
                    <input type="submit" name="login" value="Login" class="bg-linear-to-br from-gradient1 to-gradient2 rounded-full mt-9 p-3 w-72 text-white text-xl text-center font-semibold shadow-text shadow-[0_6px_16px_-6px] cursor-pointer">
                    <div class="mt-8">
                        <span class="text-text-light">Don't have account?</span>
                        <a href="/mywebsite/views/register.html.php" class="text-form-btn cursor-pointer">Sign up</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="font-pacifico absolute xl:-left-[3%] 2xl:-left-0 text-white w-1/2 flex flex-col lg:items-start xl:items-center justify-center animate-slideRight transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" style="height: 500px;" class="lg:w-[350px] xl:w-[400px] 2xl:w-[500px]">
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
            <circle cx="200" cy="200" r="110" fill="none" stroke="white" stroke-width="4" stroke-opacity="0.3" />

            <!-- Middle ring with pulse animation -->
            <circle cx="200" cy="200" r="90" fill="none" stroke="white" stroke-width="3" stroke-opacity="0.5">
                <animate attributeName="r" values="85;95;85" dur="4s" repeatCount="indefinite" />
                <animate attributeName="stroke-opacity" values="0.3;0.6;0.3" dur="4s" repeatCount="indefinite" />
            </circle>

            <!-- Inner ring -->
            <circle cx="200" cy="200" r="75" fill="none" stroke="white" stroke-width="2" stroke-opacity="0.7" />

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

        <h1 class="text-4xl py-2 px-8 -mt-36 text-white/80 text-center">Knowledge Nexus</h1>

        <p class="font-poppins hidden 2xl:block lg:text-left xl:text-center text-sm mt-20 text-gray-100 px-8 lg:w-[400px] xl:w-[500px] 2xl:w-full">Knowledge Nexus provides the perfect space for meaningful exchanges. Join our growing community today to ask questions, provide valuable answers, and build your professional network while expanding your knowledge horizon. Together, we're building the most comprehensive knowledge base on the web—one question at a time.</p>
    </div>



</body>


<script type="module" src="../controllers/render&events/login&register.js"></script>

</html>