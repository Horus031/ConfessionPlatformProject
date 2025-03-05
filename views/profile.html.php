<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/mywebsite/src/output.css">
</head>
<body>
    <?php include '../includes/overlay.html.php' ?>
    <?php include '../includes/header.html.php' ?>

    <main class="mt-24 px-2">
        <div class="flex flex-col">
            <div class="flex justify-between items-start px-2">
                <img src="../assets/user.png" alt="" class="h-20">

                <button class="border-1 border-secondary rounded-lg px-3 py-1 font-semibold">Edit profile</button>
            </div>

            <div class="space-y-1 mt-1">
                <h2 class="text-2xl my-2">Vo Minh Nghia</h2>
                <div>
                    <span class="text-text font-medium">@horus031</span>
                    <span class="text-text">•</span>
                    <span class="text-text-light font-medium">Joined February 2025</span>
                </div>
            </div>

            <div class="flex space-x-4 font-medium">
                <div>
                    <span>0</span>
                    <span class="text-text">Followers</span>
                </div>
                <div>
                    <span>0</span>
                    <span class="text-text">Following</span>
                </div>
            </div>

            <div class="flex space-x-4 font-medium">
                <div>
                    <span>0</span>
                    <span class="text-text">Views</span>
                </div>
                <div>
                    <span>0</span>
                    <span class="text-text">Likes</span>
                </div>
            </div>

            <div>
                <button class="border-1 border-secondary rounded-xl px-4 py-1 font-semibold mt-2">
                    Add bio
                </button>
            </div>

            <div class="mt-4">
                <button class="border-1 border-secondary rounded-xl px-4 py-1 font-semibold">
                    @Github
                </button>

                <button class="border-1 border-secondary rounded-xl px-4 py-1 font-semibold">
                    @LinkedIn
                </button>

                <button class="border-1 border-secondary rounded-xl px-4 py-1 font-semibold">
                    +2
                </button>
            </div>
        </div>

        <div class="mt-4 space-y-2">
            <h2 class="font-medium">Top tags by reading days</h2>
            <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg">
                <div class="flex justify-between text-sm">
                    <span class="text-sm text-text-light font-semibold">#frondend</span>
                    <span class="font-semibold">80%</span>
                </div>
                <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
            </div>
            <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg">
                <div class="flex justify-between text-sm">
                    <span class="text-sm text-text-light font-semibold">#frondend</span>
                    <span class="font-semibold">80%</span>
                </div>
                <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
            </div>
            <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg">
                <div class="flex justify-between text-sm">
                    <span class="text-sm text-text-light font-semibold">#frondend</span>
                    <span class="font-semibold">80%</span>
                </div>
                <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
            </div>
            
        </div>

        <div>
            <h2>Your posts</h2>
            <div class="flex border-2 border-secondary">
                <div>
                    <h2>Understanding Linear Algebra Transformation</h2>
                    <p>I'm having trouble visualizing how linear transformation work in 3D...</p>
                    <div class="border-2 border-secondary">

                    </div>
                </div>

                <div>
                    <img src="../assets/user.png" alt="">
                </div>
            </div>
        </div>
    </main>


    <script src="../src/js/events.js"></script>
</body>
</html>