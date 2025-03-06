<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/mywebsite/src/output.css">
</head>
<body class="font-poppins h-screen overflow-hidden bg-no-repeat bg-linear-to-br from-gradient1 to-gradient2">
    <div class="mt-20">
        <h1 class="text-4xl font-semibold text-center text-white">
            Signup
        </h1> 
        <form action="/mywebsite/controllers/register.php" method="post" class="w-fit mx-auto">
            <div class="">
                <img src="" alt="">
                <input type="text" name="username" id="username" placeholder="Username" class="bg-white rounded-full mt-9 p-3 pl-8 w-72 text-text text-xl shadow-[0_6px_16px_-6px]">
            </div>

            <div>
                <img src="" alt="">
                <input type="password" name="password" id="password" placeholder="Password" class="bg-white rounded-full mt-9 p-3 pl-8 w-72 text-text text-xl shadow-[0_6px_16px_-6px]">
            </div>

            <div>
                <input type="submit" name="signup" value="Signup" class="bg-form-btn rounded-full mt-9 p-3 pl-8 w-72 text-white text-xl text-center font-semibold shadow-text shadow-[0_6px_16px_-6px]">
                <h4 class="text-center text-xs text-white font-medium mt-4">
                    Forgot your password?
                </h4>
            </div>
        </form>

        

        <div class="relative bg-transparent -mt-18">
            <?php include '../includes/wave-background.php' ?>

            <div class="absolute top-40 w-full flex flex-col justify-center items-center">
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
                    <span class="text-text-light">Already have account?</span>
                    <a href="./login.html.php" class="text-form-btn">Log in</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../src/js/resizebackground.js"></script>
</body>
</html>