class QuestionRenderer {
    constructor(containerId, filterId) {
        this.container = document.querySelector(containerId);
        this.filterContainer = document.querySelector(filterId);
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
                const questionElement = document.createElement('div');
                questionElement.id = `ques-${post.post_id}`;
                questionElement.setAttribute('data-value', `${post.post_id}`);
                questionElement.classList.add('font-poppins','mt-2', 'border-2', 'p-4', 'rounded-md', 'border-gray-200', 'hover:border-black', 'cursor-pointer', 'dark:border-gray-700', 'dark:hover:border-gray-500', 'dark:bg-gray-800');
                questionElement.innerHTML = `
                    <div class="flex flex-col">
                        <input type="hidden" name="post_id" value="${post.post_id}">
                        <div class="flex justify-between items-center">
                            <span data-module="${post.module_id}" class="w-fit module-name rounded-full text-xs ${post.bg_class} ${post.text_class} px-2 font-medium">${post.module_name}</span>
                            <div class="relative group">
                                <img src="../assets/images/dots.png" class="h-10 hover:bg-gray-300 p-2 rounded-full">
                                <div id="action-popup" class="absolute bg-white rounded-md shadow-[0_4px_12px_-4px] top-12 right-0 w-40 hidden lg:group-hover:block before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent">
                                    <button type="button" id="view-btn" class="flex w-full items-center space-x-4 p-3 hover:bg-gray-200 cursor-pointer">
                                        <span>View Details</span>
                                    </button> 
                                    <button type="button" id="edit-btn" class="flex w-full items-center space-x-4 p-3 ${post.user_id == userId ? 'block' : 'hidden'}  hover:bg-gray-200 cursor-pointer">
                                        <span>Edit</span>
                                    </button>
                                    <form action="../controllers/deletepost.php" method="post" class="${post.user_id == userId ? 'block' : 'hidden'} ">
                                        <input type="hidden" name="post_id" value="${post.post_id}">
                                        <input type="submit" value="Delete" class="space-x-4 p-3 text-left cursor-pointer hover:bg-gray-200 text-red-400 w-full">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <h2 class="mt-3 font-bold text-lg w-56 h-20 dark:text-white">${post.post_title}</h2>
                        <p class="mt-3 text-text-light text-sm dark:text-gray-400 font-medium line-clamp-1">${post.post_content}</p>
                        <div>
                            <div class="mt-3 rounded-md">
                                <img loading="lazy" src="${post.imageURL ?? ''}" alt="Post image" width="100%" height="100px" class="rounded-md lazy-load">
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <div class="flex items-center space-x-2">
                                    <img loading="lazy" src="${post.avatar ? post.avatar : '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
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
                                        <span class="like-count text-lg" data-post-id="${post.post_id}">${post.like_count}</span>
                                    </button>
                                    <button id="comment-btn" class="flex items-center space-x-2 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                        <span class="material-symbols-rounded custom-icon">
                                            comment
                                        </span>
                                        <span class="comment-count text-lg" data-post-id="${post.post_id}">${post.comment_count}</span>
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

                fragment.appendChild(questionElement);


                try {
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

                        } else {

                        }
                    }
    
                    if (savedData.error) {
                        console.log(savedData.error);
                    } else {
                        if (savedData.status == 'yes') {

                        } else {

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
                        console.log(savedData);
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
        if (interval > 1) {
            return interval + " years ago";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
            return interval + " months ago";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
            return interval + " days ago";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
            return interval + " hours ago";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
            return interval + " minutes ago";
        }
        return Math.floor(seconds) + " seconds ago";
    }

    renderQuestions(questions, userId) {
        if (!this.container) return;
        this.container.innerHTML = '';

        if (!questions || questions.length === 0) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4');
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
            questionElement.classList.add('mt-2', 'border-1', 'p-4', 'rounded-md', 'border-gray-200', 'hover:border-black', 'cursor-pointer', 'dark:border-gray-700', 'dark:hover:border-gray-500', 'dark:bg-gray-800');
            questionElement.innerHTML = `
                <div class="flex flex-col">
                    <input type="hidden" name="post_id" value="${question.post_id}">
                    <div class="flex justify-between items-center">
                        <span data-module="${question.module_id}" class="font-semibold w-fit module-name rounded-full text-xs ${question.bg_class} ${question.text_class} px-2">${question.module_name}</span>
                        <div class="relative group rounded-md text-4xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 active:scale-90">
                            <span id="post-actions" class="material-symbols-rounded custom-icon more-icon">
                                more_horiz
                            </span>
                            <div id="action-popup" class="absolute bg-white rounded-md top-12 shadow-[0px_0px_5px_-1px] right-0 w-40 hidden before:content-[''] before:absolute before:w-12 before:h-0 before:right-0 before:-top-2 before:border-4 before:border-transparent dark:bg-gray-900 dark:text-gray-400 dark:shadow-none">
                                <button type="button" id="view-btn" class="flex w-full items-center rounded-md space-x-4 p-3 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                                    <span class="text-lg">View Details</span>
                                </button> 
                                <button type="button" id="edit-btn" class="flex w-full items-center rounded-md space-x-4 p-3 ${question.user_id == userId ? 'block' : 'hidden'}  hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                                    <span class="text-lg">Edit</span>
                                </button>
                                <form action="../controllers/deletepost.php" method="post" class="${question.user_id == userId ? 'block' : 'hidden'} ">
                                    <input type="hidden" name="post_id" value="${question.post_id}">
                                    <input type="submit" value="Delete" class="space-x-4 p-3 text-left rounded-md text-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 text-red-400 w-full">
                                </form>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-3 font-bold text-lg w-56 h-16 line-clamp-2 dark:text-white">${question.post_title}</h2>
                    <p class="font-roboto mt-3 text-md text-text font-normal line-clamp-1 dark:text-gray-400">${question.post_content}</p>
                    <div>
                        <div class="mt-3 rounded-md">
                            <img loading="lazy" src="${question.imageURL ?? ''}" alt="Post image" width="100%" height="100px" class="rounded-md lazy-load">
                        </div>
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center space-x-2 font-normal md:space-y-2 md:flex-wrap 2xl:flex-nowrap 2xl:space-y-0">
                                <div class="flex items-center space-x-2">
                                    <div class="relative group">
                                        <img id="profile-hover" loading="lazy" src="${question.avatar ? question.avatar : '../assets/images/user.png'}" alt="" class="h-10 rounded-full">

                                        <div id="profile-popup" class="absolute bg-white w-66 rounded-md p-2 -top-26 left-0 border-1 border-gray-600 before:content-[''] before:absolute before:w-full before:h-0 before:right-0 before:-bottom-2 before:border-4 before:border-transparent group-hover:block hidden transition-all dark:bg-gray-800 dark:border-gray-400">
                                            <div class="flex items_center space-x-4">
                                                <img loading="lazy" src="${question.avatar ? question.avatar : '../assets/images/user.png'}" class="h-20 rounded-full">
                                                <div>
                                                    <h4 class="text-lg font-medium dark:text-white">${question.username}</h4>
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
                                    <span class="like-count text-lg" data-post-id="${question.post_id}">${question.like_count}</span>
                                </button>
                                <button id="comment-btn" class="flex items-center space-x-2 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                    <span class="material-symbols-rounded custom-icon ">
                                        comment
                                    </span>
                                    <span class="comment-count text-lg" data-post-id="${question.post_id}">${question.comment_count}</span>
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

            fragment.appendChild(questionElement);

            try {
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
            tagElement.classList.add('border', 'border-gray-300', 'dark:border-gray-600' ,'rounded-md', 'p-4', 'tag-element', 'animate-postSlideIn');
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

    renderUserProfile(data) {
        const profileContainer = document.querySelector('#info-container');
        const bioContainer = document.querySelector('#bio-container');
        const profileAction = document.querySelector('#profile-actions');
        if (data.error) {
            profileContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
        } else {
            console.log(data);
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
                <div class="flex flex-col space-y-2">
                    <div>
                        <span id="follower-count" class="dark:text-white">0</span>
                        <span class="text-text dark:text-gray-400">Followers</span>
                        <span id="following-count" class="dark:text-white">0</span>
                        <span class="text-text dark:text-gray-400">Following</span>
                    </div>
                    <div>
                        <span id="view-count" class="dark:text-white">0</span>
                        <span class="text-text dark:text-gray-400">Views</span>
                        <span id="like-count" class="dark:text-white">0</span>
                        <span class="text-text dark:text-gray-400">Likes</span>
                    </div>
                </div>
            `;

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
                    console.log(myPost.post_id);
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
                                    <span class="like-count text-lg" data-post-id="${myPost.post_id}">${myPost.like_count}</span>
                                </button>
                                <button id="comment-btn" class="flex items-center space-x-2 p-2 rounded-md text-3xl font-light dark:text-gray-400 hover:bg-gray-400 dark:hover:bg-gray-600 w-full transition-all">
                                    <span class="material-symbols-rounded custom-icon">
                                        comment
                                    </span>
                                    <span class="comment-count text-lg" data-post-id="${myPost.post_id}">${myPost.comment_count}</span>
                                </button>
                            </div>
                        </div>
                        <div class="border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="${myPost.imageURL}" alt="" class="rounded-md h-30 w-30 md:w-60 md:h-40 2xl:h-50">
                        </div>
                    `;

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
                <input type="text" name="usernameValue" id="" class="border-1 border-text rounded-lg text-lg font-normal px-4 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your username" value="${userInfo.username}">
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
        document.querySelector('#username').textContent = post.username;
        document.querySelector('#created-at').textContent = this.timeAgo(post.created_at);
        document.querySelector('#post-content').textContent = post.post_content;
        document.querySelector('#post-image').src = post.imageURL ?? '';
        document.querySelector('.comment-count').textContent = `(${post.comments})`;
        document.querySelector('.like-count').textContent = `${post.likes}`;
        document.querySelector('#comment-container').setAttribute('data-post-id', `${post.post_id}`);
        document.querySelector('#post-form').setAttribute('data-post-id', `${post.post_id}`);

        const usertagContainer = document.querySelector('#user-tag');
        const tagContainer = document.createElement('div');
        tagContainer.classList.add('flex', 'items-center', 'space-x-2', 'text-sm');
        tagContainer.id = `tags-container-${post.post_id}`;

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
        console.log(post);
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

    renderComments(comments) {
        const commentContainer = document.querySelector('#comment-container');

        comments.forEach(comment => {
            const commentElement = document.createElement('div');
            commentElement.setAttribute('data-value', `${comment.comment_id}`)
            commentElement.classList.add('bg-[#F1F1F1]', 'flex', 'p-4', 'space-x-4', 'rounded-md');
            commentElement.innerHTML = `
                <img src="${comment.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 rounded-full">

                    <div>
                        <h2 class="font-medium text-md">${comment.username}</h2>
                        <p class="text-sm">${comment.content}</p>
                    </div>
            `;

            commentContainer.appendChild(commentElement);
        })
    }

    renderAllUsers(userList, userId) {
        if (!this.container) return;
        this.container.innerHTML = '';

        const fragment = document.createDocumentFragment();

        

        userList.forEach(user => {
            if (user.user_id !== userId) {
                const userElement = document.createElement('div');
                userElement.id = `user-${user.user_id}`
                userElement.classList.add('flex', 'space-x-4', 'items-center', 'p-4', 'rounded-lg', 'hover:bg-gray-200', 'dark:hover:bg-gray-800');
                userElement.innerHTML = `
                    <img src="${user.avatar ?? '../assets/images/user.png'}" alt="" class="h-13 lg:h-28 rounded-full">

                    <div>
                        <h2 class="text-lg text-text font-semibold lg:text-2xl dark:text-gray-400">${user.fullname}</h2>
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
        const posts = groupedHistory[date];
        const dateElement = document.createElement('h2');
        dateElement.classList.add('lg:text-3xl');
        dateElement.textContent = date;
        this.container.appendChild(dateElement);

        const postIds = new Set();

        posts.forEach(post => {
            if (!postIds.has(post.post_id)) {
                postIds.add(post.post_id);

                const postElement = document.createElement('div');
                postElement.classList.add('flex', 'space-x-4', 'p-2', 'hover:bg-gray-200', 'dark:hover:bg-gray-700', 'cursor-pointer');
                postElement.innerHTML = `
                    <div class="relative flex items-center pl-4">
                        <img src="${post.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 absolute top-1/4 -left-2 border-1 border-black rounded-full lg:h-20 2xl:h-16">
                        <img src="${post.imageURL}" alt="" class="rounded-md w-40 h-20 lg:w-80 lg:h-40 2xl:w-60">
                    </div>
                    <div>
                        <h2 class="line-clamp-3 leading-5 text-text lg:text-3xl lg:leading-8 dark:text-white">${post.post_title}</h2>
                        <div class="text-sm font-medium text-text lg:text-2xl dark:text-white">
                            <span>${post.like_count}</span>
                            <span>likes</span>
                        </div>
                    </div>
                `;
                this.container.appendChild(postElement);
            }
        });
    });
}y

    // Hàm dùng để gom các ngày đọc bài viết trong lịch sử
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
            return date.toLocaleDateString([], { year: 'numeric', month: 'long', day: 'numeric' });
        }
    }
}

// Export the class
export default QuestionRenderer;