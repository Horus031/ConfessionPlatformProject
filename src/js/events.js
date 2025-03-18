import QuestionRenderer from "../js/render.js";

class EventListener {
    constructor(userId) {
        this.renderer = new QuestionRenderer();
        this.currentURL = window.location.href;
        this.userId = userId;
        this.renderedComments = new Set(); // Tạo Set lưu trữ các id của comment
    }

    initElements() {
        this.menuBtn = document.querySelector('#openMenu');
        this.closeBtn = document.querySelector('#closeMenu');
        this.menu = document.querySelector('#menu');
        this.overlay = document.querySelector('#overlay');
        this.navbar = document.querySelector('#navbar');
        this.btnWrapper = document.querySelector('#btn-wrapper');
        this.userBtn = document.querySelector('#user-btn');
        this.userPopup = document.querySelector('#user-popup');
        this.notifyBtn = document.querySelector('#notify-btn');
        this.notifyPopup = document.querySelector('#notify-popup');
        this.buttonContainer = document.querySelector('#button-container');
        this.tagList = document.querySelector('#tag-list');
        this.tagInput = document.querySelector('#tag-input');
        this.selectTagType = document.querySelector('#select-tag-type');
        this.fileInput = document.querySelector('#imageURL');
        this.fileName = document.querySelector('#file-name');
        this.questionElement = document.querySelectorAll('div[id^="ques-"]');
        this.filterTags = document.querySelector('#filter-tags');
        this.tagElements = document.querySelectorAll('div[id^="tag-"]');
        this.postForm = document.querySelector('#post-form');
        this.postDetailContainer = document.querySelector('#postdetail-container');
        this.questionFilter = document.querySelector('#question-filter');
        this.questionContainer = document.querySelector('#question-container');
        this.profileActions = document.querySelector('#profile-actions');
        this.userContainer = document.querySelector('#user-container');
        if (this.userContainer) {
            this.userList = this.userContainer.querySelectorAll('div[id^=user-]')
        }

    }

    handleEvents() {
        const _this = this;
        this.initElements();

        // Bật menu
        this.menuBtn.addEventListener('click', () => {
            this.menu.classList.add('animate-menuTransition');
            this.overlay.classList.remove('hidden');
            this.closeBtn.classList.remove('hidden');
        });

        // Tắt menu
        this.closeBtn.addEventListener('click', () => {
            this.menu.classList.add('animate-menuOut');
            this.menu.classList.remove('animate-menuTransition');
            this.overlay.classList.add('hidden');
            this.closeBtn.classList.add('hidden');
        });

        this.overlay.addEventListener('click', () => {
            this.menu.classList.add('animate-menuOut');
            this.menu.classList.remove('animate-menuTransition');
            this.overlay.classList.add('hidden');
            this.closeBtn.classList.add('hidden');
        });

        // Lặp qua các link trong navbar, check xem đang ở trang nào để thêm class tương ứng
        const buttons = this.navbar.querySelectorAll('a[id$="btn"]');
        buttons.forEach(link => {
            link.classList.remove("bg-gray-200");
            if (link.href === this.currentURL) {
                link.classList.add("bg-gray-200");
            }
        });

        this.userBtn.addEventListener('click', () => {
            this.userPopup.classList.toggle('hidden');
        });


        this.notifyBtn.addEventListener('click', () => {
            this.notifyPopup.classList.toggle('hidden');
        });

        // Check khi click ra ngoài các menu & popup
        document.addEventListener('click', (event) => {
            if (!this.userBtn.contains(event.target) && !this.userPopup.contains(event.target)) {
                this.userPopup.classList.add('hidden');
            }

            if (!this.notifyBtn.contains(event.target) && !this.notifyPopup.contains(event.target)) {
                this.notifyPopup.classList.add('hidden');
            }
        });

        if (this.questionElement) {
            this.questionElement.forEach(question => {
                question.addEventListener('click', function(e) {
                    const postId = question.getAttribute('data-value');
                    let button = e.target.closest('button');
                    if (!button) {
                        window.location.href = `../views/main.html.php?page=postdetails&id=${postId}`;
                    }
                    switch (true) {
                        case button.id == "likes-btn":
                            const likeImage = question.querySelector('.like-img');
                            const likeCountSpan = question.querySelector('.like-count');
                            _this.handleLikes(postId, likeCountSpan, likeImage);
                            break;
                        case button.id == "comment-btn":
                            console.log('comment');
                            break;
                        case button.id == "save-btn":
                            const savedImage = question.querySelector('.saved-img');
                            _this.handleSavedPosts(postId, savedImage);
                            break;
                        case button.id == "link-btn":
                            console.log('link-btn');
                            break;
                        case button.id == "view-btn":
                            window.location.href = `../views/main.html.php?page=postdetails&id=${postId}`;
                            break;
                        case button.id == "edit-btn":
                            sessionStorage.setItem('editPostId', postId);
                            window.location.href = '../views/main.html.php?page=editpost';
                            break;
                    }
                })
            })


            this.questionElement.forEach(question => {
                const postId = question.getAttribute('data-value');
                this.updateLikeCount(postId, question);
                this.updateCommentCount(postId, question);
            })
        }

        if (this.filterTags) {
            this.filterTags.addEventListener('change', function() {
                _this.tagElements.forEach(tag => {
                    tag.classList.remove('animate-postSlideIn');
                })

                setTimeout(function() {
                    if (_this.filterTags.value == "all") {
                        _this.tagElements.forEach(tag => {
                            tag.classList.add('animate-postSlideIn');
                            tag.classList.remove('hidden');
                        });
                    } else {
                        _this.tagElements.forEach(tag => {
                            const tagValue = tag.querySelector('#tag-value');
                            const tagType = tagValue.value;
                            if (tagType == _this.filterTags.value) {
                                tag.classList.add('animate-postSlideIn');
                                tag.classList.remove('hidden');
                            } else {
                                tag.classList.remove('animate-postSlideIn');
                                tag.classList.add('hidden');
                            }
                        });
                    }
                }, 100)
            });
        }

        if (this.questionFilter) {
            this.questionFilter.addEventListener('change', function() {
                _this.questionElement.forEach(question => {
                    question.classList.remove('animate-postScale');
                })

                setTimeout(function() {
                    if (_this.questionFilter.value == 'all') {
                        _this.questionElement.forEach(question => {
                            question.classList.add('animate-postScale');
                            question.classList.remove('hidden');
                        })
                    } else {
                        _this.questionElement.forEach(question => {
                            const moduleElement = question.querySelector('.module-name');
                            const moduleValue = moduleElement.getAttribute('data-module');
                            if (moduleValue == _this.questionFilter.value) {
                                question.classList.add('animate-postScale');
                                question.classList.remove('hidden');
                            } else {
                                question.classList.remove('animate-postScale');
                                question.classList.add('hidden');
                            }
                        })
                    }
                }, 100)
            });
        }

        if (this.postDetailContainer) {
            this.postDetailContainer.addEventListener('click', function(e) {
                const postId = _this.postDetailContainer.getAttribute('data-value');
                let button = e.target.closest('button');

                if (!button) {
                    return;
                }

                switch(true) {
                    case button.id == "like-btn":
                        const likeImage = _this.postDetailContainer.querySelector('#like-img');
                        const likeCountSpan = _this.postDetailContainer.querySelector('.like-count');
                        _this.handleLikes(postId, likeCountSpan, likeImage);
                        break;
                    case button.id == "edit-btn":
                        sessionStorage.setItem('editPostId', postId);
                        window.location.href = '../views/main.html.php?page=editpost';
                        break;
                    case button.id == "save-btn":
                        console.log('bookmark');
                        break;
                    case button.id == "link-btn":
                        console.log('link-btn');
                        break;
                    default:
                        break;

                }
            })
        }

        if (this.postForm) {
            this.postForm.addEventListener('submit', async function(e) {
                e.preventDefault();
    
    
                let postId = _this.postForm.dataset.postId;
                let textarea = _this.postForm.querySelector('textarea');
                let commentContent = textarea.value.trim();
                let userId = _this.userId;
    
                if (commentContent === "") return;
    
                const newComment = await _this.renderer.fetchData('../controllers/add_comments.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: userId, post_id: postId, content: encodeURIComponent(commentContent) })
                });
    
                if (newComment.error) {
                    console.log (newComment.error);
                } else {
                    console.log(newComment);
                    const commentContainer = document.querySelector('#comment-container');
                    const firstChildElement = commentContainer.firstElementChild;
    
                    const newCommentElement = document.createElement('div');
                    newCommentElement.setAttribute('data-value', `${newComment.comment_id}`)
                    newCommentElement.classList.add('bg-[#F1F1F1]', 'flex', 'p-4', 'space-x-4', 'rounded-md', 'animate-slideRight');
                    newCommentElement.innerHTML = `
                        <img src="${newComment.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
    
                            <div>
                                <h2 class="font-medium text-md">${newComment.username}</h2>
                                <p class="text-sm">${newComment.content}</p>
                            </div>
                    `;
    
                    commentContainer.insertBefore(newCommentElement, firstChildElement);
                    _this.renderedComments.add(newComment.comment_id); // Thêm comment id vừa post vào Set
    

                    textarea.value = '';
                    document.querySelector('.comment-count').textContent = `(${_this.renderedComments.size})`;
                }
    
                
            })
        }

         // Custom ô hình ảnh
         if (this.fileInput) {
            this.fileInput.addEventListener('change', function() {
                if (_this.fileInput.files.length > 0) {
                    _this.fileName.textContent = _this.fileInput.files[0].name;
                } else {
                    _this.fileName.textContent = 'Upload your image';
                }
            });
        }

        // Tạo logic chọn tag
        if (this.selectTagType) {
            this.selectTagType.addEventListener('change', function() {
                let selectedValue = _this.selectTagType.value;
                
                while (_this.tagList.firstChild) {
                    _this.tagList.removeChild(_this.tagList.firstChild);
                }
    
                fetch('../controllers/tags_withtype.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ type: selectedValue })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        _this.tagList.innerHTML = `<option>${data.error}</option>`
                    } else {
                        if (selectedValue == '') {
                            _this.tagList.classList.add('hidden');
                            _this.buttonContainer.classList.add('hidden');
                            _this.tagInput.classList.add('hidden');
                        } else {
                            _this.tagList.classList.remove('hidden');
                            _this.buttonContainer.classList.remove('hidden');
                            _this.tagInput.classList.remove('hidden');
                            data.forEach(tag => {
                                const tagElement = document.createElement('option');
                                tagElement.value = `${tag.tag_name}`;
                                tagElement.textContent = `${tag.tag_name}`;
                                _this.tagList.appendChild(tagElement);
                            })
                        }
                    }
                })
            });
        }

        // Tạo tương tác giữa nút thêm và xóa tag
        if (this.buttonContainer) {
            this.buttonContainer.addEventListener('click', function(e) {
                if (e.target.closest('button[id="add-btn"]')) {
                    const selectedTag = _this.tagList.value;
                    const currentTags = _this.tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag !== '');
    
                    if (currentTags.includes(selectedTag)) {
                        console.log('You cannot duplicate the tag!');
                    } else {
                        currentTags.push(selectedTag);
                        _this.tagInput.value = currentTags.join(', ');
                    }
    
                } else if (e.target.closest('button[id="remove-btn"]')) {
                    const selectedTag = _this.tagList.value;
                    let currentTags = _this.tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag !== '');
    
                    currentTags = currentTags.filter(tag => tag !== selectedTag);
                    _this.tagInput.value = currentTags.join(', ');
                }
            });
        }


        // Xử lý các event liên quan đến profile
        if (this.profileActions) {
            const editButton = this.profileActions.querySelector('#edit-profile');
            const followButton = this.profileActions.querySelector('#follow-btn');
            const userTagName = this.profileActions.getAttribute('data-tagname');

            if (this.userId == this.profileActions.getAttribute('data-value')) {
                this.profileActions.removeChild(followButton);
                editButton.classList.remove('hidden');
            } else {
                this.profileActions.removeChild(editButton)
                followButton.classList.remove('hidden');
            }

            this.profileActions.addEventListener('click', function(e) {
                if (e.target.closest('a#edit-profile')) {
                    sessionStorage.setItem('editUserTagName', userTagName);
                    window.location.href = "../views/main.html.php?page=editprofile"
                    
                } else if (e.target.closest('a#follow-btn')) {
                    console.log(e.target);
                }
            })
        }
        

        if (this.userContainer && this.userList) {
            this.userList.forEach(user => {
                const userTagName = user.querySelector('h3[id^="user-tagname"]')
                console.log(userTagName);
                user.addEventListener('click', function() {
                    window.location.href = `main.html.php?page=profile&tag_name=${userTagName.textContent}`;
                })
            })
        }

    }

    async handleSavedPosts(postId, savedImage) {
        try {
            const savedPosts = await this.renderer.fetchData('../controllers/handle_savedpost.php' ,{
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId })
            })

            if (savedPosts.status == "saved") {
                console.log(savedPosts)
                console.log('save!')
                savedImage.src = '../assets/images/saved-on.png';
            } else {
                console.log(savedPosts)
                console.log('unsave');
                savedImage.src = '../assets/images/saved.png';
            }
        } catch (error) {
            console.error('Error handling saved post:', error);
        }
    }

    async handleLikes(postId, likeCountSpan, likeImage) {
        try {
            const likes = await this.renderer.fetchData('../controllers/handle_likes.php', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId })
            })
            if (likes.status == "like") {
                likeImage.src = '../assets/images/like-on.png';
                likeCountSpan.textContent = parseInt(likeCountSpan.textContent) + 1;
            } else {
                likeImage.src = '../assets/images/like.png';
                likeCountSpan.textContent = parseInt(likeCountSpan.textContent) - 1;
            }
        } catch (error) {
            console.error('Error handling likes:', error);
        }
        
    }

    async updateLikeCount(postId, container) {
        try {
            const likeCount = await this.renderer.fetchData(`../controllers/get_likecount.php?id=${postId}`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId })
            });
            if (likeCount.error) {
                console.log(likeCount.error);
            } else {
                let likeCountSpan = container.querySelector(`.like-count`);
                if (likeCountSpan) {
                    likeCountSpan.textContent = likeCount.like_count;
                }
            }
        } catch (error) {
            console.error('Error updating like count:', error);
        } finally {
            setTimeout(() => this.updateLikeCount(postId, container), 5000);
        }
    }

    async updateCommentCount(postId, container) {
        try {
            const commentCount = await this.renderer.fetchData(`../controllers/get_commentcount.php?id=${postId}`, {
                method: "POST",
                headers: { "Content-Type" : "application/json" },
                body: JSON.stringify({ post_id: postId })
            });
            if (commentCount.error) {
                console.log(commentCount.error)
            } else {
                let commentCountSpan = container.querySelector('.comment-count');
                if (commentCountSpan) {
                    commentCountSpan.textContent = commentCount.comment_count;
                }
            }
        } catch (error) {
            console.log('Error updating comment count:', error);
        } finally {
            setTimeout(() => this.updateCommentCount(postId, container), 5000);
        }
    }

    
    async updateComments(postId) {
        try {
            const comments = await this.renderer.fetchData(`../controllers/get_comments.php?id=${postId}`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId })
            });
            if (comments.error) {
                console.log(comments.error);
            } else {
                const commentContainer = document.querySelector('#comment-container');
                const firstChildElement = commentContainer.firstElementChild;
                comments.forEach(comment => {
                    if (!this.renderedComments.has(comment.comment_id)) {
                        const commentElement = document.createElement('div');
                        commentElement.setAttribute('data-value', `${comment.comment_id}`);
                        commentElement.classList.add('bg-[#F1F1F1]', 'flex', 'p-4', 'space-x-4', 'rounded-md', 'animate-slideRight');
                        commentElement.innerHTML = `
                            <img src="${comment.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                            <div>
                                <h2 class="font-medium text-md">${comment.username}</h2>
                                <p class="text-sm">${comment.content}</p>
                            </div>
                        `;
                        commentContainer.insertBefore(commentElement, firstChildElement);
                        this.renderedComments.add(comment.comment_id); // Thêm comment ID vừa post vào Set
                    }
                });
                document.querySelector('.comment-count').textContent = `(${this.renderedComments.size})`;
                
            }
        } catch (error) {
            console.error('Error updating comments:', error);
        } finally {
            setTimeout(() => this.updateComments(postId), 5000);
        }
    }

    

    start() {
        this.handleEvents();

        const postId = this.postDetailContainer ? this.postDetailContainer.getAttribute('data-value') : null;
        if (postId) {
            this.updateLikeCount(postId, this.postDetailContainer);
            this.updateComments(postId);
        }

        

        
    }
}

// Export the class
export default EventListener;