import QuestionRenderer from "../js/render.js";

class EventListener {
    constructor(userId, username, avatar, tagName) {
        this.renderer = new QuestionRenderer();
        this.currentURL = window.location.href;
        this.userId = userId;
        this.username = username;
        this.avatar = avatar
        this.tagName = tagName
        this.renderedComments = new Set(); // Tạo Set lưu trữ các id của comment
        this.socket = new WebSocket(`ws://localhost:8080?user_id=${this.userId}`);


        this.socket.onopen = function() {
            console.log("WebSocket connected!");
        }.bind(this);

        this.socket.onmessage = (event) => {
            let data = JSON.parse(event.data);
        
            if (data.type === "like") {
                document.querySelector(`.like-count-${data.postId}`).innerText = data.likesCount;
            }
        
            if (data.type === "comment") {
                const commentCountSpan = document.querySelector(`.comment-count-${data.postId}`);
                if (commentCountSpan) {
                    commentCountSpan.innerText = data.commentCount;
                }
        
                let commentSection = document.querySelector(`div[id^="comment-container-"]`);
                let firstChildComment = commentSection.firstElementChild;
        
                // Update the badge only if the comment is not from the current user
                if (parseInt(data.userId) !== this.userId) {
                    this.updateNotificationBadge();
                }
        
                // Convert UTC time to local time
                const localTime = new Date(data.created_at);
        
                const newCommentElement = document.createElement('div');
                newCommentElement.setAttribute('data-value', `${data.comment_id}`);
                newCommentElement.classList.add('bg-[#F1F1F1]', 'flex', 'p-4', 'space-x-4', 'rounded-md', 'dark:bg-gray-700', 'animate-slideRight');
                newCommentElement.innerHTML = `
                    <img src="${data.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
        
                    <div>
                        <div class="flex items-center space-x-2">
                            <h2 class="font-medium text-md dark:text-white">${data.username}</h2>
                            <span class="text-xs dark:text-gray-400">${this.renderer.timeAgo(localTime)}</span>
                        </div>
                        <p class="text-sm dark:text-gray-400">${data.comment}</p>
                    </div>
                `;
        
                document.querySelector('.comment-count').textContent = `(${commentSection.children.length})`;
        
                commentSection.insertBefore(newCommentElement, firstChildComment);
            }
        
            if (data.type === "notification") {        
                // Update the notification badge
                this.updateNotificationBadge();
        
                const notifyContainer = document.querySelector('#notify-popup');
                const notifyFirstChild = notifyContainer.firstElementChild;
        
                // Convert UTC time to local time
                const localTime = new Date(data.created_at);
        
                const notifyElement = document.createElement('a');
                notifyElement.classList.add('flex', 'justify-between', 'px-2', 'text-left', 'space-x-2', 'hover:bg-gray-200', 'cursor-pointer', 'bg-blue-200');
                notifyElement.href = `${data.url}`;
                notifyElement.id = `notify-${data.notification_id}`;
                const timeInMonth = localTime.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                const timeInHour = localTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                notifyElement.innerHTML = `
                    <div class="flex space-x-3">
                        <img loading="lazy" src="${data.avatar ?? '../assets/images/user.png'}" alt="" class="h-8 rounded-full">
        
                        <div class="flex flex-col space-y-1">
                            <span>${data.username} ${data.message}</span>
        
                            <span class="text-text-light break-all line-clamp-1">${data.content || 'Check it out!'}</span>
                        </div>
                    </div>
        
                    <div class="flex flex-col space-y-1 text-nowrap mt-1 text-right">
                        <span class="text-xs">${timeInMonth}</span>
                        <span class="text-xs">${timeInHour}</span>
                    </div>
                `;
        
                notifyContainer.insertBefore(notifyElement, notifyFirstChild);
            }
        };
    }

    initElements() {
        this.searchInput = document.getElementById('searchInput');
        this.searchSuggestions = document.getElementById('searchSuggestions');
        this.registerNextButton = document.querySelector('#registerNextBtn');
        this.step1Register = document.querySelector('#step1-container');
        this.step2Register = document.querySelector('#step2-container');
        this.step2Form = document.querySelector('#step2-form');
        this.toastMessage = document.querySelector('#toast-container');
        this.loginForm = document.querySelector('#login-form');
        this.menuBtn = document.querySelector('#openMenu');
        this.closeBtn = document.querySelector('#closeMenu');
        this.menu = document.querySelector('#menu');
        this.overlay = document.querySelector('#overlay');
        this.navbar = document.querySelector('#navbar');
        this.btnWrapper = document.querySelector('#btn-wrapper');
        this.userBtn = document.querySelector('#user-btn');
        this.userPopup = document.querySelector('#users-popup');
        this.notifyBtn = document.querySelector('#notify-btn');
        this.notifyContainer = document.querySelector('#notification-container');
        this.notifyPopupContainer = document.querySelector('#notify-container');
        this.notifyPopup = document.querySelector('#notify-popup');
        this.buttonContainer = document.querySelector('#button-container');
        this.tagList = document.querySelector('#tag-list');
        this.tagInput = document.querySelector('#tag-input');
        this.selectTagType = document.querySelector('#select-tag-type');
        this.savedPostSearch = document.querySelector('#saved-search');
        this.fileInput = document.querySelector('#imageURL');
        this.fileName = document.querySelector('#file-name');
        this.questionElement = document.querySelectorAll('div[id^="ques-"]');
        this.historySearch = document.querySelector('#history-search');
        this.userSeach = document.querySelector('#user-search')
        this.historyElement = document.querySelectorAll('.history-element');
        this.filterTags = document.querySelector('#filter-tags');
        this.tagContainer = document.querySelector('#tags-container');
        this.tagElements = document.querySelectorAll('div[id^="tag-"]');
        this.postForm = document.querySelector('#post-form');
        this.postDetailContainer = document.querySelector('#postdetail-container');
        this.tagSearch = document.querySelector('#tag-search');
        this.questionFilter = document.querySelector('#question-filter');
        this.profileActions = document.querySelector('#profile-actions');
        this.userContainer = document.querySelector('#users-container');
        if (this.userContainer) {
            this.userList = this.userContainer.querySelectorAll('div[id^=user-]')
        }
        this.darkModeToggle = document.querySelector('#darkmode-btn');

    }

    handleEvents() {
        const _this = this;
        this.initElements();
        

        if (this.loginForm) {
            this.loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                let username = _this.loginForm.querySelector('#username').value;
                let password = _this.loginForm.querySelector('#password').value;
                let rememberMe = _this.loginForm.querySelector('#remember_me').checked;
                let isValid = true;

                _this.validateLogin(username, password, isValid);
            
                if (username || password) {
                    try {
                        const loginResult = await _this.renderer.fetchData('../controllers/login.php', {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ username: username, password: password, remember_me: rememberMe })
                        })
        
                        if (loginResult) {
                            if (loginResult.userNotFound) {
                                _this.loginForm.querySelector('input[id="username"]').classList.add('animate-turnErrorColor');
                                _this.showError("username", "Username is not found, please try again.");
                                isValid = false;
                            } else if (loginResult.wrongPassword) {
                                _this.loginForm.querySelector('input[id="password"]').classList.add('animate-turnErrorColor');
                                _this.showError("password", "Password is incorrect.");
                                isValid = false;
                            }
                        }
    
                        if(isValid) {
                            window.location.href = '../views/main.html.php?page=home';
                        }
    
                    } catch (error) {
                        console.error('Error validating form:', error);
                    }
                }
                
            })
        }

        if (this.registerNextButton) {
            this.registerNextButton.addEventListener('click', async function() {
                const username = _this.step1Register.querySelector('#username').value;
                const email = _this.step1Register.querySelector('#email').value;
                const password = _this.step1Register.querySelector('#password').value;
                const confirmPassword = _this.step1Register.querySelector('#confirm-password').value;
                let isValid = true;

                _this.validateRegister(username, email, password, confirmPassword, isValid);

                const validConditions = username || email || password || confirmPassword;

                if (validConditions) {
                    try {
                        const registerResult = await _this.renderer.fetchData('../controllers/validate_register.php', {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ username: username, email: email, password: password, confirm_password: confirmPassword })
                        });

                        if (registerResult.errors) {
                            const errorObj = registerResult.errors;
                            if (errorObj.userExist || errorObj.userLength) {
                                _this.step1Register.querySelector('input[id="username"]').classList.add('animate-turnErrorColor');
                                _this.showError("username", `${errorObj.userExist || errorObj.userLength}`);
                            } else {
                                _this.clearError("username");
                            }

                            if (errorObj.emailExist || errorObj.emailInvalid) {
                                _this.step1Register.querySelector('input[id="email"]').classList.add('animate-turnErrorColor');
                                _this.showError("email", `${errorObj.emailExist || errorObj.emailInvalid}`);
                            } else {
                                _this.clearError("email");
                            }

                            if (errorObj.passwordLength) {
                                _this.step1Register.querySelector('input[id="password"]').classList.add('animate-turnErrorColor');
                                _this.showError("password", `${errorObj.passwordLength}`);
                            } else {
                                _this.clearError("password");
                            }

                            if (errorObj.confirm_password) {
                                _this.step1Register.querySelector('input[id="confirm-password"]').classList.add('animate-turnErrorColor');
                                _this.showError("confirm-password", `${errorObj.confirm_password}`);
                            } else {
                                _this.clearError("confirm-password");
                            }
                            isValid = false;
                        } else {
                            if (isValid) {
                                let finalUsername =  _this.step2Register.querySelector('input[id="final-username"]');
                                finalUsername.value = username;
                                let finalEmail =  _this.step2Register.querySelector('input[id="final-email"]');
                                finalEmail.value = email;
                                let finalPassword =  _this.step2Register.querySelector('input[id="final-password"]');
                                finalPassword.value = password;

                                _this.step1Register.classList.remove('animate-slideLeft');
                                _this.step1Register.classList.add('animate-slideAndFadeOut');

                                setTimeout(function() {
                                    _this.step2Register.classList.remove('hidden');
                                    _this.step2Register.classList.add('animate-slideLeft');
                                }, 1500)
                            }
                        }
                    } catch (error) {
                        console.error('Error validating form:', error);
                    }
                } else {
                    if (_this.toastMessage.classList.contains('animate-toastSlide')) {
                        return;
                    } else { 
                        _this.showToastMessage('Please fill out all information!', 'top-8', '-right-2');
                    }
                }
            });
        }

        if (this.step2Form) {
            this.step2Form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const username = _this.step2Form.querySelector('#final-username').value;
                const email = _this.step2Form.querySelector('#final-email').value;
                const password = _this.step2Form.querySelector('#final-password').value;
                const firstName = _this.step2Form.querySelector('#firstname').value;
                const lastName = _this.step2Form.querySelector('#lastname').value;
                const tagName = _this.step2Form.querySelector('#tagname').value;

                try {
                    const registerResult = await _this.renderer.fetchData('../controllers/register.php', {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ firstName: firstName, lastName: lastName, username: username, tagName: tagName, email: email, password: password })
                    });

                    if (registerResult.error) {
                        console.log(registerResult.error);
                    } else {
                        window.location.href = '../views/login.html.php';
                    }
                } catch (error) {
                    console.error('Error registering user:', error);
                }
            });
        }


        if (this.searchInput) {
            const debouncedSearch = this.debounce(async function() {
                const query = _this.searchInput.value.trim();
        
                if (query.length > 2) {
                    try {
                        const results = await _this.renderer.fetchData(`../controllers/check_searchvalues.php?query=${encodeURIComponent(query)}`);

        
                        _this.searchSuggestions.innerHTML = '';
                        _this.searchSuggestions.classList.remove('hidden');
                        const searchTitle = document.createElement('h4');
                        searchTitle.classList.add('text-sm', 'text-text-light', 'font-medium');
                        _this.searchSuggestions.appendChild(searchTitle);
        
                        console.log(results);
                        results.forEach(result => {
                            const suggestion = document.createElement('div');
                            suggestion.classList.add('py-2', 'px-4', 'text-xl', 'hover:bg-gray-200', 'cursor-pointer');
        
                            if (result.type === 'title') {
                                searchTitle.textContent = `Result by posts' title with your search`;
                                suggestion.innerHTML = `
                                    <span>${result.post_title || query}</span>
                                `;
                            } else if (result.type === 'tag') {
                                searchTitle.textContent = `Result by posts' tag`;
                                suggestion.innerHTML = `
                                    <span>#${result.tag_name || query.slice(1)}</span>
                                `;
                            } else if (result.type === 'user') {
                                searchTitle.textContent = `Result by users' tag name`;
                                suggestion.innerHTML = `
                                    <span>@${result.tag_name || query.slice(1)}</span>
                                `;
                            }

                        
                            suggestion.addEventListener('click', function(e) {
                                const suggestedQuery = e.target.textContent.trim();
                                window.location.href = `main.html.php?page=question&query=${encodeURIComponent(suggestedQuery)}`;
                            });
        
                            _this.searchSuggestions.appendChild(suggestion);
                        });
                    } catch (error) {
                        console.error('Error fetching search results:', error);
                    }
                } else {
                    _this.searchSuggestions.classList.add('hidden');
                }
            }, 500);
        
            this.searchInput.addEventListener('focus', function() {
                _this.searchSuggestions.innerHTML = `
                    <h4 id="search-title" class="text-sm text-text-light font-medium">Several ways to find post:</h4>
                    <hr class="bg-text-light border-text-light mb-4">
                    <div class="text-sm flex flex-col">
                        <span>
                            <b class="text-black">Post title</b>
                            Type anything and results will be displayed
                        </span>
                        <span>
                            <b class="text-black">#example</b>
                            Find post by tags
                        </span>
                        <span>
                            <b class="text-black">@example</b>
                            Find post by users' tag name
                        </span>
                    </div>
                `;
                _this.searchSuggestions.classList.remove('hidden');
            });
        
            this.searchInput.addEventListener('blur', function(e) {
                if (e.target.id !== 'searchInput') {
                    _this.searchSuggestions.innerHTML = '';
                    _this.searchSuggestions.classList.add('hidden');
                }
            });
        
            this.searchInput.addEventListener('input', debouncedSearch);
        
            this.searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const query = _this.searchInput.value.trim();
                    if (query.length > 2) {
                        window.location.href = `main.html.php?page=question&query=${encodeURIComponent(query)}`;
                    }
                }
            });
        
            document.addEventListener('click', function(event) {
                if (!_this.searchInput.contains(event.target) && !_this.searchSuggestions.contains(event.target)) {
                    _this.searchSuggestions.classList.add('hidden');
                }
            });
        }

        if (this.darkModeToggle) {
            this.darkModeToggle.addEventListener('click', function() {
                _this.toggleDarkMode();
            });
        }

        this.applyDarkModePreference();

        if (this.currentURL != 'http://localhost/mywebsite/views/register.html.php' || this.currentURL != 'http://localhost/mywebsite/views/login.html.php') {
            
            // Bật menu
            if (this.menu) {
                this.menuBtn.addEventListener('click', () => {
                    this.menu.classList.add('animate-menuTransition');
                    this.overlay.classList.remove('hidden');
                    this.closeBtn.classList.remove('hidden');
                });
            }

            // Tắt menu
            if (this.closeBtn) {
                this.closeBtn.addEventListener('click', () => {
                    this.menu.classList.add('animate-menuOut');
                    this.menu.classList.remove('animate-menuTransition');
                    this.overlay.classList.add('hidden');
                    this.closeBtn.classList.add('hidden');
                });
            }

            if (this.overlay) {
                this.overlay.addEventListener('click', () => {
                    this.menu.classList.add('animate-menuOut');
                    this.menu.classList.remove('animate-menuTransition');
                    this.overlay.classList.add('hidden');
                    this.closeBtn.classList.add('hidden');
                });
            }

            // Lặp qua các link trong navbar, check xem đang ở trang nào để thêm class tương ứng
            if (this.navbar) {
                const buttons = this.navbar.querySelectorAll('a[id$="btn"]');
                buttons.forEach(link => {
                    link.classList.remove("bg-gray-100");
                    link.classList.remove("dark:bg-gray-600");
                    const theme = localStorage.getItem('darkMode');
                    if (link.href === this.currentURL) {
                        if (theme === 'enabled') {
                            link.classList.add("dark:bg-gray-600");
                        } else {
                            link.classList.add("bg-gray-100");

                        }
                    }
                });
            }

            if (this.userBtn) {
                this.userBtn.addEventListener('click', () => {
                    this.userPopup.classList.toggle('hidden');
                });
            }

            if (this.historySearch) {
                this.historySearch.addEventListener('input', function() {
                    const searchValue = _this.historySearch.value.trim().toLowerCase();
                    _this.historyElement.forEach(history => {
                        if (searchValue === '') {
                            history.classList.remove('hidden');
                            return;
                        }

                        const historyValue = history.querySelector('.history-title').textContent.toLowerCase();
                        if (historyValue.includes(searchValue)) {
                            history.classList.remove('hidden');
                        } else {
                            history.classList.add('hidden');
                        }
                    });
                })


                this.historyElement.forEach(question => {
                    question.addEventListener('click', function(e) {
                        const questionId = question.getAttribute('data-value');
                        window.location.href = `../views/main.html.php?page=postdetails&id=${questionId}`;
                    })
                })
            }

            if (this.userSeach) {
                this.userSeach.addEventListener('input', function() {
                    const userSearch = _this.userSeach.value.trim().toLowerCase();
                    console.log(_this.userElements)
                    _this.userList.forEach(user => {
                        if (userSearch === '') {
                            user.classList.remove('hidden');
                            return;
                        }

                        const userValue = user.querySelector('.user-title').textContent.toLowerCase();
                        if (userValue.includes(userSearch)) {
                            user.classList.remove('hidden');
                        } else {
                            user.classList.add('hidden');
                        }
                    });
                })
            }

            if (this.notifyContainer) {
                const notifyElement = _this.notifyContainer.querySelectorAll('div[class^="notify-"]');
                const clearNotifyButton = document.querySelector('#clear-notify');

                notifyElement.forEach(notify => {
                    notify.addEventListener('click', async function(e) {
                        const notificationId = notify.getAttribute('data-value');
                        try {
                            await _this.renderer.fetchData('../controllers/mark_notification.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ notification_id: notificationId })
                            });

                            // Remove the "new" color from the clicked notification
                            const badge = e.currentTarget.querySelector('.badge');
                            e.currentTarget.removeChild(badge);
                        } catch (error) {
                            console.error('Error marking notification as read:', error);
                        }

                        
                    })
                })

                clearNotifyButton.addEventListener('click', async function() {
                    try {
                        notifyElement.forEach(notify => {
                            notify.classList.remove('animate-slideRight');
                            notify.classList.add('animate-slideAndFadeOut');
                        })

                        await _this.renderer.fetchData('../controllers/delete_all_notification.php', {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ user_id: _this.userId }),
                        })
    
                        setTimeout(function() {
                            const firstChild = _this.notifyContainer.firstChild
                            while (firstChild) {
                                _this.notifyContainer.removeChild(firstChild);
                            }
                        }, 1500)



                    } catch (error) {
                        console.log(error);
                    }
                })
            }

            if (this.notifyPopupContainer) {
                this.notifyBtn.addEventListener('click', () => {
                    this.notifyPopupContainer.classList.toggle('hidden');
                    
                });

                const markAllButton = document.querySelector('#marknotify-btn');
                if (markAllButton) {
                    markAllButton.addEventListener('click', async () => {
                        try {
                            await this.renderer.fetchData('../controllers/mark_all_notifications.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ user_id: this.userId })
                            });

                            const notifications = document.querySelectorAll('#notify-popup a.bg-blue-200');
                            notifications.forEach(notification => {
                                notification.classList.remove('bg-blue-200');
                            });

                            const notifyButton = document.querySelector('#notify-btn');
                            const badge = notifyButton.querySelector('#notify-badge');
                            if (badge) {
                                notifyButton.removeChild(badge);
                            }

                        } catch (error) {
                            console.error('Error marking all notifications as read:', error);
                        }
                    });
                }

                const notificationLinks = document.querySelectorAll('#notify-popup a');
                notificationLinks.forEach(link => {
                    link.addEventListener('click', async (e) => {
                        const notificationId = e.currentTarget.id.split('-')[1];
                        try {
                            await this.renderer.fetchData('../controllers/mark_notification.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ notification_id: notificationId })
                            });

                            // Remove the "new" color from the clicked notification
                            e.currentTarget.classList.remove('bg-blue-200');
                        } catch (error) {
                            console.error('Error marking notification as read:', error);
                        }
                    });
                });
            }

            if (this.questionElement) {
                this.questionElement.forEach(question => {
                    question.addEventListener('click', async function(e) {
                        const postId = question.getAttribute('data-value');
                        const moreButton = question.querySelector('span[id="post-actions"]');
                        const profileShortCut = question.querySelector('img[id="profile-hover"]');
                        const profilePopup = question.querySelector('div[id="profile-popup"]');
                        let button = e.target.closest('button');


                        if (e.target.id == moreButton.id) {
                            const actionPopup = question.querySelector('#action-popup');
                            actionPopup.classList.toggle('hidden');
                            document.addEventListener('click', function(e) {
                                if (!moreButton.contains(e.target) && !actionPopup.contains(e.target)) {
                                    actionPopup.classList.add('hidden');
                                }
                            });
                            return;
                        } else if (e.target.id == profileShortCut.id) {
                            const tagNameValue = profilePopup.querySelector('.tagname').textContent;
                            window.location.href = `main.html.php?page=profile&tag_name=${tagNameValue.slice(1)}`;
                            return;
                        }


                        if (!button) {
                            const tagList = question.querySelectorAll('span[class^="tagname"]')
                            _this.addReadingHistory(postId);
                            _this.addTagsHistory(tagList);
                            _this.incrementViewCounts(postId);
                            window.location.href = `../views/main.html.php?page=postdetails&id=${postId}`;
                        }

                        switch (true) {
                            case button.id == "likes-btn":
                                await _this.handleLikeButtonClick(postId, question);
                                break;
                            case button.id == "comment-btn":
                                console.log('comment');
                                break;
                            case button.id == "save-btn":
                                const savedImage = question.querySelector('.saved-img');
                                _this.handleSavedPosts(postId, savedImage);
                                break;
                            case button.id == "link-btn":
                                await _this.handleCopyLink(postId);
                                break;
                            case button.id == "view-btn":
                                window.location.href = `../views/main.html.php?page=postdetails&id=${postId}`;
                                break;
                            case button.id == "edit-btn":
                                sessionStorage.setItem('editPostId', postId);
                                window.location.href = '../views/main.html.php?page=editpost';
                                break;
                        }
                    });
                });

                this.questionElement.forEach(question => {
                    const postId = question.getAttribute('data-value');
                    this.updateLikeCount(postId, question);
                    this.updateCommentCount(postId, question);
                });
            }

            if (this.tagElements) {
                this.tagElements.forEach(element => {
                    element.addEventListener('click', function() {
                        const tagValue = element.querySelector('span[id^="tagname-"]').textContent;
                        window.location.href = `main.html.php?page=question&query=${encodeURIComponent(tagValue)}`;
                    })
                })
            }

            if (this.tagContainer) {
                this.tagSearch.addEventListener('input', function() {
                    const inputValue = _this.tagSearch.value.trim().toLowerCase();
                    _this.tagElements.forEach(tag => {
                        if (inputValue === '') {
                            tag.classList.remove('hidden');
                            return;
                        }

                        const tagValue = tag.querySelector('span[id^="tagname-"]').textContent.toLowerCase();
                        if (tagValue.includes(inputValue)) {
                            tag.classList.remove('hidden');
                        } else {
                            tag.classList.add('hidden');
                        }
                    });
                });
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

            if (this.savedPostSearch) {
                this.savedPostSearch.addEventListener('input', function() {
                    const savedValue = _this.savedPostSearch.value.trim().toLowerCase();
                    _this.questionElement.forEach(savedPost => {
                        if (savedValue === '') {
                            savedPost.classList.remove('hidden');
                            return;
                        }

                        const questionValue = savedPost.querySelector('.question-title').textContent.toLowerCase();
                        if (questionValue.includes(savedValue)) {
                            savedPost.classList.remove('hidden');
                        } else {
                            savedPost.classList.add('hidden');
                        }
                    });
                })
            }

            if (this.postDetailContainer) {
                this.postDetailContainer.addEventListener('click', async function(e) {
                    const postId = _this.postDetailContainer.getAttribute('data-value');
                    let button = e.target.closest('button');

                    if (!button) {
                        return;
                    }

                    switch(true) {
                        case button.id == "like-btn":
                            await _this.handleLikeButtonClick(postId, _this.postDetailContainer);
                            break;
                        case button.id == "edit-btn":
                            sessionStorage.setItem('editPostId', postId);
                            window.location.href = '../views/main.html.php?page=editpost';
                            break;
                        case button.id == "save-btn":
                            const savedImage = _this.postDetailContainer.querySelector('.saved-img');
                            _this.handleSavedPosts(postId, savedImage);
                            break;
                        case button.id == "link-btn":
                            console.log('link-btn');
                            break;
                        default:
                            break;

                    }
                })

                this.debounce(setTimeout(function() {
                    const commentContainer = document.querySelector('div[id^="comment-container-"]');
                    const commentElements = commentContainer.querySelectorAll('div[id^="comment-"]')

                    commentElements.forEach(comment => {
                        comment.addEventListener('click', function(e) {
                            if (e.target.closest('span[class^="edit-comment-btn"]')) {
                                const commentInformation = comment.querySelector('#comment-information');
                                const iconElement = comment.querySelector('span[class^="edit-comment-btn"]')
                                _this.handleEditComment(iconElement, commentInformation, comment)
                                
                            } else if (e.target.closest('span[class^="delete-comment-btn"]')) {
                                _this.handleDeleteComement(commentContainer, comment);
                            }
                        })
                    })
                }, 100))

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
                        console.log(newComment.error);
                    } else {
                        const commentContainer = document.querySelector('div[id^="comment-container-"]');
        
                        _this.renderedComments.add(newComment.comment_id); // Add the comment ID to the Set
                        textarea.value = '';
                        document.querySelector('.comment-count').textContent = `(${_this.renderedComments.size})`;

                        const receiverId = document.querySelector('img[id^="user-avatar"]').getAttribute('data-value');
                        const avatar = `${_this.avatar || '../assets/images/user.png'}`;
                        const messageNotify = `has commented on your post!`;
                        const urlNotify = `../views/main.html.php?page=postdetails&id=${postId}`;
                        const createdTime = new Date();
            
                        setTimeout(async function() {
                            if (receiverId != _this.userId) {
                                await _this.renderer.fetchData('../controllers/add_notifications.php', {
                                    method: "POST",
                                    headers: { "Content-Type": "application/json" },
                                    body: JSON.stringify({ receiverId: receiverId, senderId: _this.userId, type: 'comment', message: messageNotify, url: urlNotify })
                                });

                                _this.sendNotification(receiverId, _this.username, avatar, _this.userId, 'comment', messageNotify, newComment.content, urlNotify, createdTime);
                            } 
                        }, 100);

                        _this.socket.send(JSON.stringify({
                            type: "comment",
                            commentId: newComment.comment_id,
                            postId: commentContainer.getAttribute('data-post-id'),
                            userId: newComment.user_id,
                            username: newComment.username,
                            avatar: newComment.avatar,
                            createdTime: new Date(newComment.created_at).toISOString(),
                            comment: newComment.content,
                            commentCount: _this.renderedComments.size
                        }));
                    } 
                });
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
                    
                    // Clear the tag list to prevent duplication
                    _this.tagList.innerHTML = '';
        
                    setTimeout(function() {
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
                                console.log(data);
                                _this.tagList.innerHTML = '';
    
                                if (selectedValue == '') {
                                    _this.tagList.classList.add('hidden');
                                    _this.buttonContainer.classList.add('hidden');
                                    _this.tagInput.classList.add('hidden');
                                } else {
                                    _this.tagList.classList.remove('hidden');
                                    _this.buttonContainer.classList.remove('hidden');
                                    _this.tagInput.classList.remove('hidden');
                                    data.forEach(tag => {
                                        console.log('done')
                                        const tagElement = document.createElement('option');
                                        tagElement.classList.add('dark:text-gray-400', 'dark:bg-gray-900')
                                        tagElement.value = `${tag.tag_name}`;
                                        tagElement.textContent = `${tag.tag_name}`;
                                        _this.tagList.appendChild(tagElement);
                                    })
                                }
                            }
                        })
                    }, 100)
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
    
                try {
                    const userIdValue = this.profileActions.getAttribute('data-value');
    
                    if (this.userId == userIdValue) {
                        editButton.classList.remove('hidden');
                        this.profileActions.removeChild(followButton);

                        editButton.addEventListener('click', function() {
                            window.location.href = '../views/main.html.php?page=editprofile'
                        })
                    } else {
                        followButton.classList.remove('hidden');
                        this.profileActions.removeChild(editButton);
    
                        // Check follow status
                        fetch(`../controllers/check_follow_status.php?follower_id=${this.userId}&following_id=${userIdValue}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.is_following) {
                                    followButton.textContent = 'Unfollow';
                                } else {
                                    followButton.textContent = 'Follow';
                                }
                            })
                            .catch(error => console.error('Error checking follow status:', error));
    
                        followButton.addEventListener('click', async function() {
                            try {
                                const followResult = await _this.renderer.fetchData('../controllers/follow_user.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ follower_id: _this.userId, following_id: userIdValue })
                                });
    
                                if (followResult.status === 'followed') {
                                    followButton.textContent = 'Unfollow';
                                    const followerCount = document.getElementById('follower-count');
                                    followerCount.textContent = parseInt(followerCount.textContent) + 1;

                                    // Send notification to the followed user
                                    const avatar = `${_this.avatar || '../assets/images/user.png'}`;
                                    const messageNotify = `has started following you!`;
                                    const urlNotify = `../views/main.html.php?page=profile&tag_name=${_this.tagName}`;
                                    const createdTime = new Date();

                                    await _this.renderer.fetchData('../controllers/add_notifications.php', {
                                        method: "POST",
                                        headers: { "Content-Type": "application/json" },
                                        body: JSON.stringify({ receiverId: userIdValue, senderId: _this.userId, type: 'follow', message: messageNotify, url: urlNotify })
                                    });

                                    _this.sendNotification(userIdValue, _this.username, avatar, _this.userId, 'follow', messageNotify, '', urlNotify, createdTime);
                                } else if (followResult.status === 'unfollowed') {
                                    followButton.textContent = 'Follow';
                                    const followerCount = document.getElementById('follower-count');
                                    followerCount.textContent = parseInt(followerCount.textContent) - 1;
                                }
                            } catch (error) {
                                console.error('Error following/unfollowing user:', error);
                            }
                        });
                    }
                } catch (error) {
                    console.log(error);
                }
            }
            

            if (this.userContainer && this.userList) {
                this.userList.forEach(user => {
                    const userTagName = user.querySelector('h3[id^="user-tagname"]')
                    user.addEventListener('click', function() {
                        window.location.href = `main.html.php?page=profile&tag_name=${userTagName.textContent}`;
                    })
                })
            }

            // Check khi click ra ngoài các menu & popup
            document.addEventListener('click', (event) => {
                if (this.userBtn && this.notifyBtn) {
                    if (!this.userBtn.contains(event.target) && !this.userPopup.contains(event.target)) {
                        this.userPopup.classList.add('hidden');
                    }
    
                    if (!this.notifyBtn.contains(event.target) && !this.notifyBtn.contains(event.target)) {
                        this.notifyPopupContainer.classList.add('hidden');
                    }
                }
            });
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
                savedImage.classList.add('filled-icon');
            } else {
                console.log(savedPosts)
                console.log('unsave');
                savedImage.classList.remove('filled-icon');
            }
        } catch (error) {
            console.error('Error handling saved post:', error);
        }
    }

    async handleLikeButtonClick(postId, question) {
        const likeImage = question.querySelector('.like-img');
        const likeCountSpan = question.querySelector(`.like-count-${postId}`);
        const receiverId = question.querySelector('img[class^="user-"]').getAttribute('data-value');
        const avatar = `${this.avatar || '../assets/images/user.png'}`;
        const messageNotify = `has liked your post!`;
        const content = `Check it out`;
        const urlNotify = `../views/main.html.php?page=postdetails&id=${postId}`;
        const createdTime = new Date();

    
        console.log(likeCountSpan)

        // Handle the like action
        await this.handleLikes(postId, likeCountSpan, likeImage);
    
        // Send notification if the post is liked and the receiver is not the current user
        if (likeImage.classList.contains('filled-icon') && receiverId != this.userId) {
            try {
                await this.renderer.fetchData('../controllers/add_notifications.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ receiverId: receiverId, senderId: this.userId, type: 'like', message: messageNotify, url: urlNotify })
                });
    
                this.sendNotification(receiverId, this.username, avatar, this.userId, 'like', messageNotify, content, urlNotify, createdTime);
            } catch (error) {
                console.error('Error sending like notification:', error);
            }
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
                likeImage.classList.add('filled-icon');
                likeCountSpan.textContent = parseInt(likeCountSpan.textContent) + 1;
            } else {
                likeImage.classList.remove('filled-icon');
                likeCountSpan.textContent = parseInt(likeCountSpan.textContent) - 1;
            }


            this.socket.send(JSON.stringify({
                type: "like",
                postId: postId,
                likes: likeCountSpan.textContent
            }));
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
        }
    }

    async handleEditComment(icon, container, commentElement) {
        if (icon.innerText == 'edit') {
            const commentContent = commentElement.querySelector('p[class^="comment-content-"]')

            const commentInput = document.createElement('input');
            commentInput.id = 'comment-input';
            commentInput.type = 'text';
            commentInput.classList.add('border-1', 'border-gray-400', 'text-gray-400', 'rounded-md', 'p-2')
            commentInput.value = commentContent.textContent;


            container.replaceChild(commentInput, commentContent);
            icon.textContent = 'check';
        } else {
            const commentValue = commentElement.getAttribute('data-value');
            const inputValue = commentElement.querySelector('input[id="comment-input"]');
            const newComment = document.createElement('p');
            newComment.classList.add(`comment-content-${commentValue}`, 'text-sm', 'dark:text-gray-400');
            newComment.textContent = inputValue.value;

            container.replaceChild(newComment, inputValue);
            icon.textContent = 'edit';

            console.log(commentValue, newComment.textContent);

            await this.renderer.fetchData('../controllers/edit_comment.php', {
                method: "POST",
                headers: { "Content-Type" : "application/json" },
                body: JSON.stringify({ comment_id: commentValue, newComment: encodeURIComponent(newComment.textContent)})
            });
        }
    }

    async handleDeleteComement(commentContainer, commentElement) {
        const commentValue = commentElement.getAttribute('data-value');
        commentElement.classList.remove('animate-slideRight');
        commentElement.classList.add('animate-slideAndFadeOut');


        await this.renderer.fetchData('../controllers/delete_comment.php', {
            method: "POST",
            headers: { "Content-Type" : "application/json" },
            body: JSON.stringify({ comment_id: commentValue })
        })

        setTimeout(function() {
            commentContainer.removeChild(commentElement);
        }, 1500)



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
                const commentContainer = document.querySelector('div[id^="comment-container-"]');
                const firstChildElement = commentContainer.firstElementChild;
                comments.forEach(comment => {
                    if (!this.renderedComments.has(comment.comment_id)) {
                        const commentElement = document.createElement('div');
                        commentElement.id = `comment-${comment.comment_id}`;
                        commentElement.setAttribute('data-value', `${comment.comment_id}`);
                        commentElement.classList.add('bg-[#F1F1F1]', 'flex', 'p-4', 'space-x-4', 'rounded-md', 'dark:bg-gray-700' ,'animate-slideRight');
                        commentElement.innerHTML = `
                            <img src="${comment.avatar ?? '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                            <div id="comment-information">
                                <div class="flex items-center space-x-2">
                                    <h2 class="font-medium text-md dark:text-white">${comment.username}</h2>
                                    <span class="text-xs dark:text-gray-400">${this.renderer.timeAgo(comment.created_at)}</span>
                                </div>
                                <p class="comment-content-${comment.comment_id} text-sm dark:text-gray-400">${comment.content}</p>
                            </div>
                        `;

                        if (this.userId == comment.user_id) {
                            const actionButton = document.createElement('div')
                            actionButton.classList.add('flex', 'text-3xl', 'font-light', 'dark:text-gray-400', 'ml-auto', 'my-auto', 'text-center', 'space-x-2');
                            actionButton.innerHTML = `
                                <span class="edit-comment-btn material-symbols-rounded custom-icon text-center rounded-full p-2 hover:bg-gray-200 dark:hover:bg-gray-900 cursor-pointer active:scale-90">
                                    edit
                                </span>
                                <span class="delete-comment-btn material-symbols-rounded custom-icon text-center rounded-full p-2 text-red-500 hover:bg-red-100 dark:hover:bg-red-200 cursor-pointer active:scale-90">
                                    delete
                                </span>
                                
                            `;

                            commentElement.appendChild(actionButton);
                        }


                        commentContainer.insertBefore(commentElement, firstChildElement);
                        this.renderedComments.add(comment.comment_id); // Thêm comment ID vừa post vào Set
                    }
                });
                document.querySelector('.comment-count').textContent = `(${this.renderedComments.size})`;
                
            }
        } catch (error) {
            console.error('Error updating comments:', error);
        }
    }

    async handleCopyLink(postId) {
        try {
            const postLink = `${window.location.origin}/mywebsite/views/main.html.php?page=postdetails&id=${postId}`;
            await navigator.clipboard.writeText(postLink);

            // Show a success message
            console.log(`Link copied to clipboard: ${postLink}`);
            this.showToastMessage('Link copied to clipboard!', 'top-28', '-right-2');
        } catch (error) {
            console.error('Error copying link:', error);
        }
    }

    async addTagsHistory(tagName) {
        tagName.forEach(async tag => {
            try {
                await this.renderer.fetchData('../controllers/update_tags_history.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: this.userId, tag_name: tag.textContent.slice(1) })
                });
            } catch (error) {
                console.error('Error updating reading history:', error);
            }
        })
    }

    showToastMessage(message, x, y) {
        const toast = document.querySelector('#toast');
        if (toast) {
            toast.classList.remove('animate-toastSlideOut');
            toast.classList.add('animate-toastSlide');

            setTimeout(() => {
                toast.classList.remove('animate-toastSlide');
                toast.classList.add('animate-toastSlideOut')
            }, 3000);
        } else {
            const toast = document.createElement('div');
            toast.classList.add('fixed', x, y, 'z-50', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'text-text', 'dark:bg-gray-800', 'border-2', 'border-[#3ea29a]', 'bg-white', 'animate-toastSlide');
            toast.id = 'toast';
            toast.innerHTML = `
                <div class="inline-flex items-center justify-center text-3xl shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">

                    <span class="material-symbols-rounded custom-icon">
                        priority_high
                    </span>
                </div>
                <div id="toast-message" class="ms-3 text-sm font-normal dark:text-gray-400">${message}</div>
            
            `;

            document.body.appendChild(toast); 

            setTimeout(() => {
                toast.classList.remove('animate-toastSlide');
                toast.classList.add('animate-toastSlideOut')
            }, 3000);
        }        
    }

    validateLogin(username, password, isValid) {
        if (username === "") {
            this.loginForm.querySelector('input[id="username"]').classList.add('animate-turnErrorColor');
            this.showError("username", "Username missing.");
            isValid = false;
        } else {
            this.loginForm.querySelector('input[id="username"]').classList.remove('animate-turnErrorColor');
            this.clearError("username");
        }


        if (password === "") {
            this.loginForm.querySelector('input[id="password"]').classList.add('animate-turnErrorColor');
            this.showError("password", "Password missing.");
            isValid = false;
        } else {
            this.loginForm.querySelector('input[id="password"]').classList.remove('animate-turnErrorColor');
            this.clearError("password");
        }
    }

    validateRegister(username, email, password, confirmPassword, isValid) {
        if (username === "") {
            this.step1Register.querySelector('input[id="username"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            this.step1Register.querySelector('input[id="username"]').classList.remove('animate-turnErrorColor');
        }

        if (email === "") {
            this.step1Register.querySelector('input[id="email"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            this.step1Register.querySelector('input[id="email"]').classList.remove('animate-turnErrorColor');
        }

        if (password === "") {
            this.step1Register.querySelector('input[id="password"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            this.step1Register.querySelector('input[id="password"]').classList.remove('animate-turnErrorColor');
        }

        if (confirmPassword === "") {
            this.step1Register.querySelector('input[id="confirm-password"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            this.step1Register.querySelector('input[id="confirm-password"]').classList.remove('animate-turnErrorColor');
        }
    }

    escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
    }

    // Hàm hiển thị lỗi
    showError(inputId, message) {
        let inputElement = document.getElementById(inputId);
        let errorElement = inputElement.nextElementSibling; // Lấy <span> kế bên
        errorElement.innerText = message;
        errorElement.style.color = "red";
    }

    // Hàm xóa lỗi
    clearError(inputId) {
        let inputElement = document.getElementById(inputId);
        let errorElement = inputElement.nextElementSibling;
        errorElement.innerText = "";
    }

    

    debounce(fn, ms) {
        let timer;
        
        return function() {
            // Nhận các đối số
            const args = arguments;
            const context = this;
            
            if(timer) clearTimeout(timer);
            
            timer = setTimeout(() => {
                fn.apply(context, args);
            }, ms)
        }
    }

    async toggleDarkMode() {
        const isDarkMode = document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');

        // Save the preference to the server
        await this.renderer.fetchData('../controllers/update_darkmode.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: this.userId, dark_mode: isDarkMode ? 1 : 0 })
        })
        
    }

    async applyDarkModePreference() {
        try {
            const response = await fetch(`../controllers/get_darkmode.php?user_id=${this.userId}`);
            const data = await response.json();
            const darkMode = data.dark_mode;

            if (darkMode === '1') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('darkMode', 'disabled');
            }
        } catch (error) {
            console.error('Error fetching dark mode preference:', error);
        }
    }

    async addReadingHistory(postId) {
        try {
            await this.renderer.fetchData('../controllers/add_reading_history.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: this.userId, post_id: postId })
            });
        } catch (error) {
            console.error('Error adding reading history:', error);
        }
    }

    async incrementViewCounts(postId) {
        try {
            await this.renderer.fetchData('../controllers/increment_view.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: this.userId, post_id: postId })
            });
        } catch (error) {
            console.error('Error adding reading history:', error);
        }
    }

    sendNotification(userId, username, avatar, senderId, type, message, content, url, createdTime) {
        console.log('sendNotification called with:', { userId, username, avatar, senderId, type, message, content, url, createdTime });
    
        const conditions = userId && senderId && type && message && url && createdTime;
        if (conditions) {
            let notificationData = {
                type: "notification",
                user_id: userId,
                username: username,
                avatar: avatar,
                senderId: senderId,
                notification_type: type,
                message: message,
                content: content,
                url: url,
                createdTime: new Date(createdTime).toISOString(),
            };
    
            this.socket.send(JSON.stringify(notificationData));
            console.log('Notification sent:', notificationData);
        } else {
            console.error('sendNotification conditions not met:', { userId, senderId, type, message, content, url, createdTime });
        }
    }

    updateNotificationBadge() {
        const notifyBadge = document.querySelector('#notify-badge');
        if (notifyBadge) {
            notifyBadge.textContent = parseInt(notifyBadge.textContent) + 1;
            notifyBadge.classList.remove('hidden');
        } else {
            const newBadge = document.createElement('span');
            newBadge.id = 'notify-badge';
            newBadge.classList.add('absolute', 'text-xs', '-top-1', '-right-1', 'px-2', 'bg-red-500', 'rounded-full', 'text-white');
            newBadge.textContent = '1';
            this.notifyBtn.appendChild(newBadge);
        }
    }
    
    
    start() {
        this.handleEvents();

        // Apply dark mode preference on page load
        this.applyDarkModePreference();

        const postId = this.postDetailContainer ? this.postDetailContainer.getAttribute('data-value') : null;
        if (postId) {
            this.updateComments(postId);
        }
        
    }
}

// Export the class
export default EventListener;