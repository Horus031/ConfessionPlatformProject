
class QuestionRenderer {
    constructor(containerId, filterId, userId) {
        this.container = document.querySelector(containerId);
        this.filterContainer = document.querySelector(filterId);
        this.userId = userId;
    }

    async fetchData(url, options = {}) {
        try {
            const response = await fetch(url, options);
            const text = await response.text();
            try {
                const data = JSON.parse(text);
                if (data.error) {
                    throw new Error(data.error);
                }
                return data;
            } catch (error) {
                throw new Error(`Invalid JSON response: ${text}`);
            }
        } catch (error) {
            console.error(`Error fetching data from ${url}:`, error);
            throw error;
        }
    }

    renderSavedPosts(posts, userId) {
        if (!this.container) return;
        this.container.innerHTML = '';

        const fragment = document.createDocumentFragment();

        posts.forEach(async post => {
            if (post.user_savedid == userId) {
                const userJoinedTime = new Date(post.created_at);
                const formattedDate = userJoinedTime.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
                const questionElement = document.createElement('div');
                questionElement.id = `ques-${post.post_id}`;
                questionElement.setAttribute('data-value', `${post.post_id}`);
                questionElement.classList.add('font-poppins','mt-2', 'border-2', 'p-4', 'rounded-md', 'border-gray-200', 'hover:border-black', 'cursor-pointer', 'dark:border-gray-700', 'dark:hover:border-gray-500', 'dark:bg-gray-800', 'animate-postScale');
                questionElement.innerHTML = `
                    <div class="flex flex-col">
                        <input type="hidden" name="post_id" value="${post.post_id}">
                        <div class="flex justify-between items-center">
                            <span data-module="${post.module_id}" class="w-fit module-name rounded-full text-xs ${post.bg_class} ${post.text_class} px-2 font-medium">${post.module_name}</span>
                            <div class="relative group rounded-md text-4xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600">
                                <span id="post-actions" class="material-symbols-rounded custom-icon more-icon active:scale-90">
                                    more_horiz
                                </span>
                                <div id="action-popup" class="absolute bg-white rounded-md top-12 shadow-[0px_0px_5px_-1px] right-0 w-40 hidden before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent dark:bg-gray-900 dark:text-gray-400 dark:shadow-none">
                                    <button type="button" id="view-btn" class="flex w-full items-center rounded-md space-x-4 p-3 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                                        <span class="text-lg">View Details</span>
                                    </button> 
                                    
                                </div>
                            </div>
                        </div>
                        <h2 class="question-title mt-3 font-bold text-lg w-56 h-20 dark:text-white">${post.post_title}</h2>
                        <p class="mt-3 text-text-light text-sm dark:text-gray-400 font-medium line-clamp-1">${post.post_content}</p>
                        <div>
                            <div class="mt-3 rounded-md">
                                <img loading="lazy" src="${post.imageURL ?? ''}" alt="Post image" width="100%" height="100px" class="rounded-md lazy-load">
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <div class="flex items-center space-x-2">
                                    <div class="relative group">
                                        <img id="profile-hover" data-value="${post.user_id}" loading="lazy" src="${post.avatar ? post.avatar : '../assets/images/user.png'}" alt="" class="user-${post.user_id} h-10 rounded-full">

                                        <div id="profile-popup" class="absolute bg-white w-66 rounded-md p-2 -top-26 left-0 border-1 border-gray-600 before:content-[''] before:absolute before:w-full before:h-0 before:right-0 before:-bottom-2 before:border-4 before:border-transparent group-hover:block hidden transition-all dark:bg-gray-800 dark:border-gray-400">
                                            <div class="flex items_center space-x-4">
                                                <img loading="lazy" src="${post.avatar ? post.avatar : '../assets/images/user.png'}" class="h-20 rounded-full">
                                                <div>
                                                    <h4 id="post-username" class="text-lg font-medium dark:text-white">${post.username}</h4>
                                                    <div class="text-sm">
                                                        <span class="text-text tagname dark:text-gray-400">@${post.tag_name ?? ''}</span>
                                                        <span class="text-text dark:text-gray-400">•</span>
                                                        <span class="text-text-light dark:text-gray-400">Joined ${formattedDate}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs dark:text-gray-400">${post.username}</span>
                                    <span class="text-xs dark:text-gray-400">${this.timeAgo(post.created_at)}</span>
                                </div>
                                <div id="tags-container-${post.post_id}" class="flex items-center space-x-2 text-sm"></div>
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <div class="flex justify-between w-fit border-1 border-gray-400 dark:border-gray-700 rounded-md">
                                    <button id="likes-btn" class="flex items-center space-x-1 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                        <span class="material-symbols-rounded custom-icon like-img">
                                            thumb_up
                                        </span>
                                        <span class="like-count-${post.post_id} text-lg" data-post-id="${post.post_id}"></span>
                                    </button>
                                    <button id="comment-btn" class="flex items-center space-x-2 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                        <span class="material-symbols-rounded custom-icon">
                                            comment
                                        </span>
                                        <span class="comment-count-${post.post_id} text-lg" data-post-id="${post.post_id}"></span>
                                    </button>
                                </div>
                                <div class="flex items-center space-x-2 ">
                                    <button id="save-btn" class="rounded-md text-4xl p-1 font-light hover:bg-gray-300 dark:text-gray-400 dark:hover:bg-gray-600 transition-all">
                                        <span class="material-symbols-rounded custom-icon saved-img">
                                            bookmark
                                        </span>
                                    </button>
                                    <button id="link-btn" class="rounded-md text-4xl p-1 font-light hover:bg-gray-300 dark:text-gray-400 dark:hover:bg-gray-600 transition-all">
                                        <span class="material-symbols-rounded custom-icon">
                                            link
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                const actionPopup = questionElement.querySelector('#action-popup');
                if (post.user_id == userId) {
                    const editButton = document.createElement('button');
                    editButton.className = `flex w-full items-center rounded-md space-x-4 p-3 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer`;
                    editButton.id = 'edit-btn';
                    editButton.innerHTML = '<span class="text-lg">Edit</span>';

                    const deleteButton = document.createElement('form');
                    deleteButton.action = '../controllers/deletepost.php';
                    deleteButton.method = 'post';
                    deleteButton.innerHTML = `
                        <input type="hidden" name="post_id" value="${post.post_id}">
                        <input type="submit" value="Delete" class="space-x-4 p-3 text-left rounded-md text-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 text-red-400 w-full">
                    `;

                    actionPopup.appendChild(editButton);
                    actionPopup.appendChild(deleteButton);
                }

                fragment.appendChild(questionElement);


                try {
                    const likeCount = await this.fetchData('../controllers/get_likecount.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    })
    
                    const commentCount = await this.fetchData('../controllers/get_commentcount.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    })
    
                    questionElement.querySelector(`.like-count-${post.post_id}`).textContent = likeCount.like_count;
                    questionElement.querySelector(`.comment-count-${post.post_id}`).textContent = commentCount.comment_count;



                    const postTag = await this.fetchData(`../controllers/get_posttags.php`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    });
                    
                    const tagContainer = questionElement.querySelector(`#tags-container-${post.post_id}`);
    
                    postTag.forEach(tag => {
                        if (tagContainer) {
                            const existingTags = tagContainer.querySelectorAll('span');
                            if (existingTags.length === 0) {
                                const tagElement = document.createElement('span');
                                tagElement.classList.add('bg-gray-300', 'p-1','text-black' , 'rounded-md', 'dark:bg-transparent', 'dark:text-gray-400', 'dark:border-1', 'dark:border-1' ,'dark:border-gray-500');
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
                                    additionalTagPopup.classList.add('p-2');
                                    additionalTagPopup.textContent = `#${tag.tag_name}`;
                                    tagPopup.appendChild(additionalTagPopup);
            
                                } else {
                                    const additionalTagElement = document.createElement('div');
            
                                    additionalTagElement.classList.add('relative', 'group', 'bg-tags', 'p-1', 'rounded-md', 'additional-tags', 'dark:border-gray-800');
                                    additionalTagElement.setAttribute('data-count', 1);
                                    additionalTagElement.innerHTML = `
                                        <span id="tag-count">+1</span>
            
                                        <div id="tags-popup" class="absolute space-y-2 bg-tags  p-2 rounded-md right-1 top-8 shadow-lg hidden group-hover:block before:absolute before:content-[''] before:-top-2 before:w-6 before:h-3 before:right-0 before:bg-transparent dark:border-1 dark:border-gray-800">
                                            <span class="p-2">#${tag.tag_name}</span>
                                        </div>
                                    `;
                                    tagContainer.appendChild(additionalTagElement);
                                }
                            }
                        }
                    });
    
                    const data = await this.fetchData('../controllers/check_likes.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    });
    
                    const savedData = await this.fetchData('../controllers/check_savedposts.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    });
    
                    if (data.error) {
                        console.log(data.error);
                    } else {
                        if (data.status == "yes") {
                            questionElement.querySelector('.like-img').classList.add('filled-icon');
                        } else {
                            questionElement.querySelector('.like-img').classList.remove('filled-icon');
                        }
                    }
    
                    if (savedData.error) {
                        console.log(savedData.error);
                    } else {
                        if (savedData.status == 'yes') {
                            questionElement.querySelector('.saved-img').classList.add('filled-icon');
                        } else {
                            questionElement.querySelector('.saved-img').classList.add('filled-icon');
                        }
                    }
    
                } catch (error) {
                    console.log(error);
                }

                try {
                    const data = await this.fetchData('../controllers/check_likes.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    })

                    const savedData = await this.fetchData('../controllers/check_savedposts.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    })

                    if (data.error) {
                        console.log(error);
                    } else {
                        if (data.status == "yes") {

                        } else {

                        }
                    }

                    if (savedData.error) {
                        console.log(error);
                    } else {
                        if (savedData.status == 'yes') {

                        } else {

                        }
                    }

                } catch (error) {
                    console.log(error);
                }
            }
        });

        this.container.appendChild(fragment);
        
    }

    timeAgo(date) {
        const now = new Date();
        const seconds = Math.floor((now - new Date(date)) / 1000);
    
        if (seconds < 5) {
            return "Just posted";
        }
    
        let interval = Math.floor(seconds / 31536000);
        if (interval >= 1) {
            return interval === 1 ? "1 year ago" : interval + " years ago";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) {
            return interval === 1 ? "1 month ago" : interval + " months ago";
        }
        interval = Math.floor(seconds / 86400);
        if (interval >= 1) {
            return interval === 1 ? "1 day ago" : interval + " days ago";
        }
        interval = Math.floor(seconds / 3600);
        if (interval >= 1) {
            return interval === 1 ? "1 hour ago" : interval + " hours ago";
        }
        interval = Math.floor(seconds / 60);
        if (interval >= 1) {
            return interval === 1 ? "1 minute ago" : interval + " minutes ago";
        }
        return Math.floor(seconds) + " seconds ago";
    }

    renderQuestions(questions, userId) {
        if (!this.container) return;
        this.container.innerHTML = '';

        if (!questions || questions.length === 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
            noResultsMessage.textContent = 'No results found.';
            this.container.appendChild(noResultsMessage);
            return;
        }

        const fragment = document.createDocumentFragment();

        questions.forEach(async question => {
            const questionElement = document.createElement('div');
            const userJoinedTime = new Date(question.created_at);
            const formattedDate = userJoinedTime.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
            questionElement.id = `ques-${question.post_id}`;
            questionElement.setAttribute('data-value', `${question.post_id}`);
            questionElement.classList.add('mt-2', 'border-1', 'p-4', 'h-fit' , 'rounded-md', 'border-gray-200', 'hover:border-black', 'cursor-pointer', 'dark:border-gray-700', 'dark:hover:border-gray-500', 'dark:bg-gray-800');
            questionElement.innerHTML = `
                <div class="flex flex-col">
                    <input type="hidden" name="post_id" value="${question.post_id}">
                    <div class="flex justify-between items-center">
                        <span data-module="${question.module_id}" class="font-semibold w-fit module-name rounded-full text-xs ${question.bg_class} ${question.text_class} px-2">${question.module_name}</span>
                        <div class="relative group rounded-md text-4xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600">
                            <span id="post-actions" class="material-symbols-rounded custom-icon more-icon active:scale-90">
                                more_horiz
                            </span>
                            <div id="action-popup" class="absolute bg-white rounded-md top-12 shadow-[0px_0px_5px_-1px] right-0 w-40 hidden before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent dark:bg-gray-900 dark:text-gray-400 dark:shadow-none">
                                <button type="button" id="view-btn" class="flex w-full items-center rounded-md space-x-4 p-3 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                                    <span class="text-lg">View Details</span>
                                </button> 
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-3 font-bold text-lg w-56 h-16 line-clamp-2 dark:text-white">${question.post_title}</h2>
                    <p class="font-roboto mt-3 text-md text-text font-normal line-clamp-1 dark:text-gray-400">${question.post_content}</p>
                    <div>
                        <div class="mt-3 rounded-md">
                            <img id="post-image" loading="lazy" src="${question.imageURL ?? ''}" alt="Post image" width="100%" height="100px" class="rounded-md lazy-load">
                        </div>
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2 font-normal md:space-y-2 md:flex-wrap 2xl:flex-nowrap 2xl:space-y-0">
                                <div class="flex items-center space-x-2">
                                    <div class="relative group">
                                        <img id="profile-hover" data-value="${question.user_id}" loading="lazy" src="${question.avatar ? question.avatar : '../assets/images/user.png'}" alt="" class="user-${question.user_id} h-10 rounded-full">

                                        <div id="profile-popup" class="absolute bg-white w-66 rounded-md p-2 -top-26 left-0 border-1 border-gray-600 before:content-[''] before:absolute before:w-full before:h-0 before:right-0 before:-bottom-2 before:border-4 before:border-transparent group-hover:block hidden transition-all dark:bg-gray-800 dark:border-gray-400">
                                            <div class="flex items_center space-x-4">
                                                <img loading="lazy" src="${question.avatar ? question.avatar : '../assets/images/user.png'}" class="h-20 rounded-full">
                                                <div>
                                                    <h4 id="post-username" class="text-lg font-medium dark:text-white">${question.username}</h4>
                                                    <div class="text-sm">
                                                        <span class="text-text tagname dark:text-gray-400">@${question.tag_name ?? ''}</span>
                                                        <span class="text-text dark:text-gray-400">•</span>
                                                        <span class="text-text-light dark:text-gray-400">Joined ${formattedDate}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs dark:text-gray-400">${question.username}</span>
                                </div>
                                <span class="text-xs dark:text-gray-400">${this.timeAgo(question.created_at)}</span>
                            </div>
                            <div id="tags-container-${question.post_id}" class="flex items-center capitalize space-x-2 text-sm"></div>
                        </div>
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex justify-between w-fit border-1 border-gray-400 dark:border-gray-700 rounded-md">
                                <button id="likes-btn" class="flex items-center space-x-1 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                    <span class="material-symbols-rounded custom-icon like-img">
                                        thumb_up
                                    </span>
                                    <span class="like-count-${question.post_id} text-lg" data-post-id="${question.post_id}">$</span>
                                </button>
                                <button id="comment-btn" class="flex items-center space-x-2 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                    <span class="material-symbols-rounded custom-icon ">
                                        comment
                                    </span>
                                    <span class="comment-count-${question.post_id} text-lg" data-post-id="${question.post_id}">$</span>
                                </button>
                            </div>
                            <div class="flex items-center space-x-2 ">
                                <button id="save-btn" class="rounded-md text-4xl p-1 font-light hover:bg-gray-300 dark:text-gray-400 dark:hover:bg-gray-600 transition-all">
                                    <span class="material-symbols-rounded custom-icon saved-img">
                                        bookmark
                                    </span>
                                </button>
                                <button id="link-btn" class="rounded-md text-4xl p-1 font-light hover:bg-gray-300 dark:text-gray-400 dark:hover:bg-gray-600 transition-all">
                                    <span class="material-symbols-rounded custom-icon">
                                        link
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const actionPopup = questionElement.querySelector('#action-popup');
            if (question.user_id == userId) {
                const editButton = document.createElement('button');
                editButton.className = `flex w-full items-center rounded-md space-x-4 p-3 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer`;
                editButton.id = 'edit-btn';
                editButton.innerHTML = '<span class="text-lg">Edit</span>';

                const deleteButton = document.createElement('form');
                deleteButton.action = '../controllers/deletepost.php';
                deleteButton.method = 'post';
                deleteButton.innerHTML = `
                    <input type="hidden" name="post_id" value="${question.post_id}">
                    <input type="submit" value="Delete" class="space-x-4 p-3 text-left rounded-md text-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 text-red-400 w-full">
                `;

                actionPopup.appendChild(editButton);
                actionPopup.appendChild(deleteButton);
            }

            fragment.appendChild(questionElement);

            const postImage = questionElement.querySelector('#post-image')
            if (postImage.src.match('localhost')) {
                postImage.classList.add('hidden')
            }

            try {
                const likeCount = await this.fetchData('../controllers/get_likecount.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ post_id: question.post_id })
                })

                const commentCount = await this.fetchData('../controllers/get_commentcount.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ post_id: question.post_id })
                })

                questionElement.querySelector(`.like-count-${question.post_id}`).textContent = likeCount.like_count;
                questionElement.querySelector(`.comment-count-${question.post_id}`).textContent = commentCount.comment_count;



                const postTag = await this.fetchData(`../controllers/get_posttags.php`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ post_id: question.post_id })
                });
                
                const tagContainer = questionElement.querySelector(`#tags-container-${question.post_id}`);

                postTag.forEach(tag => {
                    if (tagContainer) {
                        const existingTags = tagContainer.querySelectorAll('span');
                        if (existingTags.length === 0) {
                            const tagElement = document.createElement('span');
                            tagElement.classList.add('tagname', 'bg-gray-300', 'p-1','text-black' , 'rounded-md', 'dark:bg-transparent', 'dark:text-gray-400', 'dark:border-1', 'dark:border-1' ,'dark:border-gray-500');
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
                                additionalTagPopup.classList.add('tagname', 'p-2');
                                additionalTagPopup.textContent = `#${tag.tag_name}`;
                                tagPopup.appendChild(additionalTagPopup);
        
                            } else {
                                const additionalTagElement = document.createElement('div');
        
                                additionalTagElement.classList.add('relative', 'group', 'bg-gray-300', 'p-1', 'rounded-md', 'additional-tags', 'dark:bg-transparent' , 'dark:border-1','dark:text-gray-400', 'dark:border-gray-400');
                                additionalTagElement.setAttribute('data-count', 1);
                                additionalTagElement.innerHTML = `
                                    <span id="tag-count">+1</span>
        
                                    <div id="tags-popup" class="absolute space-y-2 bg-gray-300  p-2 rounded-md right-1 top-8 shadow-lg hidden group-hover:block before:absolute before:content-[''] before:-top-2 before:w-6 before:h-3 before:right-0 before:bg-transparent dark:bg-gray-900 dark:border-1 dark:border-gray-600">
                                        <span class="tagname p-2 dark:text-gray-400">#${tag.tag_name}</span>
                                    </div>
                                `;
                                tagContainer.appendChild(additionalTagElement);
                            }
                        }
                    }
                });

                const data = await this.fetchData('../controllers/check_likes.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ post_id: question.post_id })
                });

                const savedData = await this.fetchData('../controllers/check_savedposts.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ post_id: question.post_id })
                });

                if (data.error) {
                    console.log(data.error);
                } else {
                    if (data.status == "yes") {
                        questionElement.querySelector('.like-img').classList.add('filled-icon');
                    } else {
                        questionElement.querySelector('.like-img').classList.remove('filled-icon');
                    }
                }

                if (savedData.error) {
                    console.log(savedData.error);
                } else {
                    if (savedData.status == 'yes') {
                        questionElement.querySelector('.saved-img').classList.add('filled-icon');
                    } else {
                        questionElement.querySelector('.saved-img').classList.remove('filled-icon');
                    }
                }

            } catch (error) {
                console.log(error);
            }
        });

        this.container.appendChild(fragment);
    }

    renderTagsForPost(tags) {
        tags.forEach(tag => {
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
                        additionalTagPopup.classList.add('p-2');
                        additionalTagPopup.textContent = `#${tag.tag_name}`;
                        tagPopup.appendChild(additionalTagPopup);
                    } else {
                        const additionalTagElement = document.createElement('div');
                        additionalTagElement.classList.add('relative', 'group', 'bg-tags', 'p-1', 'rounded-md', 'additional-tags');
                        additionalTagElement.setAttribute('data-count', 1);
                        additionalTagElement.innerHTML = `
                            <span id="tag-count">+1</span>
                            <div id="tags-popup" class="absolute space-y-2 bg-tags p-2 rounded-md right-1 top-8 shadow-lg hidden group-hover:block before:absolute before:content-[''] before:-top-2 before:w-6 before:h-3 before:right-0 before:bg-transparent">
                                <span class="p-2">#${tag.tag_name}</span>
                            </div>
                        `;
                        tagContainer.appendChild(additionalTagElement);
                    }
                }
            } else {
                console.warn(`Tag container not found for post ID: ${tag.post_id}`);
            }
        });
    }

    renderTags(tags) {
        if (!this.container) return;
        this.container.innerHTML = ''; // Clear previous tags

        const fragment = document.createDocumentFragment();

        tags.forEach(tag => {
            const tagElement = document.createElement('div');
            tagElement.id = `tag-${tag.tag_id}`;
            tagElement.classList.add('border', 'border-gray-300', 'dark:border-gray-600' ,'rounded-md', 'p-4', 'tag-element', 'animate-postSlideIn', 'hover:border-gray-600', 'dark:hover:border-gray-400', 'cursor-pointer');
            tagElement.innerHTML = `
                <input id="tag-value" type="hidden" value="${tag.tag_type}">
                <span id="tagname-${tag.tag_id}" class="w-fit rounded-full bg-gray-300 px-2 text-sm font-medium">#${tag.tag_name}</span>
                <p class="text-sm mt-4 text-text-light font-normal">${tag.tag_description}</p>
            `;

            fragment.appendChild(tagElement);
        });

        this.container.appendChild(fragment);
    }

    renderTagsWithType() {
        const selectTagType = document.querySelector('#select-tag-type');
        const buttonContainer = document.querySelector('#button-container');
        const tagList = document.querySelector('#tag-list');
        const tagInput = document.querySelector('#tag-input');
        
        selectTagType.addEventListener('change', async () => {
            let selectedValue = selectTagType.value;
            
            while (tagList.firstChild) {
                tagList.removeChild(tagList.firstChild);
            }

            try {
                const data = await this.fetchData('../controllers/tags_withtype.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ type: selectedValue })
                });

                if (data.error) {
                    tagList.innerHTML = `<option>${data.error}</option>`;
                } else {
                    if (selectedValue == '') {
                        tagList.classList.add('hidden');
                        buttonContainer.classList.add('hidden');
                        tagInput.classList.add('hidden');
                    } else {
                        tagList.classList.remove('hidden');
                        buttonContainer.classList.remove('hidden');
                        tagInput.classList.remove('hidden');
                        data.forEach(tag => {
                            const tagElement = document.createElement('option');
                            tagElement.value = `${tag.tag_name}`;
                            tagElement.textContent = `${tag.tag_name}`;
                            tagList.appendChild(tagElement);
                        });
                    }
                }
            } catch (error) {
                console.error('Error loading tags:', error);
            }
        });

        buttonContainer.addEventListener('click', function(e) {
            if (e.target.closest('button[id="add-btn"]')) {
                const selectedTag = tagList.value;
                const currentTags = tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag !== '');

                if (currentTags.includes(selectedTag)) {
                    console.log('You cannot duplicate the tag!');
                } else {
                    currentTags.push(selectedTag);
                    tagInput.value = currentTags.join(', ');
                }

            } else if (e.target.closest('button[id="remove-btn"]')) {
                const selectedTag = tagList.value;
                let currentTags = tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag !== '');

                currentTags = currentTags.filter(tag => tag !== selectedTag);
                tagInput.value = currentTags.join(', ');
            }
        });

        document.querySelector('#cancel-btn').addEventListener('click', function() {
            window.history.back();
        })
    }

    renderModules(modules) {
        if (!this.filterContainer) return;

        modules.forEach(module => {
            const option = document.createElement('option');
            option.classList.add('dark:bg-gray-800')
            option.value = `${module.module_id}`;
            option.textContent = `${module.module_name}`;
            this.filterContainer.appendChild(option);
        });
    }

    async renderUserProfile(data) {
        const _this = this;
        const profileContainer = document.querySelector('#info-container');
        const bioContainer = document.querySelector('#bio-container');
        const profileAction = document.querySelector('#profile-actions');
        if (data.error) {
            profileContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
        } else {
            const username = document.querySelector('#username');
            username.classList.add('dark:text-white');
            username.textContent = data.fullname;
            document.querySelector('#user-img').src = data.avatar ?? '../assets/images/user.png';

            profileAction.setAttribute('data-value', data.user_id);
            profileAction.setAttribute('data-tagname', data.tag_name);
            const profileElements = document.createElement('div');
            profileElements.classList.add('flex', 'flex-col', 'space-y-2');

            const createdAt = new Date(data.created_at);
            const formattedDate = createdAt.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });

            profileElements.innerHTML = `
                <div>
                    <span class="text-text font-medium dark:text-white">@${data.tag_name ?? ''}</span>
                    <span class="text-text">•</span>
                    <span class="text-text-light font-medium dark:text-gray-400">Joined ${formattedDate}</span>
                </div>
                <div class="flex space-x-2">
                    <div id="follower-btn" class="cursor-pointer active:scale-90">
                        <span id="follower-count" class="dark:text-white">0</span>
                        <span class="text-text dark:text-gray-400">Followers</span>
                    </div>
                    <div id="following-btn" class="cursor-pointer active:scale-90">
                        <span id="following-count" class="dark:text-white">0</span>
                        <span class="text-text dark:text-gray-400">Following</span>
                    </div>
                </div>
                <div>
                    <span id="view-count" class="dark:text-white">0</span>
                    <span class="text-text dark:text-gray-400">Views</span>
                    <span id="like-count" class="dark:text-white">0</span>
                    <span class="text-text dark:text-gray-400">Likes</span>
                </div>
            `;

            try {
                setTimeout(async function() {
                    const followCounts = await _this.fetchData(`../controllers/get_follow_counts.php?user_id=${data.user_id}`);
                    document.getElementById('follower-count').textContent = followCounts.follower_count || '0';
                    document.getElementById('following-count').textContent = followCounts.following_count || '0';

                    const userPostCounts = await _this.fetchData(`../controllers/get_user_counts.php?user_id=${data.user_id}`);
                    document.getElementById('view-count').textContent = userPostCounts.total_view_count || '0';
                    document.getElementById('like-count').textContent = userPostCounts.total_like_count || '0';
                }, 100)
            } catch (error) {
                console.error('Error loading follow and post counts:', error);
            }

            const socialContainer = document.querySelector('#social-container');

            data.socialLinks.forEach(link => {
                const socialElement = socialContainer.querySelector(`a[id^="${link.platform}"]`);
                if (link.url && link.platform) {
                    socialElement.href = link.url;
                    socialElement.target = '_blank';
                    socialElement.classList.add('border-1', 'border-secondary', 'rounded-xl', 'px-4', 'py-1', 'font-semibold', 'dark:border-gray-600', 'dark:text-gray-400');
                    socialElement.textContent = `@${link.platform}`;
                    socialContainer.appendChild(socialElement);
                } else {
                    socialContainer.removeChild(socialElement);
                }
            });

            const bioContext = document.createElement('span');
            bioContext.classList.add('font-semibold', 'text-text-light');
            bioContext.textContent = data.bio ?? '';

            bioContainer.appendChild(bioContext);
            profileElements.appendChild(socialContainer);
            profileContainer.appendChild(profileElements);
        }
    }

    renderUserPosts(posts, userId) {
        const mypostContainer = document.querySelector('#mypost-container');

        let hasPosts = false;
        if (posts.error) {
            mypostContainer.innerHTML = `<p class="text-red-500">${posts.error}</p>`;
        } else {
            posts.forEach(async myPost => {
                if (myPost.user_id == userId) {
                    hasPosts = true;
                    const mypostElements = document.createElement('div');
                    mypostElements.classList.add('flex', 'items-center', 'justify-between', 'border-2', 'border-secondary', 'mt-2', 'p-4', 'rounded-lg', 'w-full', 'hover:border-black', 'cursor-pointer', 'animate-slideRight', 'transition-all', 'dark:border-gray-700', 'dark:hover:border-gray-500', 'dark:bg-gray-800');
                    mypostElements.innerHTML = `
                        <div class="space-y-2 w-1/2">
                            <h2 class="font-semibold text-xl line-clamp-2 dark:text-white">${myPost.post_title}</h2>
                            <p class="text-sm text-text-light font-medium line-clamp-3 break-words">${myPost.post_content}</p>
                            <div class="flex justify-between w-fit border-1 border-gray-400 dark:border-gray-700 rounded-md">
                                <button id="likes-btn" class="flex items-center space-x-1 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                    <span class="material-symbols-rounded custom-icon like-img">
                                        thumb_up
                                    </span>
                                    <span class="like-count-${myPost.post_id} text-lg" data-post-id="${myPost.post_id}"></span>
                                </button>
                                <button id="comment-btn" class="flex items-center space-x-2 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                    <span class="material-symbols-rounded custom-icon">
                                        comment
                                    </span>
                                    <span class="comment-count-${myPost.post_id} text-lg" data-post-id="${myPost.post_id}"></span>
                                </button>
                            </div>
                        </div>
                        <div id="image-container" class="border-2 border-gray-200 rounded-md">
                            <img id="post-image" loading="lazy" src="${myPost.imageURL}" alt="Post image" class="rounded-md h-30 w-30 md:w-60 md:h-40 2xl:h-50">
                        </div>
                    `;

                    const likeCount = await this.fetchData('../controllers/get_likecount.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: myPost.post_id })
                    })
    
                    const commentCount = await this.fetchData('../controllers/get_commentcount.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: myPost.post_id })
                    })
    
                    mypostElements.querySelector(`.like-count-${myPost.post_id}`).textContent = likeCount.like_count;
                    mypostElements.querySelector(`.comment-count-${myPost.post_id}`).textContent = commentCount.comment_count;

                    const postImage = mypostElements.querySelector('#post-image');
                    if (postImage.src.match('null')) {
                        const imageContainer = mypostElements.querySelector('#image-container');
                        mypostElements.removeChild(imageContainer)
                    }

                    const data = await this.fetchData('../controllers/check_likes.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: myPost.post_id })
                    });
    
                    if (data.error) {
                        console.log(data.error);
                    } else {
                        if (data.status == "yes") {
                            mypostElements.querySelector('.like-img').classList.add('filled-icon');
                        } else {
                            mypostElements.querySelector('.like-img').classList.remove('filled-icon');
                        }
                    }



                    mypostElements.addEventListener('click', function() {
                        window.location.href = `../views/main.html.php?page=postdetails&id=${myPost.post_id}`;
                    });

                    mypostContainer.appendChild(mypostElements);
                }
            });

            if (!hasPosts) {
                mypostContainer.innerHTML = ``;
            }
        }
    }

    renderEditUser(userInfo) {
        const imageInput = document.querySelector('#uploadimg-container');
        const imageChildren = document.querySelector('#img-child');

        const accountInput = document.querySelector('#accountinfo-container');
        const bioInput = document.querySelector('#bio-container');
        const socialInput = document.querySelector('#social-container');
        

        const imageElements = document.createElement('img');
        imageElements.id = 'image';
        imageElements.classList.add('h-20', 'rounded-full');
        imageElements.src = userInfo.avatar ?? '../assets/images/user.png';
        imageInput.insertBefore(imageElements, imageChildren);

        accountInput.innerHTML = `
            <div class="relative flex items-center text-3xl font-light dark:text-gray-400 2xl:w-1/3">
                <span class="material-symbols-rounded custom-icon absolute top-1/5 left-4">
                    badge
                </span>
                <input type="text" name="firstnameValue" id="" class="border-1 border-text rounded-lg text-lg font-normal px-4 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your firstname" value="${userInfo.first_name}">
            </div>
            <div class="relative flex items-center text-3xl font-light dark:text-gray-400 2xl:w-1/3">
                <span class="material-symbols-rounded custom-icon absolute top-1/5 left-4">
                    badge
                </span>
                <input type="text" name="lastnameValue" id="" class="border-1 border-text rounded-lg text-lg font-normal px-4 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your lastname" value="${userInfo.last_name}">
            </div>
            <div class="relative flex items-center text-3xl font-light dark:text-gray-400 2xl:w-1/3">
                <span class="material-symbols-rounded custom-icon absolute top-1/5 left-4">
                    alternate_email
                </span>
                <input type="text" name="tagnameValue" id="" class="border-1 border-text rounded-lg text-lg font-normal px-4 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your tagname" value="${userInfo.tag_name ?? ''}">
            </div>
            <div class="relative flex items-center text-3xl font-light dark:text-gray-400 2xl:w-1/3">
                <span class="material-symbols-rounded custom-icon absolute top-1/5 left-4">
                    mail
                </span>
                <input type="text" name="emailValue" id="" class="border-1 border-text rounded-lg text-lg font-normal px-4 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your email" value="${userInfo.email ?? ''}">
            </div>
        `;

        const bioElement = document.createElement('textarea');
        bioElement.name = 'bioValue';
        bioElement.placeholder = 'Your bio...';
        bioElement.cols = '40';
        bioElement.rows = '8';
        bioElement.classList.add('border-1', 'border-text', 'p-2', 'rounded-lg', 'dark:border-gray-600', 'dark:text-gray-400');
        bioElement.value = `${userInfo.bio ?? ''}`;

        bioInput.appendChild(bioElement);


        userInfo.socialLinks.forEach(link => {
            socialInput.querySelector(`input[id="${link.platform}"]`).value = `${link.url ?? ''}`;
        })
    }

    async renderPostDetail(post, userId) {
        document.querySelector('#postdetail-container').setAttribute('data-value', `${post.post_id}`);
        document.querySelector('#post_id').value = post.post_id;
        document.querySelector('#module-name').textContent = post.module_name;
        document.querySelector('#module-name').className = `w-fit rounded-full text-xs px-2 font-medium ${post.bg_class} ${post.text_class}`;
        document.querySelector('#post-title').textContent = post.post_title;
        document.querySelector('#user-avatar').src = post.avatar ?? '../assets/images/user.png';
        document.querySelector('#user-avatar').setAttribute('data-value', post.user_id);
        document.querySelector('#user-avatar').className = (`user-${post.user_id} h-10 rounded-full md:h-14 2xl:h-16`);
        document.querySelector('#username').textContent = post.username;
        document.querySelector('#created-at').textContent = this.timeAgo(post.created_at);
        document.querySelector('#post-content').textContent = post.post_content;
        document.querySelector('#post-image').src = post.imageURL ?? '';
        document.querySelector('.comment-count').textContent = `(${post.comments})`;
        document.querySelector('.like-count').textContent = `${post.likes}`;
        document.querySelector('.like-count').className = `like-count-${post.post_id} text-lg font-normal`
        document.querySelector('#comment-container').setAttribute('data-post-id', `${post.post_id}`);
        document.querySelector('#comment-container').id = `comment-container-${post.post_id}`;
        document.querySelector('#post-form').setAttribute('data-post-id', `${post.post_id}`);

        const usertagContainer = document.querySelector('#usertags');
        const tagContainer = document.createElement('div');
        tagContainer.classList.add('flex', 'items-center', 'space-x-2', 'text-sm');
        tagContainer.id = `tags-container-${post.post_id}`;

        const postImage = document.querySelector('#post-image')
        if (postImage.src.match('localhost')) {
            postImage.classList.add('hidden')
        }

        usertagContainer.appendChild(tagContainer);

        


        const moduleContainer = document.querySelector('#module-container');
        const selectElement = document.createElement('div');
        selectElement.classList.add('relative', 'group');
        selectElement.innerHTML = `
            <img src="../assets/images/dots.png" class="h-10 ${post.user_id == userId ? 'block' : 'hidden'} hover:bg-gray-300 p-2 rounded-full">

            <div class="absolute bg-white rounded-md shadow-[0_4px_12px_-4px] top-12 right-0 w-40 z-10 hidden lg:group-hover:block before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent">
                <button type="button" id="edit-btn"  class="flex items-center w-full space-x-4 p-3 hover:bg-gray-200 cursor-pointer">
                    <span>Edit</span>
                </button>
                <form action="../controllers/deletepost.php" method="post" class="${post.user_id == userId ? 'block' : 'hidden'} ">
                    <input type="hidden" name="post_id" value="${post.post_id}">
                    <input type="submit" value="Delete" class="space-x-4 p-3 text-left cursor-pointer hover:bg-gray-200 text-red-400 w-full">
                </form>
            </div>
        
        `;
        
        moduleContainer.appendChild(selectElement);

        try {
            const data = await this.fetchData('../controllers/check_likes.php', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: post.post_id })
            })

            const savedData = await this.fetchData('../controllers/check_savedposts.php', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: post.post_id })
            });

            if (data.error) {
                console.log(error);
            } else {
                if (data.status == "yes") {
                    document.querySelector('.like-img').classList.add('filled-icon');
                } else {
                    document.querySelector('.like-img').classList.remove('filled-icon');
                }
            }

            if (savedData.error) {
                console.log(savedData.error);
            } else {
                if (savedData.status == 'yes') {
                    document.querySelector('.saved-img').classList.add('filled-icon');
                } else {
                    document.querySelector('.saved-img').classList.remove('filled-icon');
                }
            }
        } catch (error) {
            console.log(error);
        }
        
        if (Array.isArray(post.tags)) {
            post['tags'].forEach(tag => {
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
                            additionalTagPopup.textContent = `#${tag.tag_name}`
                            tagPopup.appendChild(additionalTagPopup);
    
                        } else {
                            const additionalTagElement = document.createElement('div');
    
                            additionalTagElement.classList.add('relative', 'group', 'bg-tags', 'p-1', 'rounded-md', 'additional-tags');
                            additionalTagElement.setAttribute('data-count', 1);
                            additionalTagElement.innerHTML = `
                                <span id="tag-count">+1</span>
    
                                <div id="tags-popup" class="absolute space-y-2 bg-tags p-2 rounded-md right-1 top-8 shadow-lg hidden group-hover:block before:absolute before:content-[''] before:-top-2 before:w-6 before:h-3 before:right-0 before:bg-transparent">
                                    <span class="p-2">#${tag.tag_name}</span>
                                </div>
                            `;
                            tagContainer.appendChild(additionalTagElement);
                        }
                    }
                }
            });
        }
    }

    renderEditPosts(post, postId) {
        document.querySelector('#post-value').value = `${postId}`
        document.querySelector('#title').value = `${post.post_title}`;
        document.querySelector('#content').value = `${post.post_content}`;
        document.querySelector('#file-name').textContent = `${post.imageURL}`;
        setTimeout(function() {
            document.querySelector('#modules').value = `${post.module_id}`;
        }, 0);

        const tagNames = document.querySelector('#tag-input');
        let selectedTag = [];
        post['tags'].forEach(tagName => {
            selectedTag.push(`${tagName.tag_name}`);                    
        })
        tagNames.value = selectedTag.join(', ');
    }

    renderAllUsers(userList, userId) {
        if (!this.container) return;
        this.container.innerHTML = '';

        const fragment = document.createDocumentFragment();

        

        userList.forEach(user => {
            if (user.user_id !== userId) {
                const userElement = document.createElement('div');
                userElement.id = `user-${user.user_id}`
                userElement.classList.add('flex', 'space-x-4', 'items-center', 'p-4', 'rounded-lg', 'hover:bg-gray-200', 'dark:hover:bg-gray-800', 'cursor-pointer', 'animate-postSlideIn');
                userElement.innerHTML = `
                    <img src="${user.avatar ?? '../assets/images/user.png'}" alt="" class="h-13 lg:h-28 rounded-full">

                    <div>
                        <h2 class="user-title text-lg text-text font-semibold lg:text-2xl dark:text-gray-400">${user.fullname}</h2>
                        <h3 id="user-tagname${user.user_id}" class="text-sm text-text-light font-medium lg:text-lg dark:text-gray-500">${user.tag_name ?? ''}</h3>
                        <h4 class="text-sm text-[#2691BF] font-medium lg:text-lg">${user.bio ?? ''}</h4>
                    </div>
                `;

                fragment.appendChild(userElement);
            }

        })

        this.container.appendChild(fragment);

    }

    renderReadingHistory(history) {
        if (!this.container) return;
        this.container.innerHTML = '';

        const groupedHistory = this.groupByDate(history);
        const sortedDates = Object.keys(groupedHistory).sort((a, b) => new Date(b) - new Date(a));

        sortedDates.forEach(date => {
            const historyElement = document.createElement('div');
            historyElement.id = `elements-${date.toLowerCase()}`;
            const posts = groupedHistory[date];
            const dateElement = document.createElement('h2');
            dateElement.classList.add('date-title', 'lg:text-3xl', 'animate-postSlideIn');
            dateElement.textContent = date;
            historyElement.appendChild(dateElement);

            const postIds = new Set();

            posts.forEach(async post => {
                if (!postIds.has(post.post_id)) {
                    postIds.add(post.post_id);

                    const postElement = document.createElement('div');
                    postElement.classList.add('history-element','flex', 'space-x-4', 'p-2', 'hover:bg-gray-200', 'dark:hover:bg-gray-700', 'cursor-pointer', 'animate-slideRight');
                    postElement.setAttribute('data-value', post.post_id);
                    postElement.innerHTML = `
                        <div class="relative flex items-center pl-4">
                            <img src="${post.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 absolute top-1/4 -left-2 border-1 border-black rounded-full lg:h-20 2xl:h-16">
                            <img src="${post.imageURL}" alt="" class="history-images rounded-md w-40 h-20 lg:w-80 lg:h-40 2xl:w-60">
                        </div>
                        <div>
                            <h2 class="history-title line-clamp-3 leading-5 text-text lg:text-3xl lg:leading-8 dark:text-white">${post.post_title}</h2>
                            <div class="mt-2 flex items-center space-x-2 text-3xl text-text font-light dark:text-white">
                                <span class="material-symbols-rounded custom-icon">thumb_up</span>
                                <span class="like-count-${post.post_id} text-lg"></span>
                            </div>
                        </div>
                    `;

                    const postImage = postElement.querySelector('img[class^="history-images"]');
                    if (postImage.src.match('localhost')) {
                        postImage.classList.add('invisible')
                    }

                    const likeCount = await this.fetchData('../controllers/get_likecount.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ post_id: post.post_id })
                    })
    
                    postElement.querySelector(`.like-count-${post.post_id}`).textContent = likeCount.like_count;


                    postElement.addEventListener('click', function() {
                        window.location.href = `../views/main.html.php?page=postdetails&id=${post.post_id}`;
                    })


                    historyElement.appendChild(postElement);
                }
            });

            this.container.appendChild(historyElement);
        });
    }

    async renderTopTags(container) {

        if (!container || container.length == 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
            noResultsMessage.textContent = 'There is no analysis data';
            this.container.appendChild(noResultsMessage);
            return;
        }

        try {
            container.forEach(tag => {
                const tagElement = document.createElement('div');
                tagElement.classList.add('relative', 'border-1', 'border-secondary', 'w-56', 'p-2', 'rounded-t-xl', 'shadow-lg', 'animate-slideRight');
                tagElement.innerHTML = `
                    <div class="flex justify-between text-sm text-text-light  dark:text-gray-400">
                        <span class="text-sm font-semibold">#${tag.tag_name}</span>
                        <span class="font-semibold">${parseInt(tag.percentage)}%</span>
                    </div>
                    <span class="percent-line w-0 transition-all duration-1000 absolute h-[2px] border-2 border-[#4CAF50] left-0 rounded-2xl -bottom-0.5"></span>
                `;

                setTimeout(function() {
                    const tagWidth = tagElement.offsetWidth;
                    const lineWidth = (tagWidth * parseInt(tag.percentage)) / 100;

                    const percentLine = tagElement.querySelector('.percent-line');
                    percentLine.style.width = `${lineWidth}px`;
                }, 1200)

                this.container.appendChild(tagElement);
            })

            
        } catch (error) {
            console.error('Error fetching top tags:', error);
        }
    }

    renderNotificationsPopup(notifications) {
        if (!this.container) return;
        this.container.innerHTML = '';

        if (!notifications || notifications.length === 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.id = 'no-notify';
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
            noResultsMessage.textContent = 'There is no notifications';
            this.container.appendChild(noResultsMessage);
            return;
        }


        let newBadge = document.querySelector('#notify-badge');
        if (!newBadge) {
            newBadge = document.createElement('span');
            newBadge.id = 'notify-badge';
            newBadge.classList.add('absolute', 'text-xs', '-top-1', '-right-1', 'px-2', 'bg-red-500', 'rounded-full', 'text-white', 'hidden');
        }

        const unreadCount = notifications.filter(notify => notify.is_read == '0').length;
        if (unreadCount > 0) {
            newBadge.textContent = unreadCount;
            newBadge.classList.add('inline');
            document.querySelector('#notify-btn').appendChild(newBadge);
        }

        notifications.forEach(notify => {
            const notifyElement = document.createElement('a');
            notifyElement.classList.add('flex', 'justify-between' ,'px-2', 'py-2' ,'text-left', 'space-x-2', 'hover:bg-gray-200', 'cursor-pointer', 'dark:hover:bg-gray-700');

            if (notify.is_read == '0') {
                notifyElement.classList.add('bg-blue-200', 'dark:bg-gray-200');
            }

            notifyElement.href = `${notify.url}`;
            notifyElement.id = `notify-${notify.notification_id}`;
            const timeInMonth = new Date(notify.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            const timeInHour = new Date(notify.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            notifyElement.innerHTML = `
                <div class="flex space-x-3">
                    <img loading="lazy" src="${notify.avatar ?? '../assets/images/user.png'}" alt="" class="h-8 rounded-full">

                    <div class="flex flex-col space-y-1 dark:text-gray-400">
                        <span><b>${notify.username}</b> ${notify.message}</span>

                        <span class="text-text-light break-all line-clamp-1 dark:text-gray-600">${notify.message_content || 'Check it out!'}</span>
                    </div>
                </div>

                <div class="flex flex-col space-y-1 text-nowrap mt-1 text-right dark:text-gray-400">
                    <span class="text-xs">${timeInMonth}</span>
                    <span class="text-xs">${timeInHour}</span>
                </div>
            
            `;
            this.container.appendChild(notifyElement)
        });
    }

    renderNotifications(notifications) {
        if (!this.container) return;
        this.container.innerHTML = '';

        if (!notifications || notifications.length === 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
            noResultsMessage.textContent = 'There is no notifications';
            this.container.appendChild(noResultsMessage);
            return;
        }

        


        notifications.forEach(notification => {
            const notifyElement = document.createElement('div');
            notifyElement.setAttribute('data-value', notification.notification_id);
            const timeInMonth = new Date(notification.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            const timeInHour = new Date(notification.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            notifyElement.classList.add(`notify-${notification.notification_id}`, 'relative' ,'w-full', 'group', 'flex', 'justify-between', 'border-1', 'dark:border-gray-600', 'p-4', 'rounded-md', 'bg-gray-100', 'dark:bg-gray-800', 'md:w-2/3', 'lg:w-1/2', 'animate-slideRight', 'cursor-pointer', 'hover:border-black/20', 'dark:hover:border-gray-400');
            notifyElement.innerHTML = `
                <div class="flex space-x-2  dark:text-gray-500 rounded-lg text-3xl font-light 2xl:w-1/2">
                    <span class="material-symbols-rounded custom-icon">
                        notifications_active
                    </span>
                    <div>
                        <img src="${notification.avatar ?? '../assets/images/user.png'}" alt="" class="h-8">

                        <div class="text-lg font-normal">
                            <h2 class="dark:text-gray-400"><b>${notification.username}</b> ${notification.message}</h2>
                            <h3 class="text-gray-500">${notification.message_content || 'Check it out!'}</h3>
                        </div>
                    </div>
                </div>
                <div class="text-sm text-right flex justify-end flex-col dark:text-gray-400 w-fit">
                    <div class="flex flex-col text-nowrap">
                        <span>${timeInMonth}</span>
                        <span>${timeInHour}</span>
                    </div>
                </div>
                <div class="group absolute right-0 top-0 text-center  dark:text-red-500 p-1 text-2xl font-light rounded-full cursor-pointer">
                    <span id="delete-notify" class="material-symbols-rounded custom-icon p-1 rounded-full hover:bg-red-300 dark:hover:bg-red-100 active:scale-90">
                        delete
                    </span>
                </div>
            `;

            

            if (notification.is_read == '0') {
                const firstChildElement = notifyElement.firstChildElement;
                let newBadge = document.createElement('div');
                newBadge.classList.add('badge', 'absolute', 'right-2', '-top-2');
                newBadge.innerHTML = `
                    <span class="absolute animate-ping p-2 rounded-full bg-red-400 opacity-75"></span>
                    <span class="absolute bg-red-500 rounded-full p-2 ">
                `;

                notifyElement.insertBefore(newBadge, firstChildElement);
            }

            notifyElement.addEventListener('click', function() {
                window.location.href = `${notification.url}`;
            })

            this.container.appendChild(notifyElement)
        })
    }

    renderFollower(followerList, followerContainer) {
        if (!followerList || followerList.length == 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
            noResultsMessage.textContent = 'You have no followers';
            followerContainer.appendChild(noResultsMessage);
            return;
        }

        followerList.forEach(follower => {
            const followerElement = document.createElement('div');
            followerElement.classList.add('follow-element', 'flex', 'p-2', 'space-x-2', 'hover:bg-gray-200', 'dark:hover:bg-gray-700', 'cursor-pointer');
            followerElement.innerHTML = `
                <img src="${follower.avatar || '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                <div class="flex flex-col -space-y-1 text-sm">
                    <span class="follow-tagname dark:text-white">${follower.tag_name}</span>
                    <span class="follow-fullname dark:text-gray-400">${follower.fullname}</span>
                </div>
            `;


            followerElement.addEventListener('click', function() {
                window.location.href = `../views/main.html.php?page=profile&tag_name=${follower.tag_name}`;
            })

            followerContainer.appendChild(followerElement)
        })
    }

    renderFollowing(followingList, followingContainer) {
        if (!followingList || followingList.length == 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
            noResultsMessage.textContent = 'You have not followed anyone yet';
            followingContainer.appendChild(noResultsMessage);
            return;
        }

        followingList.forEach(follower => {
            const followerElement = document.createElement('div');
            followerElement.classList.add('follow-element','flex', 'p-2', 'space-x-2', 'hover:bg-gray-200', 'dark:hover:bg-gray-700', 'cursor-pointer');
            followerElement.innerHTML = `
                <img src="${follower.avatar || '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                <div class="flex flex-col -space-y-1 text-sm">
                    <span class="follow-tagname dark:text-white">${follower.tag_name}</span>
                    <span class="follow-fullname dark:text-gray-400">${follower.fullname}</span>
                </div>
            `;

            followerElement.addEventListener('click', function() {
                window.location.href = `../views/main.html.php?page=profile&tag_name=${follower.tag_name}`;
            })

            followingContainer.appendChild(followerElement)
        })
    }


    groupByDate(posts) {
        return posts.reduce((grouped, post) => {
            const date = this.formatDate(post.read_date);
            if (!grouped[date]) {
                grouped[date] = [];
            }
            grouped[date].push(post);
            return grouped;
        }, {});
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const yesterday = new Date(now);
        yesterday.setDate(now.getDate() - 1);

        const isToday = date.toDateString() === now.toDateString();
        const isYesterday = date.toDateString() === yesterday.toDateString();

        if (isToday) {
            return `Today`;
        } else if (isYesterday) {
            return `Yesterday`;
        } else {
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }
    }

    async initSessionData() {
        try {
            // Fetch session data from the server
            const sessionData = await this.fetchData('../controllers/session_data.php');
    
            // Ensure session data is valid
            if (sessionData && sessionData.user_id) {
                this.userId = sessionData.user_id;
                this.fullName = sessionData.fullname || '';
                this.username = sessionData.username || '';
                this.avatar = sessionData.avatar || '';
                this.tagName = sessionData.tag_name || '';
                this.roleId = sessionData.role_id || 1;
            } else {
                throw new Error('Invalid session data received');
            }
        } catch (error) {
            console.error('Error initializing session data:', error);
        }
    }

    // Admin Render Functions
    renderAdminUsers(userList) {
        if (!userList || userList.length == 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
            noResultsMessage.textContent = 'You have not followed anyone yet';
            followingContainer.appendChild(noResultsMessage);
            return;
        }

        const totalUsers = document.querySelector('#total-users');
        totalUsers.textContent = userList.length;

        userList.forEach(user => {
            console.log(user.create_at)
            const createdAt = new Date(user.created_at);
        const formattedDate = createdAt.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            const userElement = document.createElement('tr');
            userElement.setAttribute('data-value', user.user_id);
            userElement.innerHTML = `
                <td class="text-left">
                    <div class="flex space-x-4">
                        <img src="${user.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                        <div>
                            <span class="font-semibold text-white">${user.fullname}</span>
                            <span class="text-sm">@${user.tag_name}</span>
                            <p>${user.email ?? 'No information'}</p>
                        </div>
                    </div>
                </td>
                <td>${user.username}</td>
                <td>${user.role_id == 2 ? 'Admin' : 'User'}</td>
                <td>
                    <span class="bg-green-100 text-green-600 font-semibold   rounded-full p-2">Active</span>
                </td>
                <td>
                    ${formattedDate}
                </td>
                <td>
                    <div class="flex text-2xl text-center justify-center">
                        <span class="view-userbtn material-symbols-rounded custom-icon p-2 rounded-full hover:bg-gray-700 active:scale-90 cursor-pointer">
                            visibility
                        </span>
                        <span class="edit-userbtn material-symbols-rounded custom-icon p-2 rounded-full hover:bg-gray-700 active:scale-90 cursor-pointer">
                            edit
                        </span>
                        <span class="delete-userbtn material-symbols-rounded custom-icon p-2 rounded-full hover:bg-gray-700 active:scale-90 cursor-pointer">
                            delete
                        </span>
                    </div>
                </td>
            `;
            this.container.appendChild(userElement);
        })

    }
}

// Export the class
export default QuestionRenderer;