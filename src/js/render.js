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

    renderQuestions(questions, userId) {
        if (!this.container) return;
        this.container.innerHTML = '';

        const fragment = document.createDocumentFragment();

        questions.forEach(async question => {
            const questionElement = document.createElement('div');
            questionElement.id = `ques-${question.post_id}`;
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
                    <h2 class="mt-3 font-semibold text-lg w-56 h-20">${question.post_title}</h2>
                    <p class="mt-3 text-xs text-text-light font-medium line-clamp-1">${question.post_content}</p>
                    <div>
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
                            <div class="flex justify-between w-fit border-2 border-text-light rounded-md">
                                <button id="likes-btn" class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                                    <img loading="lazy" src="../assets/images/like.png" alt="" class="like-img h-10 p-2">
                                    <span class="like-count" data-post-id="${question.post_id}">${question.likes}</span>
                                </button>
                                <button id="comment-btn" class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                                    <img loading="lazy" src="../assets/images/comments.png" alt="" class="like-img h-10 p-2">
                                    <span class="comment-count" data-post-id="${question.post_id}">${question.comments}</span>
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
                </div>
            `;

            fragment.appendChild(questionElement);


            try {
                const data = await this.fetchData('../controllers/check_likes.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ post_id: question.post_id })
                })

                if (data.error) {
                    console.log(error);
                } else {
                    if (data.status == "yes") {
                        questionElement.querySelector('.like-img').src = '../assets/images/like-on.png';
                    } else {
                        questionElement.querySelector('.like-img').src = '../assets/images/like.png';
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

    renderEditUser(userInfo, username, avatarURL) {
        const imageInput = document.querySelector('#uploadimg-container');
        const imageChildren = document.querySelector('#img-child');

        const accountInput = document.querySelector('#accountinfo-container');
        const bioInput = document.querySelector('#bio-container');
        const socialInput = document.querySelector('#social-container');

        const imageElements = document.createElement('img');
        imageElements.id = 'image';
        imageElements.classList.add('h-20', 'rounded-full');
        imageElements.src = avatarURL;
        imageInput.insertBefore(imageElements, imageChildren);

        accountInput.innerHTML = `
            <div class="relative">
                <img src="../assets/images/name.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="usernameValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your username" value="${username}">
            </div>
            <div class="relative">
                <img src="../assets/images/username.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="tagnameValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your tagname" value="${userInfo[0].tag_name ?? ''}">
            </div>
            <div class="relative">
                <img src="../assets/images/email.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="emailValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your email" value="${userInfo[0].email ?? ''}">
            </div>
        `;

        const bioElement = document.createElement('textarea');
        bioElement.name = 'bioValue';
        bioElement.placeholder = 'Your bio...';
        bioElement.cols = '40';
        bioElement.rows = '8';
        bioElement.classList.add('border-1', 'border-text', 'p-2', 'rounded-lg');
        bioElement.value = `${userInfo[0].bio}`;

        bioInput.appendChild(bioElement);

        userInfo.forEach(link => {
            const socialLinkBox = document.createElement('div');
            socialLinkBox.classList.add('relative');
            socialLinkBox.innerHTML = `
                <img src="../assets/images/${link.platform.toLowerCase()}.png" alt="" class="absolute top-1/2 left-4 h-6">
                <label for="${link.platform}">${link.platform}</label>
                <input type="url" name="social_links[${link.platform}]" id="${link.platform}" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your ${link.platform.toUpperCase()}  Link" value="${link.url}">
            `; 

            socialInput.appendChild(socialLinkBox);
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
        document.querySelector('#created-at').textContent = new Date(post.created_at).toLocaleString();
        document.querySelector('#post-content').textContent = post.post_content;
        document.querySelector('#post-image').src = post.imageURL ?? '';
        document.querySelector('#comment-count').textContent = `(${post.comments})`;
        document.querySelector('#like-count').textContent = `${post.likes}`;
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

            if (data.error) {
                console.log(error);
            } else {
                if (data.status == "yes") {
                    document.querySelector('#like-img').src = '../assets/images/like-on.png';
                } else {
                    document.querySelector('#like-img').src = '../assets/images/like.png';
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
}

// Export the class
export default QuestionRenderer;