<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%] transition-all">
    <div class="flex items-center">
        <a href="main.html.php?page=home">
            <img src="../assets/images/left-chevron.png" alt="" class="h-12 hover:bg-secondary rounded-full p-2">
        </a>
        <span class="font-semibold text-xl">Back to home</span>
    </div>

    <div id="post-container" class="mt-2 border-2 p-4 rounded-md border-secondary">
        <div class="flex flex-col">
            <input type="hidden" name="post_id" id="post_id" value="">

            <div id="module-container" class="flex justify-between items-center">
                <span id="module-name" class="w-fit rounded-full text-xs px-2 font-medium"></span>

                
            </div>

            <div class="flex flex-col space-y-4">
                <h2 id="post-title" class="font-semibold text-lg lg:text-2xl"></h2>
                <div id="user-tag" class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-2">
                        <img id="user-avatar" loading="lazy" src="../assets/images/user.png" alt="" class="h-10 rounded-full md:h-14 2xl:h-16">
                        <span id="username" class="text-xs md:text-md lg:text-lg"></span>
                        <span id="created-at" class="text-xs md:text-md lg:text-lg"></span>
                    </div>


                    
                    
                </div>
            </div>

            <hr class="mt-4 text-secondary">

            <p id="post-content" class="mt-3 text-xl text-text"></p>

            <div id="post-image-container" class="mt-3 border-2 border-gray-200 rounded-md lg:w-2/3">
                <img id="post-image" loading="lazy" src="" alt="Post image" class="w-full rounded-md h-2/3">
            </div>

            <div class="flex justify-between items-center mt-3">
                <div class="flex justify-between w-fit rounded-md space-x-2">
                    <div class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                        <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                        <span id="likeCount">12</span>
                    </div>
                    
                </div>

                <div class="flex items-center space-x-2 ">
                    <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2 rounded-md hover:bg-gray-300 transition-all">
                    <img loading="lazy" src="../assets/images/link.png" alt="" class="h-10 p-2 rounded-md hover:bg-gray-300 transition-all">
                </div>
            </div>

            <hr class="mt-4 text-secondary">

            <div id="comment-container" class="flex flex-col mt-2 space-y-2">
                <h2 id="commentCount" class="font-semibold text-lg">Comment (2)</h2>

                <div class="relative w-full p-2 text-wrap rounded-md border border-secondary h-40">
                    <textarea name="commentValues" id="commentValues" placeholder="Write something..." class="w-full h-2/3"></textarea>

                    <button class="absolute bottom-2 right-4 border py-2 px-6 font-medium rounded-full bg-black text-white">Post</button>
                </div>

            </div>
        </div>
    </div>
</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    const userId = <?= $_SESSION['user_id'] ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const postId = urlParams.get('id');
        const renderer = new QuestionRenderer('#post-container', null, null);

        try {
            const postInfo = renderer.fetchData(`../controllers/get_postdetails.php?id=${postId}`)
            renderer.renderPostDetail(postInfo, userId);
        } catch (error) {
            console.error('Error loading data:', error);
        }

        // if (postId) {
        //     fetch(`../controllers/get_postdetails.php?id=${postId}`)
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.error) {
        //                 console.error(data.error);
        //             } else {
                        
                        
        //             }

        //             fetch(`../controllers/get_comments.php?id=${postId}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 const commentContainer = document.querySelector('#comment-container');
        //                 if (data.error) {
        //                     console.error(data.error)
        //                 } else {
        //                     data.forEach(comment => {
        //                         const commentElement = document.createElement('div');
        //                         commentElement.classList.add('bg-[#F1F1F1]', 'flex', 'p-4', 'space-x-4', 'rounded-md');
        //                         commentElement.innerHTML = `
        //                             <img src="${comment.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 rounded-full">

        //                             <div>
        //                                 <h2 class="font-medium text-md">${comment.username}</h2>
        //                                 <p class="text-sm">${comment.content}</p>
        //                             </div>
        //                         `;

        //                         commentContainer.appendChild(commentElement);
        //                     })
        //                 }
        //             })
        //         })
        //         .catch(error => {
        //             console.error('Error fetching post details:', error);
        //         });
        // } else {
        //     console.error('Post ID not provided');
        // }
    });
</script>