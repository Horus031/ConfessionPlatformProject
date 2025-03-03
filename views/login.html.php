<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./src/output.css" rel="stylesheet">
</head>
<body class="font-poppins h-screen overflow-hidden bg-no-repeat bg-linear-to-br from-gradient1 to-gradient2">
    <div class="mt-20">
        <h1 class="text-4xl font-semibold text-center text-white">
            Login
        </h1> 
        <form action="" method="post" class="w-fit mx-auto">
            <div class="">
                <img src="" alt="">
                <input type="text" name="username" id="username" placeholder="Username" class="bg-white rounded-full mt-9 p-3 pl-8 w-72 text-text text-xl shadow-[0_6px_16px_-6px]">
            </div>

            <div>
                <img src="" alt="">
                <input type="password" name="password" id="password" placeholder="Password" class="bg-white rounded-full mt-9 p-3 pl-8 w-72 text-text text-xl shadow-[0_6px_16px_-6px]">
            </div>

            <div>
                <input type="text" name="login" value="Login" class="bg-form-btn rounded-full mt-9 p-3 pl-8 w-72 text-white text-xl text-center font-semibold shadow-text shadow-[0_6px_16px_-6px]">
                <h4 class="text-center text-xs text-white font-medium mt-4">
                    Forgot your password?
                </h4>
            </div>
        </form>

        <div class="bg-transparent h-fit -mt-18">
            <div class="absolute w-full flex flex-col justify-center items-center bottom-4">
                <div class="flex w-full justify-center items-center">
                    <hr class="text-secondary w-1/4">
                    <h1 class="text-text-light mx-4">or connect with</h1>
                    <hr class="text-secondary w-1/4">
                </div>

                <div class="flex w-full justify-around items-center mt-4">
                    <button class="border-1 border-secondary rounded-lg w-28 p-2">
                        <img src="" alt="">
                        Google
                    </button>

                    <button class="border-1 border-secondary rounded-lg w-28 p-2">
                        <img src="" alt="">
                        Facebook
                    </button>
                </div>

                <div class="mt-8">
                    <span class="text-text-light">Don't have account?</span>
                    <a href="" class="text-form-btn">Sign up</a>
                </div>
            </div>
            <svg width="100%" height="400px" xmlns="http://www.w3.org/2000/svg" class="">
                <defs>
                    <filter id="inset-shadow" x="-50%" y="-50%" width="200%" height="200%">
                        <feComponentTransfer in="SourceAlpha">
                            <feFuncA type="table" tableValues="1 0" />
                        </feComponentTransfer>
                        <feGaussianBlur stdDeviation="5" />
                        <feOffset dx="0" dy="3" result="offsetblur" />
                        <feFlood flood-color="black" result="color" />
                        <feComposite in2="offsetblur" operator="in" />
                        <feComposite in2="SourceAlpha" operator="in" />
                        <feMerge>
                            <feMergeNode in="SourceGraphic" />
                            <feMergeNode />
                        </feMerge>
                    </filter>
                </defs>
                <path d="M 0 150 q 100 30 150 -20 q 75 -70 250 0 l 180 250 l -800 0" stroke="none" stroke-width="0" fill="white" filter="url(#inset-shadow)"/>
            </svg>
        </div>
    </div>
</body>
</html>