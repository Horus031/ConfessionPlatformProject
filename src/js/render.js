class QuestionRenderer {
    constructor(containerId, filterId, totalQuestionsId) {
        this.container = document.querySelector(containerId);
        this.filterContainer = document.querySelector(filterId);
        this.totalQuestionsElement = document.querySelector(totalQuestionsId);
    }

    async fetchData(url, options = {}) {
        try {
            const response = await fetch(url, options);
            const data = await response.json();
            console.log(data);
            if (data.error) {
                throw new Error(data.error);
            }
            return data;
        } catch (error) {
            console.error(`Error fetching data from ${url}:`, error);
            throw error;
        }
    }

    renderQuestions(questions, userId) {
        if (!this.container) return;
        this.container.innerHTML = ''; // Clear previous questions

        const fragment = document.createDocumentFragment();

        questions.forEach(question => {
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
                                <button type="button" id="view-btn" class="flex w-full items-center space-x-4 p-3 hover:bg-gray-200 cursor-pointer">
                                    <span>View Details</span>
                                </button> 
                                <button type="button" id="edit-btn" class="flex w-full items-center space-x-4 p-3 ${question.user_id == userId ? 'block' : 'hidden'}  hover:bg-gray-200 cursor-pointer">
                                    <span>Edit</span>
                                </button>
                                <form action="../controllers/deletepost.php" method="post" class="${question.user_id == userId ? 'block' : 'hidden'} ">
                                    <input type="hidden" name="post_id" value="${question.post_id}">
                                    <input type="submit" value="Delete" class="space-x-4 p-3 text-left cursor-pointer hover:bg-gray-200 text-red-400 w-full">
                                </form>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-3 font-semibold text-lg w-56">${question.post_title}</h2>
                    <p class="mt-3 text-xs text-text-light font-medium line-clamp-1">${question.post_content}</p>
                    <div class="mt-3 border-2 border-gray-200 rounded-md">
                        <img loading="lazy" src="${question.imageURL ?? ''}" alt="Post image" width="100%" height="100px" class="rounded-md lazy-load">
                    </div>
                    <div class="flex justify-between items-center mt-3">
                        <div class="flex items-center space-x-2">
                            <img loading="lazy" src="${question.avatar ? question.avatar : '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                            <span class="text-xs">${question.username}</span>
                            <span class="text-xs">${new Date(question.created_at).toLocaleString()}</span>
                        </div>
                        <div id="tags-container-${question.post_id}" class="flex items-center space-x-2 text-sm"></div>
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
                    case button.id == "link-btn":
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
            });

            fragment.appendChild(questionElement);
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
            tagElement.classList.add('border', 'border-gray-300', 'rounded-md', 'p-4', 'tag-element', 'animate-postSlideIn');
            tagElement.innerHTML = `
                <input id="tag-value" type="hidden" value="${tag.tag_type}">
                <span class="w-fit rounded-full bg-gray-300 px-2 text-sm font-medium">#${tag.tag_name}</span>
                <p class="text-sm mt-4 text-text-light font-normal">${tag.tag_description}</p>
            `;

            fragment.appendChild(tagElement);
        });

        this.container.appendChild(fragment);
    }

    filterTags() {
        const filterTags = document.querySelector('#filter-tags');
        const tagElements = document.querySelectorAll('div[id^="tag-"]');
        filterTags.addEventListener('change', function() {
            if (filterTags.value == "all") {
                tagElements.forEach(tag => {
                    tag.classList.remove('hidden');
                    tag.classList.add('animate-postSlideIn');
                });
            } else {
                tagElements.forEach(tag => {
                    const tagValue = tag.querySelector('#tag-value');
                    const tagType = tagValue.value;
                    if (tagType == filterTags.value) {
                        tag.classList.remove('hidden');
                        tag.classList.add('animate-postSlideIn');
                    } else {
                        tag.classList.add('hidden');
                    }
                });
            }
        });
    }

    renderModules(modules) {
        if (!this.filterContainer) return;

        modules.forEach(module => {
            const option = document.createElement('option');
            option.value = `${module.module_id}`;
            option.textContent = `${module.module_name}`;
            this.filterContainer.appendChild(option);
        });
    }

    renderUserProfile(data) {
        const profileContainer = document.querySelector('#info-container');
        const bioContainer = document.querySelector('#bio-container');
        if (data.error) {
            profileContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
        } else {
            console.log(data);
            const profileElements = document.createElement('div');
            profileElements.classList.add('flex', 'flex-col', 'space-y-2');

            const createdAt = new Date(data[0].created_at);
            const formattedDate = createdAt.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });

            profileElements.innerHTML = `
                <div>
                    <span class="text-text font-medium">@${data[0].tag_name ?? ''}</span>
                    <span class="text-text">•</span>
                    <span class="text-text-light font-medium">Joined ${formattedDate}</span>
                </div>
                <div class="flex flex-col space-y-2">
                    <div>
                        <span>0</span>
                        <span class="text-text">Followers</span>
                        <span>0</span>
                        <span class="text-text">Following</span>
                    </div>
                    <div>
                        <span>0</span>
                        <span class="text-text">Views</span>
                        <span>0</span>
                        <span class="text-text">Likes</span>
                    </div>
                </div>
            `;

            const socialContainer = document.createElement('div');
            socialContainer.classList.add('space-x-2');
            data.forEach(link => {
                if (link.url && link.platform) {
                    const socialLink = document.createElement('a');
                    socialLink.href = link.url;
                    socialLink.target = '_blank';
                    socialLink.classList.add('border-1', 'border-secondary', 'rounded-xl', 'px-4', 'py-1', 'font-semibold');
                    socialLink.textContent = `@${link.platform}`;
                    socialContainer.appendChild(socialLink);
                }
            });

            const bioContext = document.createElement('span');
            bioContext.classList.add('font-semibold', 'text-text-light');
            bioContext.textContent = `${data[0].bio}`;

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
            console.log(posts);
            posts.forEach(myPost => {
                if (myPost.user_id == userId) {
                    hasPosts = true;
                    const mypostElements = document.createElement('div');
                    mypostElements.classList.add('flex', 'items-center', 'justify-between', 'border-2', 'border-secondary', 'mt-2', 'p-4', 'rounded-lg', 'w-full', 'hover:border-black', 'cursor-pointer', 'animate-slideRight', 'transition-all');
                    mypostElements.innerHTML = `
                        <div class="space-y-2">
                            <h2 class="font-semibold text-xl line-clamp-2">${myPost.post_title}</h2>
                            <p class="text-sm text-text-light font-medium">${myPost.post_content}</p>
                            <div class="flex items-center w-fit justify-around border-2 border-secondary rounded-xl p-2 ">
                                <div class="flex items-center space-x-2 text-text font-medium px-2">
                                    <img src="../assets/images/like.png" alt="" class="h-6">
                                    <span>${myPost.likes}</span>
                                </div>
                                <div class="flex items-center space-x-2 text-text font-medium px-2">
                                    <img src="../assets/images/comments.png" alt="" class="h-6">
                                    <span>${myPost.comments}</span>
                                </div>
                            </div>
                        </div>
                        <div class="border-2 border-gray-200 rounded-md">
                            <img loading="lazy" src="${myPost.imageURL}" alt="" class="rounded-md h-30 w-30 md:w-60 md:h-40 2xl:h-50">
                        </div>
                    `;

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

    renderPostDetail(post, userId) {
        document.querySelector('#post_id').value = post.post_id;
        document.querySelector('#module-name').textContent = post.module_name;
        document.querySelector('#module-name').className = `w-fit rounded-full text-xs px-2 font-medium ${post.bg_class} ${post.text_class}`;
        document.querySelector('#post-title').textContent = post.post_title;
        document.querySelector('#user-avatar').src = post.avatar ?? '../assets/images/user.png';
        document.querySelector('#username').textContent = post.username;
        document.querySelector('#created-at').textContent = new Date(post.created_at).toLocaleString();
        document.querySelector('#post-content').textContent = post.post_content;
        document.querySelector('#post-image').src = post.imageURL ?? '';
        document.querySelector('#commentCount').textContent = `Comment (${post.comments})`;
        document.querySelector('#likeCount').textContent = `${post.likes}`;

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
                <a class="flex items-center space-x-4 p-3 hover:bg-gray-200 cursor-pointer">
                    <span>Edit</span>
                </a>
                <a href="" class="flex items-center space-x-4 p-3 hover:bg-gray-200">
                    <span class="text-red-400">Delete</span>
                </a>
            </div>
        
        `;

        moduleContainer.appendChild(selectElement);
        
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
}

// Export the class
export default QuestionRenderer;