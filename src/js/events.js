import QuestionRenderer from "../js/render.js";

class EventListener {
    constructor() {
        this.renderer = new QuestionRenderer();
        this.currentURL = window.location.href;
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
                        tag.classList.remove('hidden');
                        tag.classList.add('animate-postSlideIn');
                    });
                } else {
                    _this.tagElements.forEach(tag => {
                        const tagValue = tag.querySelector('#tag-value');
                        const tagType = tagValue.value;
                        if (tagType == _this.filterTags.value) {
                            tag.classList.remove('hidden');
                            tag.classList.add('animate-postSlideIn');
                        } else {
                            tag.classList.add('hidden');
                        }
                    });
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
        const likeCount = await this.renderer.fetchData(`../controllers/get_likes.php?post_id=${postId}`, {
            method: "POST",
            header: { "Content-Type": "application/json" },
            body: JSON.stringify({ post_id: postId })
        });
        if (likeCount.error) {
            console.log(likeCount.error);
        } else {
            let likeCountSpan = document.querySelector(`.like-count[data-post-id="${postId}"]`);
            if (likeCountSpan) {
                likeCountSpan.textContent = likeCount.like_count;
            }
        }
    }

    

    start() {
        this.handleEvents();

        setInterval(() => {
            document.querySelectorAll(".like-count").forEach((span) => {
                let postId = span.dataset.postId;
                this.updateLikeCount(postId);
            });
        }, 5000);
    }
}

// Export the class
export default EventListener;