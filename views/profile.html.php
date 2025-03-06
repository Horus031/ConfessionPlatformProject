<main class="mt-28 px-4 md:pl-[26%] lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <div class="flex flex-col md:flex-row md:items-center">
        <div class="flex  justify-between items-start px-2 space-y-4 md:flex-col md:items-center md:justify-start">
            <img src="../assets/images/user.png" alt="" aspect-ratio="1/1" class="h-30 w-30 rounded-full">

            <a href="main.html.php?page=editprofile" class="border-1 border-secondary rounded-lg px-3 py-1 font-semibold cursor-pointer">Edit profile</a>
        </div>

        <div class="space-y-2 mt-1">
            <h2 class="text-2xl my-1"><?=$_SESSION['username']?></h2>
            <div>
                <span class="text-text font-medium">@horus031</span>
                <span class="text-text">•</span>
                <span class="text-text-light font-medium">Joined February 2025</span>
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

    <div  class="mt-4 font-medium">
        <h2>Your posts</h2>
        <div id="mypost-container" class="grid lg:grid-cols-2 gap-4">
            
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/list_question.php')
        .then(response => response.json())
        .then(data => {
            const mypostContainer = document.querySelector('#mypost-container');
            let hasPosts = false;
            if (data.error) {
                container.innerHTML = `<p class="text-red-500">${data.error}</p>`;
            } else {
                data.forEach(myPost => {
                    if (myPost.user_id == <?= $_SESSION['user_id'] ?>) {
                        hasPosts = true;
                        const mypostElements = document.createElement('div');
                        mypostElements.classList.add('flex', 'items-center', 'justify-between', 'border-2', 'border-secondary', 'mt-2', 'p-4', 'rounded-lg');
                        mypostElements.innerHTML = `
                            <div class="space-y-2">
                                <h2 class="font-semibold text-xl line-clamp-2">${myPost.title}</h2>
                                <p class="text-sm text-text-light font-medium">${myPost.content}</p>
                                <div class="flex items-center w-fit justify-around border-2 border-secondary rounded-xl p-2 ">
                                    <div class="flex items-center space-x-2 text-text font-medium px-2">
                                        <img src="../assets/images/like.png" alt="" class="h-6">
                                        <span>24</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-text font-medium px-2">
                                        <img src="../assets/images/comments.png" alt="" class="h-6">
                                        <span>12</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-2 border-gray-200 rounded-md">
                                <img loading="lazy" src="${myPost.imageURL}" alt="" class="rounded-md h-30 w-30 md:w-60 md:h-40 2xl:h-50">
                            </div>
                            
                        `;
                        mypostContainer.appendChild(mypostElements);
                    }

                    if (!hasPosts) {
                    mypostContainer.innerHTML = `<p class="text-red-500">There are no posts</p>`;
                    }
                })
            }
        })
    })
</script>