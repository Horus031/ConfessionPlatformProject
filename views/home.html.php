<main class="flex flex-col overflow-hidden px-2 mt-24 items-end">
    <div class="flex justify-between items-center rounded-xl p-3 bg-linear-160 z-30 from-[#4CAF50] via-[#A5B82C] to-[#FFC107] md:w-3/4 lg:w-5/6 lg:px-8 animate-postSlideIn transition-all">
        <div class="md:w-72 lg:w-96 animate-fadeIn">
            <h1 class="text-2xl text-white font-bold leading-10 lg:leading-15 lg:text-6xl">Welcome to Knowledge Nexus, <?= isset($_SESSION['username']) ? $_SESSION["username"] : 'Users'; ?></h1>
            <button id="addques-btn" class="bg-black text-white font-medium rounded-xl py-1.5 px-8 mt-4 cursor-pointer">Add question</button>
        </div>
        <div class="animate-fadeIn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" class="-m-10 h-44 md:h-72 lg:h-96">
                <!-- Background -->
                <rect width="300" height="300" fill="white" opacity="0" />

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
        </div>
    </div>

    <div id="quest-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:w-3/4 lg:w-5/6 animate-postSlideIn transition-all">



    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/list_question.php')
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('#quest-container');
            if (data.error) {
                container.innerHTML = `<p class="text-red-500">${data.error}</p>`;
            } else {
                data.forEach(question => {
                    const questionElement = document.createElement('div');
                    questionElement.id = `value-${question.post_id}`;
                    questionElement.setAttribute('data-value', `${question.post_id}`);
                    questionElement.classList.add('mt-2', 'border-2', 'p-4', 'rounded-md', 'border-gray-200', 'hover:border-black', 'cursor-pointer');
                    questionElement.innerHTML = `
                    <div class="flex flex-col">
                        <input type="hidden" name="post_id" value="${question.post_id}">
                        <div class="flex justify-between items-center">
                            <span class="w-fit rounded-full text-xs ${question.bg_class} ${question.text_class} px-2 font-medium">${question.module_name}</span>

                            <div class="relative group">
                                <img src="../assets/images/dots.png" class="h-10 hover:bg-gray-300 p-2 rounded-full">

                                <div id="action-popup" class="absolute bg-white rounded-md shadow-[0_4px_12px_-4px] top-12 right-0 w-40 hidden lg:group-hover:block before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent">
                                    <button type="button" id="view-btn" href="" class="flex w-full items-center space-x-4 p-3 hover:bg-gray-200 cursor-pointer">
                                        <span>View Details</span>
                                    </button> 
                                    <button type="button" id="edit-btn" class="flex w-full items-center space-x-4 p-3 ${question.user_id == <?= $_SESSION['user_id']; ?> ? 'block' : 'hidden'}  hover:bg-gray-200 cursor-pointer">
                                        <span>Edit</span>
                                    </button>
                                    <form action="../controllers/deletepost.php" method="post" class="${question.user_id == <?= $_SESSION['user_id']; ?> ? 'block' : 'hidden'} ">
                                        <input type="hidden" name="post_id" value="${question.post_id}">
                                        <input type="submit" value="Delete" class="space-x-4 p-3 text-left cursor-pointer hover:bg-gray-200 text-red-400 w-full">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <h2 class="mt-3 font-semibold text-lg w-56">${question.post_title}</h2>
                        <p class="mt-3 text-xs text-text-light font-medium line-clamp-1">${question.post_content}</p>

                        <div class="mt-3 border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="${question.imageURL ?? ''}" alt="Post image" width="100%" height="100px" class="rounded-md">
                        </div>

                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2">
                                <img loading="lazy" src="${question.avatar ? question.avatar : '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                                <span class="text-xs">${question.username}</span>
                                <span class="text-xs">${new Date(question.created_at).toLocaleString()}</span>
                            </div>
                            <div id="tags-container-${question.post_id}" class="flex items-center space-x-2 text-sm">
                                
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-3">
                            <div class="flex justify-between w-fit border-2 border-text-light rounded-md space-x-2">
                                <button id="likes-btn" class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                                    <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                                    <span>${question.likes}</span>
                                </button>
                                <button id="comment-btn" class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                                    <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                                    <span>${question.comments}</span>
                                </button>
                            </div>

                            <div class="flex items-center space-x-2 ">
                                <button id="save-btn" class="rounded-md hover:bg-gray-300 transition-all">
                                    <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2">
                                </button>
                                <button id="link-btn" class="rounded-md hover:bg-gray-300 transition-all">
                                    <img loading="lazy" src="../assets/images/link.png" alt="" class="h-10 p-2">
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                    questionElement.addEventListener('click', function(e) {
                        let button = e.target.closest('button');
                        let anchor = e.target.closest('a');
                        if (!button) {
                            window.location.href = `../views/main.html.php?page=postdetails&id=${question.post_id}`;
                        }
                        switch (true) {
                            case button.id == "likes-btn":
                                console.log('likes');
                                break;
                            case button.id == "comment-btn":
                                console.log('comment');
                                break;
                            case button.id == "save-btn":
                                console.log('bookmark');
                                break;
                            case button.id == "links-btn":
                                console.log('link-btn');
                                break;
                            case button.id == "view-btn":
                                window.location.href = `../views/main.html.php?page=postdetails&id=${question.post_id}`;
                                break;
                            case button.id == "edit-btn":
                                const postId = questionElement.getAttribute('data-value');

                                sessionStorage.setItem('editPostId', postId);
                                window.location.href = '../views/main.html.php?page=editpost';
                                break;
                        }
                    })

                    container.appendChild(questionElement);
                });

                

                

                fetch('../controllers/get_posttags.php')
                .then(response => response.json())
                .then(tagsData => {
                    if (tagsData.error) {
                        tagContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                    } else {
                        tagsData.forEach(tag => {
                            const tagContainer = document.querySelector(`#tags-container-${tag.post_id}`);
                            if (tagContainer) {
                                const existingTags = tagContainer.querySelectorAll('span');
                                if (existingTags.length === 0) {
                                    const tagElement = document.createElement('span');
                                    tagElement.classList.add('bg-tags', 'p-1', 'rounded-md');
                                    tagElement.textContent = `#${tag.tag_name}`;
                                    tagContainer.appendChild(tagElement);
                                } else {
                                    const additionalTags = tagContainer.querySelector('.additional-tags');
                                    const tagPopup = document.querySelector('#tags-popup');
                                    if (additionalTags) {
                                        const count = parseInt(additionalTags.getAttribute('data-count')) + 1;
                                        const tagSpan = document.querySelector('#tag-count');
                                        additionalTags.setAttribute('data-count', count);
                                        tagSpan.textContent = `+${count}`;


                                        const additionalTagPopup = document.createElement('span');
                                        additionalTagPopup.classList.add('p-2')
                                        additionalTagPopup.textContent = `#${tag.tag_name}`;
                                        tagPopup.appendChild(additionalTagPopup);

                                    } else {
                                        const additionalTagElement = document.createElement('div');

                                        additionalTagElement.classList.add('relative', 'group', 'bg-tags', 'p-1', 'rounded-md', 'additional-tags');
                                        additionalTagElement.setAttribute('data-count', 1);
                                        additionalTagElement.innerHTML = `
                                            <span id="tag-count">+1</span>

                                            <div id="tags-popup" class="absolute space-y-2 bg-tags p-2 rounded-md right-1 top-8 shadow-lg hidden group-hover:block before:absolute before:content-[''] before:bg-black before:-top-2 before:w-6 before:h-3 before:right-0 before:bg-transparent">
                                                <span class="p-2">#${tag.tag_name}</span>
                                            </div>
                                        `;
                                        tagContainer.appendChild(additionalTagElement);
                                    }
                                }
                            }
                        });
                    }
                })
            }
        })
        .catch(error => {
            const container = document.querySelector('#question-container');
            container.innerHTML = `<p class="text-red-500">Error fetching questions: ${error.message}</p>`;
        });


        document.querySelector('#addques-btn').addEventListener('click', function() {
            window.location.href = '../views/main.html.php?page=newpost';
        })
    })
</script>