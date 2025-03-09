<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <div class="flex items-center">
        <a href="main.html.php?page=home">
            <img src="../assets/images/left-chevron.png" alt="" class="h-10">
        </a>
        <span class="font-semibold text-lg">Back to home</span>
    </div>

    <div id="post-container" class="mt-2 border-2 p-4 rounded-md border-secondary">
        <div class="flex flex-col">
            <input type="hidden" name="post_id" id="post_id" value="">

            <div class="flex justify-between items-center">
                <span id="module-name" class="w-fit rounded-full text-xs px-2 font-medium"></span>

                <div class="relative group">
                    <img src="../assets/images/dots.png" class="h-10 hover:bg-gray-300 p-2 rounded-full">

                    <div class="absolute bg-white rounded-md shadow-[0_4px_12px_-4px] top-12 right-0 w-40 hidden lg:group-hover:block before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent">
                        <a href="" class="flex items-center space-x-4 p-3 hover:bg-gray-200 cursor-pointer">
                            <span>View Details</span>
                        </a> 
                        <a class="flex items-center space-x-4 p-3 hover:bg-gray-200">
                            <span>Edit</span>
                        </a>
                        <a href="../controllers/logout.php" class="flex items-center space-x-4 p-3 hover:bg-gray-200">
                            <span class="text-red-400">Delete</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <h2 id="post-title" class="font-semibold text-lg"></h2>
                <div class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-2">
                        <img id="user-avatar" loading="lazy" src="../assets/images/user.png" alt="" class="h-10 rounded-full md:h-16">
                        <span id="username" class="text-xs md:text-lg"></span>
                        <span id="created-at" class="text-xs md:text-lg"></span>
                    </div>

                    <div class="flex items-center space-x-2 text-sm">
                        <span id="post-tag" class="bg-tags p-1 rounded-md"></span>
                    </div>
                </div>
            </div>

            <hr class="mt-4 text-secondary">

            <p id="post-content" class="mt-3 text-xl text-text"></p>

            <div id="post-image-container" class="mt-3 border-2 border-gray-200 rounded-md lg:w-2/3">
                <img id="post-image" loading="lazy" src="" alt="Post image" class="w-full rounded-md h-2/3">
            </div>

            <div class="flex justify-between items-center mt-3">
                <div class="flex justify-between w-fit border-2 border-text-light rounded-md space-x-2">
                    <div class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                        <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                        <span>12</span>
                    </div>
                    <div class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                        <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                        <span>12</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2 ">
                    <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2 rounded-md hover:bg-gray-300 transition-all">
                    <img loading="lazy" src="../assets/images/link.png" alt="" class="h-10 p-2 rounded-md hover:bg-gray-300 transition-all">
                </div>
            </div>

            <hr class="mt-4 text-secondary">

            <div class="flex flex-col mt-2 space-y-2">
                <h2 class="font-semibold text-lg">Comment (2)</h2>

                <div class="bg-[#F1F1F1] flex space-x-2 rounded-md p-2 lg:w-1/2">
                    <img src="../assets/images/user.png" alt="" class="h-10">
                    <div>
                        <h1 class="font-semibold text-md">Horus</h1>
                        <p class="text-sm">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga qui suscipit, eius architecto quo pariatur.</p>
                    </div>
                </div>

                <div class="bg-[#F1F1F1] flex space-x-2 rounded-md p-2 lg:w-1/2">
                    <img src="../assets/images/user.png" alt="" class="h-10">
                    <div>
                        <h1 class="font-semibold text-md">Horus</h1>
                        <p class="text-sm">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga qui suscipit, eius architecto quo pariatur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const postId = urlParams.get('id');

        if (postId) {
            fetch(`../controllers/get_postdetails.php?id=${postId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                    } else {
                        document.getElementById('post_id').value = data.post_id;
                        document.getElementById('module-name').textContent = data.name;
                        document.getElementById('module-name').className = `w-fit rounded-full text-xs px-2 font-medium ${data.bg_class} ${data.text_class}`;
                        document.getElementById('post-title').textContent = data.title;
                        document.getElementById('user-avatar').src = data.avatar ?? '../assets/images/user.png';
                        document.getElementById('username').textContent = data.username;
                        document.getElementById('created-at').textContent = new Date(data.created_at).toLocaleString();
                        document.getElementById('post-tag').textContent = `#${data.name}`;
                        document.getElementById('post-content').textContent = data.content;
                        document.getElementById('post-image').src = data.imageURL ?? '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching post details:', error);
                });
        } else {
            console.error('Post ID not provided');
        }
    });
</script>