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
        this.questionElement = document.querySelectorAll('div[id^="ques-"]');
        this.filterTags = document.querySelector('#filter-tags');
        this.tagElements = document.querySelectorAll('div[id^="tag-"]');
        this.postForm = document.querySelector('#post-form');
        this.postDetailContainer = document.querySelector('#postdetail-container');
        this.questionFilter = document.querySelector('#question-filter');
        this.questionContainer = document.querySelector('#question-container');
    }

    handleEvents() {
        const _this = this;
        setTimeout(this.initElements(), 100);

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
                        console.log('bookmark');
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

        if (this.filterTags) {
            this.filterTags.addEventListener('change', function() {
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
                        const likeCountSpan = _this.postDetailContainer.querySelector('#like-count');
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
                    document.querySelector('#comment-count').textContent = `(${_this.renderedComments.size})`;
                }
    
    
            })
        }

        if (this.questionFilter) {
            this.questionFilter.addEventListener('change', function() {
                if (_this.questionFilter.value == 'All') {
                    _this.questionContainer.forEach(question => {
                        question.classList.remove('hidden');
                        question.classList.add('animate-postScale');
                    })
                }
            });
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

    async updateLikeCount(postId) {
        try {
            const likeCount = await this.renderer.fetchData(`../controllers/get_likes.php?id=${postId}`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId })
            });
            if (likeCount.error) {
                console.log(likeCount.error);
            } else {
                let likeCountSpan = document.querySelector(`#like-count`);
                if (likeCountSpan) {
                    likeCountSpan.textContent = likeCount.like_count;
                }
            }
        } catch (error) {
            console.error('Error updating like count:', error);
        } finally {
            setTimeout(() => this.updateLikeCount(postId), 5000);
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
                document.querySelector('#comment-count').textContent = `(${this.renderedComments.size})`;
                
            }
        } catch (error) {
            console.error('Error updating comments:', error);
        } finally {
            setTimeout(() => this.updateComments(postId), 5000); // Long polling
        }
    }

    

    start() {
        this.handleEvents();

        const postDetailId = this.postDetailContainer ? this.postDetailContainer.getAttribute('data-value') : null;
        if (postDetailId) {
            this.updateLikeCount(postId);
            this.updateComments(postId);
        }

        
    }
}

// Export the class
export default EventListener;