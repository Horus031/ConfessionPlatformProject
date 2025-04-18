import QuestionRenderer from "../js/render.js";
import culori from "./culori.js";
class EventListener {
    constructor() {
        this.renderer = new QuestionRenderer();
        this.currentURL = window.location.href;
        this.renderedComments = new Set(); // Tạo Set lưu trữ các id của comment
        this.loadingOverlay = document.querySelector('#loading-overlay');
        this.popupModal = document.querySelector('#popup-modal');

        console.log(culori);
        if (this.currentURL.includes('main.html.php')) {
            this.initSessionData().then(() => {
                this.socket = new WebSocket(`ws://localhost:8080?user_id=${this.userId}`);
    
                this.socket.onopen = function() {
                    console.log("WebSocket connected!");
                }.bind(this);
    
                this.socket.onmessage = (event) => {
                    const data = JSON.parse(event.data);
    
                    if (data.type === "like") {
                        const likeCountSpan = document.querySelector(`.like-count-${data.postId}`);
                        if (likeCountSpan) {
                            likeCountSpan.innerText = data.likesCount;
                        }
                    }
    
                    if (data.type === "comment") {
                        const commentCountSpan = document.querySelector(`.comment-count-${data.postId}`);
                        if (commentCountSpan) {
                            commentCountSpan.innerText = data.commentCount;
                        }
    
                        let commentSection = document.querySelector(`div[id^="comment-container-"]`);
                        if (commentSection) {
                            let firstChildComment = commentSection.firstElementChild;
    
                            // Update the badge only if the comment is not from the current user
                            if (parseInt(data.userId) != this.userId) {
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
                                        <h2 class="text-text font-medium text-md dark:text-white">${data.username}</h2>
                                        <span class="text-xs dark:text-gray-400">${this.renderer.timeAgo(localTime)}</span>
                                    </div>
                                    <p class="text-text text-sm dark:text-gray-400">${data.comment}</p>
                                </div>
                            `;
    
                            commentSection.insertBefore(newCommentElement, firstChildComment);
    
                            document.querySelector('.comment-count').textContent = `(${commentSection.children.length})`;
                        }
                    }
    
                    if (data.type === "notification") {
    
                        const notifyContainer = document.querySelector('#notify-popup');

                        const notifyFirstChild = notifyContainer.firstElementChild;
    
                        // Convert UTC time to local time
                        const localTime = new Date(data.created_at);
    
                        const notifyElement = document.createElement('a');
                        notifyElement.classList.add('flex', 'justify-between', 'px-2', 'text-left', 'space-x-2', 'hover:bg-gray-200', 'cursor-pointer', 'bg-blue-200', 'dark:bg-gray-200', 'dark:hover:bg-gray-700');
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

                        if (notifyFirstChild.id == 'no-notify') {
                            notifyContainer.removeChild(notifyFirstChild);
                            notifyContainer.appendChild(notifyElement);
                        } else {
                            notifyContainer.insertBefore(notifyElement, notifyFirstChild);
                        }
    
                    }
    
                    if (data.type === "new_post") {
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
                                    <span>${data.username} has shared a new post</span>
    
                                    <span class="text-text-light break-all line-clamp-1">${data.title || 'Check it out!'}</span>
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
            });
        }
    }

    async initSessionData() {
        try {
            // Fetch session data from the server
            const sessionData = await this.renderer.fetchData('../controllers/session_data.php');
    
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

    initElements() {
        this.searchInput = document.getElementById('searchInput');
        this.searchSuggestions = document.getElementById('searchSuggestions');
        this.registerNextButton = document.querySelector('#registerNextBtn');
        this.step1Register = document.querySelector('#step1-container');
        this.step2Register = document.querySelector('#step2-container');
        this.step2Form = document.querySelector('#step2-form');
        this.editUserForm = document.querySelector('#edit-form');
        this.editPostForm = document.querySelector('#edit-post-form');
        this.contactForm = document.querySelector('#contactForm');
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
        this.historyContainer = document.querySelector('#history-container');
        this.historySearch = document.querySelector('#history-search');
        this.userSeach = document.querySelector('#user-search')
        this.filterTags = document.querySelector('#filter-tags');
        this.tagContainer = document.querySelector('#tags-container');
        this.tagElements = document.querySelectorAll('div[id^="tag-"]');
        this.postForm = document.querySelector('#post-form');
        this.postDetailContainer = document.querySelector('#postdetail-container');
        this.newPostForm = document.querySelector('#newpost-form')
        this.tagSearch = document.querySelector('#tag-search');
        this.questionFilter = document.querySelector('#question-filter');
        this.profileActions = document.querySelector('#profile-actions');
        this.userContainer = document.querySelector('#users-container');
        this.myPostContainer = document.querySelector('#mypost-container');
        if (this.userContainer) {
            this.userList = this.userContainer.querySelectorAll('div[id^=user-]')
        }
        this.darkModeToggle = document.querySelector('#darkmode-btn');
        this.infoContainer = document.querySelector('#info-container');
    }

    initAdminElements() {
        this.sectionContainer = document.querySelector('#section-container');
        this.sectionChild = this.sectionContainer.children;
        this.backHomeBtn = document.querySelector('#backToHome');
        this.addUserBtn = document.querySelector('#adduser-btn');
        this.adminMenu = document.querySelector('#admin-menu');
        this.userManagement = document.querySelector('#user-management');
        this.moduleManagement = document.querySelector('#module-management');
        this.moduleContainer = document.querySelector('#module-container');
        this.addNewModuleContainer = document.querySelector('#new-module')
        this.addModuleForm = document.querySelector('#create-module-form');
        this.editModuleContainer = document.querySelector('#edit-module');
        this.editModuleForm = document.querySelector('#edit-module-form');
        this.newUserContainer = document.querySelector('#new-user');
        this.editUserContainer = document.querySelector('#edit-user');
        this.questionManagement = document.querySelector('#question-management');
        this.editQuestionContainer = document.querySelector('#edit-question');
        this.createUserForm = document.querySelector('#create-user-form');
        this.cancelCreateUsers = document.querySelector('#cancel-create');
        this.userTab = document.querySelector('#user-tab');
        this.questionTab = document.querySelector('#question-tab');
        this.moduleTab = document.querySelector('#module-tab');
        this.userContainer = document.querySelector('#user-container')
        this.userActions = document.querySelector('#user-actions');
        this.userSearch = document.querySelector('#user-search');
        this.questionContainer = document.querySelector('#question-container');
        this.toastMessage = document.querySelector('#toast');
        this.adminEditForm = document.querySelector('#admin-edit');
        this.adminEditPostForm = document.querySelector('#admin-edit-post');

    }

    handleEvents() {
        const _this = this;
        this.initElements();
        
        console.log('main')

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

                _this.validateRegister(_this.step1Register, username, email, password, confirmPassword, isValid);

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
            this.step2Form.addEventListener('submit', async function (e) {
            e.preventDefault();
        
            const username = _this.step2Form.querySelector('#final-username').value;
            const email = _this.step2Form.querySelector('#final-email').value;
            const password = _this.step2Form.querySelector('#final-password').value;
            const firstName = _this.step2Form.querySelector('#firstname').value;
            const lastName = _this.step2Form.querySelector('#lastname').value;
            const tagName = _this.step2Form.querySelector('#tagname').value;
            let isValid = true;

            // Validation for firstName
            if (firstName == "") {
                _this.step2Form.querySelector('input[id="firstname"]').classList.add('animate-turnErrorColor');
                _this.showError("firstname", "First name is required.");
                isValid = false;
            } else {
                _this.step2Form.querySelector('input[id="firstname"]').classList.remove('animate-turnErrorColor');
                _this.clearError("firstname");
            }

            // Validation for lastName
            if (lastName == "") {
                _this.step2Form.querySelector('input[id="lastname"]').classList.add('animate-turnErrorColor');
                _this.showError("lastname", "Last name is required.");
                isValid = false;
            } else {
                _this.step2Form.querySelector('input[id="lastname"]').classList.remove('animate-turnErrorColor');
                _this.clearError("lastname");
            }
        
            // Validation for tagName
            if (tagName == "") {
                _this.step2Form.querySelector('input[id="tagname"]').classList.add('animate-turnErrorColor');
                _this.showError("tagname", "Tag name is required.");
                isValid = false;
            } else {
                try {
                const tagCheckResult = await _this.renderer.fetchData('../controllers/check_tagname.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ tagName: tagName })
                });
        
                if (tagCheckResult.exists) {
                    _this.step2Form.querySelector('input[id="tagname"]').classList.add('animate-turnErrorColor');
                    _this.showError("tagname", "Tag name is already taken.");
                    isValid = false;
                } else {
                    _this.step2Form.querySelector('input[id="tagname"]').classList.remove('animate-turnErrorColor');
                    _this.clearError("tagname");
                }
                } catch (error) {
                console.error('Error checking tag name:', error);
                isValid = false;
                }
            }
        
            // Proceed if all validations pass
            if (isValid) {
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
            }
            });
        }


        if (this.searchInput) {
            _this.searchSuggestions.classList.add('bg-white', 'dark:bg-gray-800', 'border-0')
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
                    <h4 id="search-title" class="text-sm text-text dark:text-gray-400 font-medium">Several ways to find post:</h4>
                    <hr class="bg-text-light border-gray-400 mb-4">
                    <div class="text-sm flex flex-col">
                        <span class="text-black dark:text-gray-400">
                            <span class="font-semibold text-black dark:text-white">Post title</span>
                            Type anything and results will be displayed
                        </span>
                        <span class="text-black dark:text-gray-400">
                            <span class="font-semibold text-black dark:text-white">#example</span>
                            Find post by tags
                        </span>
                        <span class="text-black dark:text-gray-400">
                            <span class="font-semibold text-black dark:text-white">@example</span>
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
                    link.classList.remove("bg-gray-300");
                    link.classList.remove("dark:bg-gray-600");
                    const theme = localStorage.getItem('darkMode');
                    if (link.href === this.currentURL) {
                        if (theme === 'enabled') {
                            link.classList.add("dark:bg-gray-600");
                        } else {
                            link.classList.add("bg-gray-300");

                        }
                    }
                });
            }

            if (this.userBtn) {
                this.userBtn.addEventListener('click', () => {
                    this.userPopup.classList.toggle('hidden');
                });
            }

            if (this.userPopup) {
                const profileLink = this.userPopup.firstElementChild;
                const adminPopup = document.createElement('a');
                adminPopup.href = `main.html.php?page=admin`
                adminPopup.classList.add('flex', 'items-center', 'rounded-md', 'text-3xl', 'font-light', 'text-text','space-x-4', 'p-3', 'hover:bg-gray-200', 'cursor-pointer', 'dark:text-gray-400');
                adminPopup.innerHTML = `
                        <span class="material-symbols-rounded custom-icon">shield_person</span>
                        <span class=" text-lg font-normal">Enter Admin Mode</span>
                `;

                if (this.roleId == 2) {
                    this.userPopup.insertBefore(adminPopup, profileLink.nextSibling);
                }
                
            }

            if (this.editPostForm) {
                this.editPostForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const postTitle = _this.editPostForm.querySelector('#title');
                    const postContent = _this.editPostForm.querySelector('#content');

                    if (postTitle.value == '' && postContent.value == '') {
                        _this.showError('title', 'Title is required');
                        _this.showError('content', 'Content is required');
                        return;
                    }

                    if (postTitle.value == '') {
                        _this.clearError('content')
                        _this.showError('title', 'Title is required');
                        return;
                    }

                    if (postContent.value == '') {
                        _this.clearError('title')
                        _this.showError('content', 'Content is required');
                        return;
                    }


                    _this.clearError('title')
                    _this.clearError('content')

                    const formData = new FormData(_this.editPostForm);

                    formData.set('currentURL', window.location.href);

                    try {
                        _this.loadingOverlay.classList.remove('hidden');

                        const response = await _this.renderer.fetchData('../controllers/editpost.php', {
                            method: 'POST',
                            body: formData
                        })

                        if (response['user']) {
                            window.location.href = `../views/main.html.php`;
                        }
                    } catch (error) {
                        console.error(error);
                    } finally {
                        _this.loadingOverlay.classList.add('hidden');
                    }
                })
            }

            if (this.contactForm) {
                this.contactForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);
                    const formFeedback = document.querySelector('#formFeedback');

                    try {
                        _this.loadingOverlay.classList.remove('hidden');


                        const response = await _this.renderer.fetchData('../controllers/send_message.php', {
                            method: 'POST',
                            body: formData
                        })

                        const result = typeof response === 'string' ? JSON.parse(response) : response;
                        try {
                            if (result.success) {
                                formFeedback.textContent = 'Message sent successfully! Thank you for contacting us.';
                                formFeedback.classList.add('text-green-500');
                                form.reset();

                                setTimeout(function() {
                                    formFeedback.textContent = '';
                                }, 3000)
                            } else {
                                formFeedback.textContent = 'Failed to send message. Please try again.';
                                formFeedback.classList.add('text-red-500');

                                setTimeout(function() {
                                    formFeedback.textContent = '';
                                }, 3000)
                            }
                        } catch (error) {
                            console.error('Invalid JSON response:', result);
                            formFeedback.textContent = 'An error occurred. Please try again.';
                            formFeedback.classList.add('text-red-500');
                        }

                    } catch (error) {
                        console.log(error);
                        formFeedback.textContent = 'An error occurred. Please try again.';
                        formFeedback.classList.add('text-red-500');
                    } finally {
                        _this.loadingOverlay.classList.add('hidden');
                    }
                })
            }

           if (this.editUserForm) {
                const tagNameValue = document.querySelector('input[id="edit-tagname"]');

                this.editUserForm.addEventListener('click', function(e) {
                    if (e.target.closest('button[id^="cancel-"]')) {
                        window.location.href = `../views/main.html.php?page=profile&tag_name=${tagNameValue.value}`;
                    }
                })

                this.editUserForm.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(_this.editUserForm);
            
                        // Define the desired order of social links
                        const socialLinkOrder = ['Facebook', 'Github', 'LinkedIn'];
            
                        // Combine social_links into an object with keys as names
                        const socialLinks = {};
                        socialLinkOrder.forEach(key => {
                            const value = formData.get(`social_links[${key}]`);
                            socialLinks[key] = value || '';
                        });
            
                        // Add the social_links object as a JSON string to FormData
                        formData.set('social_links', JSON.stringify(socialLinks));
            
                        formData.set('currentURL', window.location.href);
            
                    
                        try {
                            _this.loadingOverlay.classList.remove('hidden');

                            const response = await _this.renderer.fetchData('../controllers/edit_userinfo.php', {
                                method: 'POST',
                                body: formData
                            })
    
                            if (response['user']) {
                                window.location.href = `../views/main.html.php?page=profile&tag_name=${tagNameValue.value}`;
                            }
                        } catch (error) {
                            console.error(error);
                        } finally {
                            _this.loadingOverlay.classList.add('hidden');
                        }
                })
            }

            if (this.historyContainer) {
                this.historySearch.addEventListener('input', function() {
                    const searchValue = _this.historySearch.value.trim().toLowerCase();
                    const historyByDate = _this.historyContainer.querySelectorAll('div[id^="elements-"]');

                    historyByDate.forEach(element => {
                        const historyElement = element.querySelectorAll('div[class^="history-element"]');

                        historyElement.forEach(history => {
                            if (searchValue === '') {
                                history.classList.remove('hidden');
                                return;
                            }

                            const historyValue = history.querySelector('h2[class^="history-title"]').textContent.toLowerCase();
                            if (historyValue.includes(searchValue)) {
                                element.querySelector('h2[class^="date-title"]').classList.remove('hidden');
                                history.classList.remove('hidden');
                            } else {
                                element.querySelector('h2[class^="date-title"]').classList.add('hidden');
                                history.classList.add('hidden');
                            }
                        })
                    })
                });
            }

            if (this.userSeach) {
                this.userSeach.addEventListener('input', function() {
                    const userSearch = _this.userSeach.value.trim().toLowerCase();
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
                        if (e.target.closest('span[id="delete-notify"]')) {
                            const notifyId = notify.getAttribute('data-value');
                            
                            

                            notify.classList.remove('animate-slideRight');
                            notify.classList.add('animate-slideAndFadeOut');

                            await _this.renderer.fetchData('../controllers/delete_notification.php', {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ notificationId: notifyId }),
                            })

                            setTimeout(function() {
                                _this.notifyContainer.removeChild(notify);
                            }, 1200)


                        } else {
                            const notificationId = notify.getAttribute('data-value');
                            try {
                                await _this.renderer.fetchData('../controllers/mark_notification.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ notification_id: notificationId })
                                });
                            } catch (error) {
                                console.error('Error marking notification as read:', error);
                            }
                        }   
                    })
                })

                clearNotifyButton.addEventListener('click', async function() {
                    try {
                        notifyElement.forEach(notify => {
                            notify.classList.remove('animate-slideRight');
                            notify.classList.add('animate-slideAndFadeOut');
                        })

                        const noResultsMessage = document.createElement('div');
                        noResultsMessage.id = 'no-notify';
                        noResultsMessage.classList.add('text-center', 'text-xl', 'mt-4', 'dark:text-gray-400');
                        noResultsMessage.textContent = 'There is no notifications';

                        _this.notifyPopup.innerHTML = noResultsMessage.outerHTML;
                        const badge = _this.notifyBtn.querySelector('#notify-badge');
                        if (badge) {
                            _this.notifyBtn.removeChild(badge);
                        }

                        await _this.renderer.fetchData('../controllers/delete_all_notification.php', {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ user_id: _this.userId }),
                        })
    
                        setTimeout(function() {
                            _this.notifyContainer.innerHTML = '';
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
                                    body: JSON.stringify({ receiverId: receiverId, senderId: _this.userId, type: 'comment', message: messageNotify, message_content: newComment.content, url: urlNotify })
                                });

                                _this.sendNotification(receiverId, _this.fullName, avatar, _this.userId, 'comment', messageNotify, newComment.content, urlNotify, createdTime);
                                document.querySelector('.comment-count').textContent = `(${_this.renderedComments.size})`;
                            } 
                        }, 100);

                        _this.socket.send(JSON.stringify({
                            type: "comment",
                            commentId: newComment.comment_id,
                            postId: commentContainer.getAttribute('data-post-id'),
                            userId: newComment.user_id,
                            username: _this.username,
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
        
                    setTimeout(async function() {
                        const tagWithType = await _this.renderer.fetchData('../controllers/tags_withtype.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams({ type: selectedValue })
                        })

                        
                        if (tagWithType.error) {
                            _this.tagList.innerHTML = `<option>${tagWithType.error}</option>`
                        } else {
                            _this.tagList.innerHTML = '';

                            if (selectedValue == '') {
                                _this.tagList.classList.add('hidden');
                                _this.buttonContainer.classList.add('hidden');
                                _this.tagInput.classList.add('hidden');
                            } else {
                                _this.tagList.classList.remove('hidden');
                                _this.buttonContainer.classList.remove('hidden');
                                _this.tagInput.classList.remove('hidden');
                                tagWithType.forEach(tag => {
                                    const tagElement = document.createElement('option');
                                    tagElement.classList.add('bg-transparent','text-text','dark:text-gray-400', 'dark:bg-gray-900')
                                    tagElement.value = `${tag.tag_name}`;
                                    tagElement.textContent = `${tag.tag_name}`;
                                    _this.tagList.appendChild(tagElement);
                                })
                            }
                        }
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
                const myPostTitle = this.myPostContainer.previousElementSibling;

                
    
                try {
                    const userIdValue = this.profileActions.getAttribute('data-value');

                    if (userIdValue !== this.userId) {
                        myPostTitle.textContent = `Their posts`;
                    }
    
                    if (this.userId == userIdValue) {
                        editButton.classList.remove('hidden');
                        this.profileActions.removeChild(followButton);

                        editButton.addEventListener('click', function() {
                            window.location.href = '../views/main.html.php?page=editprofile'
                        })
                    } else {
                        this.handleFollowButton(followButton, editButton, userIdValue);
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

            if (this.infoContainer) {
                this.infoContainer.addEventListener('click', function(e) {
                    const followId = _this.profileActions.getAttribute('data-value');
                    if (e.target.closest('div[id="follower-btn"]')) {
                        _this.handleFollower(followId);

                        setTimeout(function() {
                            _this.followerSearch();
                        }, 100)
                    } else if (e.target.closest('div[id="following-btn"]')) {
                        _this.handleFollowing(followId);

                        setTimeout(function() {
                            _this.followerSearch();
                        }, 100)
                    }
                })
            }


            if (this.newPostForm) {
                this.newPostForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    let formData = new FormData(_this.newPostForm);

                    try {
                        const postTitle = _this.newPostForm.querySelector('input[id="title"]');
                        const postContent = _this.newPostForm.querySelector('textarea[id="content"]');
                        
                        if (postTitle.value == '' && postContent.value == '') {
                            _this.showError('title', 'Title is required');
                            _this.showError('content', 'Content is required');
                            return;
                        }

                        if (postTitle.value == '') {
                            _this.clearError('content')
                            _this.showError('title', 'Title is required');
                            return;
                        }

                        if (postContent.value == '') {
                            _this.clearError('title')
                            _this.showError('content', 'Content is required');
                            return;
                        }


                        _this.clearError('title')
                        _this.clearError('content')


                        _this.loadingOverlay.classList.remove('hidden')

                        const newPost = await _this.renderer.fetchData('../controllers/add_newpost.php', {
                            method: 'POST',
                            body: formData
                        })
                        _this.sendNewPostNotify(_this.userId, _this.username, _this.avatar, 'new_post', newPost)
                        

                        window.location.href = `../views/main.html.php`;
                    } catch (error) {
                        console.log(error);
                    } finally {
                        _this.loadingOverlay.classList.add('hidden')
                    }

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

    async handleAdminEvents() {
        const _this = this;
        this.initAdminElements();
        await this.initSessionData();
       

        if (this.adminMenu) {
            const menuTabs = this.adminMenu.querySelectorAll('div[id$="-tab"]');
            menuTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    menuTabs.forEach(tab => {
                        tab.classList.remove('bg-gray-700')
                    })

                    tab.classList.add('bg-gray-700')
                    const tabName = tab.id.split('-')[0];
                    const sectionArr = Array.from(_this.sectionChild);

                    sectionArr.forEach(section => {
                        section.classList.add('hidden');

                        if (section.id.includes(tabName)) {
                            section.classList.remove('hidden');
                        }
                    })

                })
            })
        }

        if (this.backHomeBtn) {
            this.backHomeBtn.addEventListener('click', function() {
                window.location.href = '../views/main.html.php';
            });
        }

        if (this.userContainer) {
            const userLists = this.userContainer.querySelectorAll('tr');
            userLists.forEach(user => {
                const userActions = user.querySelector('#user-actions');
                const userId = user.getAttribute('data-value');
                userActions.addEventListener('click', function(e) {
                    if (e.target.closest('span[class^="view-userbtn"]')) {
                        const tagName = user.querySelector('span[class^="tagname"]').textContent;
                        window.open(`main.html.php?page=profile&tag_name=${tagName.slice(1)}`, '_blank')
                    } else if (e.target.closest('span[class^="edit-userbtn"]')) {
                        _this.handleAdminEdit(userId);

                        _this.editUserContainer.querySelector('#edit-title').textContent = `Edit User`
                        _this.userManagement.classList.add('hidden');
                        _this.editUserContainer.classList.remove('hidden');

                        _this.handleUpdateUser(parseInt(userId))
                    } else {
                        _this.handleDeleteUser(userId);
                    }
                })
            })
        }

        if (this.questionContainer) {
            const questionLists = this.questionContainer.querySelectorAll('tr');
            const moduleFilter = document.querySelector('#module-filter');
            const fromDateInput = document.querySelector('#from-date');
            const toDateInput = document.querySelector('#to-date');
            let questionInput = document.querySelector('#question-search').value.trim().toLowerCase();
            questionLists.forEach(question => {
                const questionActions = question.querySelector('#question-actions');
                const questionId = question.getAttribute('data-value');
                questionActions.addEventListener('click', function(e) {
                    if (e.target.closest('span[class^="view-quesbtn"]')) {
                        window.open(`main.html.php?page=postdetails&id=${questionId}`, '_blank');
                    } else if (e.target.closest('span[class^="edit-quesbtn"]')) {
                        _this.handleFetchEditPost(questionId);
                        
                        _this.questionManagement.classList.add('hidden');
                        _this.editQuestionContainer.classList.remove('hidden');

                        _this.handleUpdateQuestions();
                    } else {
                        _this.handleDeleteQuestion(questionId);
                    }
                })
            })

            

            // Function to filter questions
            function filterQuestions() {
                const selectedModule = moduleFilter.value.toLowerCase();
                const fromDate = new Date(fromDateInput.value);
                const toDate = new Date(toDateInput.value);
                fromDate.setHours(0, 0, 0, 0); // Set to the beginning of the day
                const questionRows = _this.questionContainer.querySelectorAll('tr');

                questionRows.forEach(row => {
                    const postTitle = row.querySelector('h3[class^="post-title"]').textContent.trim().toLowerCase();
                    const moduleValue = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase(); // Module column
                    const dateValue = new Date(row.querySelector('td:nth-child(4)').textContent); // Posted date column

                    const matchesModule = selectedModule === 'all' || moduleValue === selectedModule;
                    const matchesDate =
                        (!fromDateInput.value || dateValue >= fromDate) &&
                        (!toDateInput.value || dateValue <= toDate);
                    const matchesTitle = questionInput === '' || postTitle.includes(questionInput);

                    if (matchesModule && matchesDate && matchesTitle) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            }

            // Add event listeners for filtering
            moduleFilter.addEventListener('change', filterQuestions);
            fromDateInput.addEventListener('change', filterQuestions);
            toDateInput.addEventListener('change', filterQuestions);
            document.querySelector('#question-search').addEventListener('input', function () {
                questionInput = this.value.trim().toLowerCase();
                filterQuestions();
            });
        }

        if (this.editUserContainer) {
            this.editUserContainer.addEventListener('click', function(e) {
                if (e.target.closest('button[id^="cancel-"]')) {
                    _this.userManagement.classList.remove('hidden');
                    _this.editUserContainer.classList.add('hidden');
                }
            })
        }

        if (this.adminEditPostForm) {
            this.adminEditPostForm.addEventListener('click', function(e) {
                if (e.target.closest('button[id="cancel-edit-post"]')) {
                    _this.editQuestionContainer.classList.add('hidden');
                    _this.questionManagement.classList.remove('hidden');
                }
            })
        }

        // Admin search
        if (this.userSearch) {
            this.userSearch.addEventListener('input', function() {
            const inputValue = _this.userSearch.value.trim().toLowerCase();
            const statusFilter = document.querySelector('#status-filter').value.toLowerCase();
            const roleFilter = document.querySelector('#role-filter').value.toLowerCase();

            _this.userContainer.querySelectorAll('tr').forEach(user => {
                const fullName = user.querySelector('span[class^="fullname"]').textContent.toLowerCase();
                const status = user.querySelector('span[class^="user-status"]').textContent.toLowerCase();
                const role = user.querySelector('td[class^="user-role"]').textContent.toLowerCase();

                const matchesName = inputValue === '' || fullName.includes(inputValue);
                const matchesStatus = statusFilter === 'all' || status === statusFilter;
                const matchesRole = roleFilter === 'all' || role === roleFilter;

                if (matchesName && matchesStatus && matchesRole) {
                user.classList.remove('hidden');
                } else {
                user.classList.add('hidden');
                }
            });
            });

            // Add event listeners for status and role filters
            const statusFilter = document.querySelector('#status-filter');
            const roleFilter = document.querySelector('#role-filter');

            if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                _this.userSearch.dispatchEvent(new Event('input'));
            });
            }

            if (roleFilter) {
            roleFilter.addEventListener('change', function() {
                _this.userSearch.dispatchEvent(new Event('input'));
            });
            }
        }

        // Add user button
        if (this.addUserBtn) {
            this.addUserBtn.addEventListener('click', function() {
                _this.userManagement.classList.add('hidden');
                _this.newUserContainer.classList.remove('hidden');
            })
        }

        if (this.cancelCreateUsers) {
            this.cancelCreateUsers.addEventListener('click', function() {
                _this.newUserContainer.classList.add('hidden');
                _this.userManagement.classList.remove('hidden');
            });
        }

        if (this.createUserForm) {
            this.createUserForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const firstName = _this.createUserForm.querySelector('#first-name').value;
                const lastName = _this.createUserForm.querySelector('#last-name').value;
                const username = _this.createUserForm.querySelector('#username').value;
                const tagName = _this.createUserForm.querySelector('#tagname').value;
                const email = _this.createUserForm.querySelector('#email').value;
                const password = _this.createUserForm.querySelector('#password').value;
                const confirmPassword = _this.createUserForm.querySelector('#confirm-password').value;
                let isValid = true;


                _this.validateRegister(_this.createUserForm, username, email, password, confirmPassword, firstName, lastName, tagName, isValid);

                const validConditions = firstName || lastName || username || tagName || email || password || confirmPassword;

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
                                _this.createUserForm.querySelector('input[id="username"]').classList.add('animate-turnErrorColor');
                                _this.showError("username", `${errorObj.userExist || errorObj.userLength}`);
                            } else {
                                _this.clearError("username");
                            }

                            if (errorObj.emailExist || errorObj.emailInvalid) {
                                _this.createUserForm.querySelector('input[id="email"]').classList.add('animate-turnErrorColor');
                                _this.showError("email", `${errorObj.emailExist || errorObj.emailInvalid}`);
                            } else {
                                _this.clearError("email");
                            }

                            if (errorObj.passwordLength) {
                                _this.createUserForm.querySelector('input[id="password"]').classList.add('animate-turnErrorColor');
                                _this.showError("password", `${errorObj.passwordLength}`);
                            } else {
                                _this.clearError("password");
                            }

                            if (errorObj.confirm_password) {
                                _this.createUserForm.querySelector('input[id="confirm-password"]').classList.add('animate-turnErrorColor');
                                _this.showError("confirm-password", `${errorObj.confirm_password}`);
                            } else {
                                _this.clearError("confirm-password");
                            }

                            if (tagName != '') {
                                try {
                                    const tagCheckResult = await _this.renderer.fetchData('../controllers/check_tagname.php', {
                                        method: "POST",
                                        headers: { "Content-Type": "application/json" },
                                        body: JSON.stringify({ tagName: tagName })
                                    });
                            
                                    if (tagCheckResult.exists) {
                                        _this.createUserForm.querySelector('input[id="tagname"]').classList.add('animate-turnErrorColor');
                                        _this.showError("tagname", "Tag name is already taken.");
                                        isValid = false;
                                    } else {
                                        _this.createUserForm.querySelector('input[id="tagname"]').classList.remove('animate-turnErrorColor');
                                        _this.clearError("tagname");
                                    }
                                } catch (error) {
                                console.error('Error checking tag name:', error);
                                isValid = false;
                                }
                            }
                            isValid = false;
                        } else {
                            if (isValid) {
                                try {
                                    const registerResult = await _this.renderer.fetchData('../controllers/register.php', {
                                        method: "POST",
                                        headers: { "Content-Type": "application/json" },
                                        body: JSON.stringify({ firstName: firstName, lastName: lastName, username: username, tagName: tagName, email: email, password: password })
                                    });
                            
                                    if (registerResult.error) {
                                        console.log(registerResult.error);
                                    } else {
                                        window.location.href = '../views/main.html.php?page=admin';
                                    }
                                } catch (error) {
                                    console.error('Error registering user:', error);
                                }
                            }
                        }
                    } catch (error) {
                        console.error('Error validating form:', error);
                    }
                } else {
                    _this.showToastMessage('Please fill out all information!', 'top-8', '-right-2');
                }
                
            });
        }

        if (this.moduleManagement) {
            this.moduleManagement.addEventListener('click', function(e) {
                if (e.target.closest('div[id="addmodule-btn"]')) {
                    _this.moduleManagement.classList.add('hidden');
                    _this.addNewModuleContainer.classList.remove('hidden');
                }
            })
        }

        if (this.moduleContainer) {
            const moduleLists = this.moduleContainer.querySelectorAll('tr');
            
            moduleLists.forEach(module => {
                const moduleActions = module.querySelector('#module-actions');
                const moduleId = module.getAttribute('data-value');
                moduleActions.addEventListener('click', function(e) {
                    
                    if (e.target.closest('span[class^="edit-modulebtn"]')) {
                        const moduleData = module.querySelector('td:nth-child(1)');
                        const moduleName = moduleData.querySelector('span').textContent;
                        const moduleBgData = moduleData.querySelector('span').getAttribute('data-bg-color');
                        const moduleTextData = moduleData.querySelector('span').getAttribute('data-text-color');
                        const previewEditModule = document.querySelector('#edit-preview');
                        _this.handleGetModuleInfo(moduleId, moduleName, moduleBgData, moduleTextData);

                        _this.moduleManagement.classList.add('hidden');
                        _this.editModuleContainer.classList.remove('hidden');
                    } else {
                        if (moduleId == '0') {
                            _this.showConfirmModal('You cannot delete this module!', true);
                        } else {
                            const modulePostCount = module.querySelector('#module-post-count').textContent;
                            console.log(modulePostCount);
                            _this.handleDeleteModule(moduleId, parseInt(modulePostCount));
                        }
                    }
                })
            })

            const moduleSearch = this.moduleManagement.querySelector('#module-search');
            moduleSearch.addEventListener('input', function() {
                const searchValue = moduleSearch.value.trim().toLowerCase();
                moduleLists.forEach(module => {
                    const moduleName = module.querySelector('td:nth-child(1)').textContent.trim().toLowerCase();
                    if (moduleName.includes(searchValue)) {
                        module.classList.remove('hidden');
                    } else {
                        module.classList.add('hidden');
                    }
                });
            });

        }

        if (this.editModuleContainer) {
            this.editModuleContainer.addEventListener('click', function(e) {
                if (e.target.closest('button[id="cancel-edit-module"]')) {
                    _this.editModuleContainer.classList.add('hidden');
                    _this.moduleManagement.classList.remove('hidden');


                    _this.editModuleContainer.querySelector('input[id="edit-module-name"]').value = '';
                    _this.editModuleContainer.querySelector('span[id="edit-bg"]').style.backgroundColor = '#000000';
                    _this.editModuleContainer.querySelector('span[id="edit-bg"]').setAttribute('data-bg-color', '');
                    _this.editModuleContainer.querySelector('span[id="edit-text-color"]').style.backgroundColor = '#000000';
                    _this.editModuleContainer.querySelector('span[id="edit-text-color"]').setAttribute('data-text-color', '');
                    _this.editModuleContainer.querySelector('span[id="edit-preview"]').style.removeProperty('background-color');
                    _this.editModuleContainer.querySelector('span[id="edit-preview"]').style.removeProperty('color');
                    _this.editModuleContainer.querySelector('span[id="edit-preview"]').textContent = '';
                }
            })
        }

        if (this.addNewModuleContainer) {
            this.addNewModuleContainer.addEventListener('click', function(e) {
                if (e.target.closest('button[id="cancel-create-module"]')) {
                    _this.addNewModuleContainer.classList.add('hidden');
                    _this.moduleManagement.classList.remove('hidden');

                    _this.addNewModuleContainer.querySelector('input[id="module-name"]').value = '';
                    _this.addNewModuleContainer.querySelector('span[id="module-bg"]').style.backgroundColor = '#000000';
                    _this.addNewModuleContainer.querySelector('span[id="module-bg"]').setAttribute('data-bg-color', '');
                    _this.addNewModuleContainer.querySelector('span[id="module-text-color"]').style.backgroundColor = '#000000';
                    _this.addNewModuleContainer.querySelector('span[id="module-text-color"]').setAttribute('data-text-color', '');
                    _this.addNewModuleContainer.querySelector('span[id="module-preview"]').style.removeProperty('background-color');
                    _this.addNewModuleContainer.querySelector('span[id="module-preview"]').style.removeProperty('color');
                    _this.addNewModuleContainer.querySelector('span[id="module-preview"]').textContent = '';
                }
            })
        }

        if (this.addModuleForm) {
            const colorCanvas = this.addModuleForm.querySelector('#color-canvas');
            const colorType = this.addModuleForm.querySelector('#color-type')
            const moduleName = this.addModuleForm.querySelector('input[id="module-name"]');
            const moduleBgColor = this.addModuleForm.querySelector('span[id="module-bg"]');
            const moduleTextColor = this.addModuleForm.querySelector('span[id="module-text-color"]');
            const previewModule = this.addModuleForm.querySelector('span[id="module-preview"]');


            this.handleColorCanvas(colorCanvas, colorType, moduleBgColor, moduleTextColor, previewModule);
            
            moduleName.addEventListener('input', function() {
                const nameValue = moduleName.value.trim();
                previewModule.textContent = nameValue;
            });

            this.addModuleForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(_this.addModuleForm);
                const backgroundData = moduleBgColor.getAttribute('data-bg-color');
                const textData = moduleTextColor.getAttribute('data-text-color');
                let isValid = true;



                if (moduleName.value == '') {
                    moduleName.classList.add('animate-turnErrorColor');
                    _this.showError('module-name', 'Module name is required.')
                    isValid = false;
                } else {
                    try {
                        const moduleValid = await _this.renderer.fetchData('../controllers/admin/validate_modules.php', {
                            method: "POST",
                            body: formData
                        })

                        if (moduleValid.existingModule) {
                            console.log(true);
                            moduleName.classList.add('animate-turnErrorColor');
                            _this.showError('module-name', 'This  module name is already taken, please try again')
                            isValid = false;
                        } else {
                            moduleName.classList.remove('animate-turnErrorColor');
                            _this.clearError('module-name');
                        }
                    } catch (error) {
                        console.log(error);
                    }
                    
                }

                if (isValid) {
                    formData.set('moduleBackground', backgroundData)
                    formData.set('moduleTextColor', textData)

                    const response = await _this.renderer.fetchData('../controllers/admin/add_modules.php', {
                        method: "POST",
                        body: formData
                    })

                    if (response['admin']) {
                        location.reload();
                    }
                }
            });
        }

        if (this.editModuleForm) {
            const editColorCanvas = this.editModuleForm.querySelector('#edit-color-canvas');
            const colorType = this.editModuleForm.querySelector('#color-edit-type')
            const moduleName = this.editModuleForm.querySelector('input[id="edit-module-name"]');
            const moduleBgColor = this.editModuleForm.querySelector('span[id="edit-bg"]');
            const moduleTextColor = this.editModuleForm.querySelector('span[id="edit-text-color"]');
            const previewModule = this.editModuleForm.querySelector('span[id="edit-preview"]');

            this.handleColorCanvas(editColorCanvas, colorType, moduleBgColor, moduleTextColor, previewModule);

            moduleName.addEventListener('input', function() {
                const nameValue = moduleName.value.trim();
                previewModule.textContent = nameValue;
            });

            this.editModuleForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(_this.editModuleForm);
                const backgroundData = moduleBgColor.getAttribute('data-bg-color');
                const textData = moduleTextColor.getAttribute('data-text-color');
                let isValid = true;



                if (moduleName.value == '') {
                    moduleName.classList.add('animate-turnErrorColor');
                    _this.showError('edit-module-name', 'Module name is required.')
                    isValid = false;
                }

                if (isValid) {
                    formData.set('moduleId', moduleName.getAttribute('data-module-id'));
                    formData.set('editBackground', backgroundData)
                    formData.set('editText', textData)

                    const response = await _this.renderer.fetchData('../controllers/admin/update_modules.php', {
                        method: "POST",
                        body: formData
                    })

                    if (response['admin']) {
                        location.reload();
                    }
                }
            });

            // this.editModuleForm.addEventListener('submit', async function(e) {
            //     e.preventDefault();

            //     const backgroundData = moduleBgColor.getAttribute('data-bg-color');
            //     const textData = moduleTextColor.getAttribute('data-text-color');


            //     const formData = new FormData(_this.editModuleForm);
            //     formData.set('moduleId', moduleName.getAttribute('data-module-id'));
            //     formData.set('editBackground', backgroundData)
            //     formData.set('editText', textData)

            //     const response = await _this.renderer.fetchData('../controllers/admin/update_modules.php', {
            //         method: "POST",
            //         body: formData
            //     })

            //     if (response['admin']) {
            //         location.reload();
            //     }
            // });
        }
    
    }

    // User functions
    async handleSavedPosts(postId, savedImage) {
        try {
            const savedPosts = await this.renderer.fetchData('../controllers/handle_savedpost.php' ,{
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId })
            })

            if (savedPosts.status == "saved") {
                savedImage.classList.add('filled-icon');
            } else {
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

    async handleFollowButton(followButton, editButton, userIdValue) {
        const _this = this;
        followButton.classList.remove('hidden');
        this.profileActions.removeChild(editButton);

        // Check follow status
        const followStatus = await this.renderer.fetchData(`../controllers/check_follow_status.php?follower_id=${this.userId}&following_id=${userIdValue}`);

        
        if (followStatus.is_following) {
            followButton.textContent = 'Unfollow';
        } else {
            followButton.textContent = 'Follow';
        }

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
                                    <h2 class="text-text font-medium text-md dark:text-white">${comment.fullname}</h2>
                                    <span class="text-xs dark:text-gray-400">${this.renderer.timeAgo(comment.created_at)}</span>
                                </div>
                                <p class="comment-content-${comment.comment_id} text-text text-sm dark:text-gray-400">${comment.content}</p>
                            </div>
                        `;

                        if (this.userId == comment.user_id) {
                            const actionButton = document.createElement('div')
                            actionButton.classList.add('flex', 'text-3xl', 'font-light', 'dark:text-gray-400', 'ml-auto', 'my-auto', 'text-center', 'space-x-2');
                            actionButton.innerHTML = `
                                <span class="edit-comment-btn material-symbols-rounded custom-icon text-text text-center rounded-full p-2 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-400 cursor-pointer active:scale-90">
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
            toast.classList.add('fixed', x, y, 'z-60', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'text-text', 'dark:bg-gray-800', 'border-2', 'border-[#3ea29a]', 'bg-white', 'animate-toastSlide');
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

    validateRegister(form, username, email, password, confirmPassword, firstName = null, lastName = null, tagName = null, isValid) {
        if (username === "") {
            form.querySelector('input[id="username"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            form.querySelector('input[id="username"]').classList.remove('animate-turnErrorColor');
        }

        if (email === "") {
            form.querySelector('input[id="email"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            form.querySelector('input[id="email"]').classList.remove('animate-turnErrorColor');
        }

        if (password === "") {
            form.querySelector('input[id="password"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            form.querySelector('input[id="password"]').classList.remove('animate-turnErrorColor');
        }

        if (confirmPassword === "") {
            form.querySelector('input[id="confirm-password"]').classList.add('animate-turnErrorColor');
            isValid = false;
        } else {
            form.querySelector('input[id="confirm-password"]').classList.remove('animate-turnErrorColor');
        }

        if (this.currentURL.includes('admin')) {
            if (firstName == "") {
                form.querySelector('input[id="first-name"]').classList.add('animate-turnErrorColor');
                this.showError("first-name", "First name is required.");
                isValid = false;
            } else {
                form.querySelector('input[id="first-name"]').classList.remove('animate-turnErrorColor');
                this.clearError('first-name')
            }
    
            if (lastName == "") {
                form.querySelector('input[id="last-name"]').classList.add('animate-turnErrorColor');
                this.showError("last-name", "Last name is required.");
                isValid = false;
            } else {
                form.querySelector('input[id="last-name"]').classList.remove('animate-turnErrorColor');
                this.clearError("last-name");
            }
        
            // Validation for tagName
            if (tagName == "") {
                form.querySelector('input[id="tagname"]').classList.add('animate-turnErrorColor');
                this.showError("tagname", "Tag name is required.");
                isValid = false;
            }
        }
    }

    escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
    }

    // Hàm hiển thị lỗi
    showError(inputId, message) {
        let inputElement = document.getElementById(inputId);
        let errorElement = inputElement.nextElementSibling;
        errorElement.innerText = message;
        errorElement.style.color = "red";
    }

    // Hàm xóa lỗi
    clearError(inputId) {
        let inputElement = document.getElementById(inputId);
        let errorElement = inputElement.nextElementSibling;
        errorElement.innerText = "";
    }

    async handleFollower(followingId) {
        const followerOverlay = document.createElement('div');
        followerOverlay.id = "follow-overlay";
        followerOverlay.className = `font-poppins flex absolute items-center justify-center bg-black/60 h-full top-0 bottom-0 left-0 right-0 z-90`;
        followerOverlay.innerHTML = `
            <div id="follow-popup" class=" z-90 bg-white dark:bg-gray-800 dark:text-gray-400 w-md h-md rounded-lg">
                <div class="relative border-b-1 border-b-black p-2 dark:border-b-gray-600">
                    <h1 id="follow-title" class="text-center text-lg">Followers</h1>
                    <div class="absolute text-3xl font-light right-2 top-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer">
                        <span id="close-follow" class="material-symbols-rounded custom-icon">close</span>
                    </div>
                </div>
                <div class="mt-1 p-2 px-4">
                    <input type="text" name="followInput" id="follow-input" placeholder="Search users..." class="bg-transparent border-1 w-full px-4 rounded-md h-8 dark:border-gray-600 focus:outline-0 dark:text-gray-400">
                </div>

                <div id="follow-container" class="p-2 px-4 space-y-2 overflow-y-auto rounded-lg h-50 scroll">
                    
                </div>
            </div>
        `;

        const followerContainer = followerOverlay.querySelector('#follow-container');

        const followerList = await this.renderer.fetchData('../controllers/get_followers.php', {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ followingId: followingId })
        })

        this.renderer.renderFollower(followerList, followerContainer)
        

        
        followerOverlay.addEventListener('click', (e) => {
            const followPopup = followerOverlay.querySelector('#follow-popup');
            if (!followPopup.contains(e.target) || e.target.closest('span[id="close-follow"]')) {
                document.body.removeChild(followerOverlay);
            }
        })


        document.body.appendChild(followerOverlay)
    }

    followerSearch() {
        const searchInput = document.querySelector('#follow-input');
        const followerContainer = document.querySelector('#follow-container');
        const followerList = followerContainer.querySelectorAll('div[class^="follow-element"]');
        searchInput.addEventListener('input', this.debounce(async (e) => {
            const searchValue = searchInput.value.trim().toLowerCase();
            followerList.forEach(follower => {
                if (searchValue == '') {
                    follower.classList.remove('hidden');
                    return;
                }

                const followTagName = follower.querySelector('span[class^="follow-tagname"]');
                const followFullName = follower.querySelector('span[class^="follow-fullname"]');

                if (followTagName && followFullName) {
                    const tagName = followTagName.textContent.trim().toLowerCase();
                    const fullName = followFullName.textContent.trim().toLowerCase();

                    if (tagName.includes(searchValue) || fullName.includes(searchValue)) {
                        follower.classList.remove('hidden');
                    } else {
                        follower.classList.add('hidden');
                    }
                }

                
            })
        }, 300));
    }

    async handleFollowing(followerId) {
        const followerOverlay = document.createElement('div');
        followerOverlay.id = "follow-overlay";
        followerOverlay.className = `font-poppins flex absolute items-center justify-center bg-black/60 h-full top-0 bottom-0 left-0 right-0 z-90`;
        followerOverlay.innerHTML = `
            <div id="follow-popup" class=" z-90 bg-white dark:bg-gray-800 dark:text-gray-400 w-md h-md rounded-lg">
                <div class="relative border-b-1 border-b-black p-2 dark:border-b-gray-600">
                    <h1 id="follow-title" class="text-center text-lg">Following</h1>
                    <div class="absolute text-3xl font-light right-2 top-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer">
                        <span id="close-follow" class="material-symbols-rounded custom-icon">close</span>
                    </div>
                </div>
                <div class="mt-1 p-2 px-4">
                    <input type="text" name="followInput" id="follow-input" placeholder="Search users..." class="bg-transparent border-1 w-full px-4 rounded-md h-8 dark:border-gray-600 focus:outline-0 dark:text-gray-400">
                </div>

                <div id="follow-container" class="p-2 px-4 space-y-4 overflow-y-auto rounded-lg h-50 scroll">
                    
                </div>
            </div>
        `;

        const followingContainer = followerOverlay.querySelector('#follow-container');

        const followingList = await this.renderer.fetchData('../controllers/get_following.php', {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ followerId: followerId })
        })

        this.renderer.renderFollowing(followingList, followingContainer)

        
        followerOverlay.addEventListener('click', (e) => {
            const followPopup = followerOverlay.querySelector('#follow-popup');
            if (!followPopup.contains(e.target) || e.target.closest('span[id="close-follow"]')) {
                document.body.removeChild(followerOverlay);
            }
        })


        document.body.appendChild(followerOverlay)
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

        const buttons = this.navbar.querySelectorAll('a[id$="btn"]');
        buttons.forEach(link => {
            link.classList.remove("bg-gray-200");
            link.classList.remove("dark:bg-gray-600");
            const theme = localStorage.getItem('darkMode');
            if (link.href === this.currentURL) {
                if (theme === 'enabled') {
                    link.classList.add("dark:bg-gray-600");
                } else {
                    link.classList.add("bg-gray-200");

                }
            }
        });

        // Save the preference to the server
        await this.renderer.fetchData('../controllers/update_darkmode.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: this.userId, dark_mode: isDarkMode ? 1 : 0 })
        })
        
    }

    async applyDarkModePreference() {
        try {
            const response = await this.renderer.fetchData(`../controllers/get_darkmode.php?user_id=${this.userId}`);
            const darkMode = response.dark_mode;

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
        } else {
            console.error('sendNotification conditions not met:', { userId, senderId, type, message, content, url, createdTime });
        }
    }

    sendNewPostNotify(userId, username, avatar, type, postData) {    
        const messageNotify = `has shared a new post`;
        const urlNotify = `../views/main.html.php?page=postdetails&id=${postData.post_id}`;
        const conditions = userId && username && avatar && postData;

        if (conditions) {
            const notification = {
                type: 'new_post',
                user_id: userId,
                username: username,
                avatar: avatar,
                notification_type: type,
                postId: postData.post_id,
                postTitle: postData.post_title,
                postContent: postData.post_content,
                message: messageNotify,
                url: urlNotify,
                createdTime: new Date().toISOString()
              };
    
            this.socket.send(JSON.stringify(notification));
        } else {
            console.error('sendNotification conditions not met:', { userId, username, avatar, type, postData});
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


    showConfirmModal(modalMessage, isModule = false) {
        return new Promise((resolve) => {
            const modal = document.getElementById("popup-modal");
            let yesBtn = modal.querySelector("#modal-confirm");
            const noBtn = modal.querySelector("#modal-cancel");
            const buttonParent = modal.querySelector('div[class^="p-4"]');

            modal.querySelector("#modal-message").textContent = modalMessage;

            if (isModule) {
                yesBtn?.remove();
                noBtn.textContent = "Ok";
            } else {
                if (!yesBtn) {
                    const confirmBtn = document.createElement("button");
                    confirmBtn.id = "modal-confirm";
                    confirmBtn.type = "button";
                    confirmBtn.className = "text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center";
                    confirmBtn.textContent = "Yes, I'm sure";
                    buttonParent.insertBefore(confirmBtn, noBtn);
                    yesBtn = confirmBtn;
                }
                noBtn.textContent = "Cancel";
            }

            modal.classList.remove("hidden");

            const cleanup = () => {
                modal.classList.add("hidden");
                yesBtn?.removeEventListener("click", onYes);
                noBtn.removeEventListener("click", onNo);
            };

            const onYes = () => {
                cleanup();
                resolve(true);
            };

            const onNo = () => {
                cleanup();
                resolve(false);
            };

            yesBtn?.addEventListener("click", onYes);
            noBtn.addEventListener("click", onNo);
        });
    }

    // Function to extract the computed color from a Tailwind class
    getComputedColor(tailwindClass) {
        const tempElement = document.createElement('div');
        tempElement.className = tailwindClass;
        tempElement.textContent = 'Text';
        tempElement.style.display = 'none';
        document.body.appendChild(tempElement);

        const computedStyle = getComputedStyle(tempElement);
        let color;

        // Check if the class is a text color class
        if (tailwindClass.startsWith('text-')) {
            color = computedStyle.color;
        } else if (tailwindClass.startsWith('bg-')) {
            color = computedStyle.backgroundColor;
        }

        document.body.removeChild(tempElement);

        const rgbColor = this.convertOklchToRgb(color);
        return rgbColor ? rgbColor : null;
    }

    convertOklchToRgb(oklchStr) {
        // Check if the input is already in rgba format
        if (oklchStr.startsWith('rgba')) {
            return oklchStr; // Return the rgba color as-is
        }

        // Handle OKLCH or other formats
        try {
            const parsed = culori.parse(oklchStr); // Parse the color
            if (!parsed) {
                console.error('Invalid color input:', oklchStr);
                return null;
            }

            // Convert to RGB
            const toRgb = culori.converter('rgb');
            const rgb = toRgb(parsed);

            if (!rgb) {
                console.error('Failed to convert color:', parsed);
                return null;
            }

            // Return the RGB color without alpha to conform to input value
            const alpha = rgb.alpha !== undefined ? rgb.alpha : 1; // Default to 1 if alpha is not present
            return `rgba(${Math.round(rgb.r * 255)}, ${Math.round(rgb.g * 255)}, ${Math.round(rgb.b * 255)}, ${alpha})`;
        } catch (error) {
            console.error('Error processing color input:', error);
            return null;
        }
    }
    
    // Admin functions
    // Render user info for editing
    async handleAdminEdit(userId) {
        
        try {
            const editUserInfo = await this.renderer.fetchData(`../controllers/admin/get_edituser.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    userId: userId
                })
            });
            this.renderer.renderEditUser(editUserInfo);


        } catch (error) {
            console.error('Error loading data:', error);
        }
    }

    handleUpdateUser(userId) {
        const _this = this;
        this.adminEditForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const loadingOverlay = document.querySelector('#loading-overlay');

            const formData = new FormData(_this.adminEditForm);

            // Define the desired order of social links
            const socialLinkOrder = ['Facebook', 'Github', 'LinkedIn'];

            // Combine social_links into an object with keys as names
            const socialLinks = {};
            socialLinkOrder.forEach(key => {
                const value = formData.get(`social_links[${key}]`);
                socialLinks[key] = value || ''; // Default to an empty string if the value is missing
            });

            // Add the social_links object as a JSON string to FormData
            formData.set('social_links', JSON.stringify(socialLinks));

            // Add userId and currentURL to FormData
            formData.set('userId', userId);
            formData.set('currentURL', window.location.href);

            // Debugging: Log the FormData contents
            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            try {
                loadingOverlay.classList.remove('hidden');

                const response = await _this.renderer.fetchData('../controllers/edit_userinfo.php', {
                    method: 'POST',
                    body: formData
                })

                if (response['admin']) {
                    location.reload();
                }
            } catch (error) {
                console.error(error)
            } finally {
                loadingOverlay.classList.add('hidden')

                
            }

            
        })
    }

    async handleFetchEditPost(postId) {
        try {
            const editPostInfo = await this.renderer.fetchData(`../controllers/get_postdetails.php`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId })
            })
            const modules = await this.renderer.fetchData('../controllers/list_modules.php');

            this.renderer.renderEditPosts(editPostInfo, postId);
            this.renderer.renderTagsWithType();
            this.renderer.renderModules(modules);
        } catch (error) {
            console.log(error);
        }
    }

    handleUpdateQuestions() {
        const _this = this;
        this.adminEditPostForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const postTitle = _this.adminEditPostForm.querySelector('#title');
            const postContent = _this.adminEditPostForm.querySelector('#content');

            if (postTitle.value == '' && postContent.value == '') {
                _this.showError('title', 'Title is required');
                _this.showError('content', 'Content is required');
                return;
            }

            if (postTitle.value == '') {
                _this.clearError('content')
                _this.showError('title', 'Title is required');
                return;
            }

            if (postContent.value == '') {
                _this.clearError('title')
                _this.showError('content', 'Content is required');
                return;
            }

            const loadingOverlay = document.querySelector('#loading-overlay');


            const formData = new FormData(_this.adminEditPostForm);
            formData.set('currentURL', window.location.href);
            try {
                loadingOverlay.classList.remove('hidden');

                const response = await _this.renderer.fetchData('../controllers/editpost.php', {
                    method: 'POST',
                    body: formData
                })

                if (response['admin']) {
                    location.reload();
                }

            } catch (error) {
                console.log(error);
            } finally {
                loadingOverlay.classList.add('hidden');
            }
        })
    }

    async handleDeleteUser(userId) {
        const userConfirm = await this.showConfirmModal("Are you sure you want to delete this user?");

        if (userConfirm) {
            const response = await this.renderer.fetchData('../controllers/admin/delete_users.php', {
                method: "POST",
                headers: { "Content-Type" : "application/json" },
                body: JSON.stringify({
                    userId: userId
                })
            })
    
            if (response['admin']) {
                location.reload();
            }
        } else {
            return;
        }
    }

    async handleDeleteQuestion(postId) {
        const userConfirm = await this.showConfirmModal("Are you sure you want to delete this post?");

        if (userConfirm) {
            const currentURL = window.location.href
            const response = await this.renderer.fetchData('../controllers/deletepost.php', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ post_id: postId, currentURL: currentURL })
            });

            if (response['admin']) {
                location.reload();
            }
        } else {
            return;
        }
    }

    handleGetModuleInfo(moduleId, moduleName, backgroundColor, textColor) {
        const editModuleName = this.editModuleForm.querySelector('#edit-module-name');
        const editBgColor = this.editModuleForm.querySelector('#edit-bg');
        const editTextColor = this.editModuleForm.querySelector('#edit-text-color');
        const editprevModule = this.editModuleForm.querySelector('#edit-preview');

        console.log(editModuleName, editBgColor, editTextColor, editprevModule);

        const rgbColor = this.getComputedColor(backgroundColor);
        const rgbText = this.getComputedColor(textColor);

        editModuleName.value = moduleName;
        editModuleName.setAttribute('data-module-id', moduleId);
        editBgColor.style.backgroundColor = rgbColor;
        editBgColor.setAttribute('data-bg-color', backgroundColor);
        editTextColor.style.backgroundColor = rgbText;
        editTextColor.setAttribute('data-text-color', textColor);
        editprevModule.style.backgroundColor = rgbColor;
        editprevModule.style.color = rgbText;
        editprevModule.textContent = moduleName;

    }

    handleUpdateModules(moduleId, bgColor, textColor) {
        
    }

    async handleDeleteModule(moduleId, modulePostCount) {
        let userConfirm

        try {
            if (modulePostCount > 0) {
                userConfirm = await this.showConfirmModal(`There are posts using this module (${modulePostCount}), these posts will be switch to "Uncategorized" module after deleting. Are you sure?`)
            } else {
                userConfirm = await this.showConfirmModal("Are you sure you want to delete this module?");
            }


            if (userConfirm) {
                this.loadingOverlay.classList.remove('hidden');

                const response = await this.renderer.fetchData('../controllers/admin/delete_modules.php', {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ 
                        module_id: moduleId,
                        module_post_count: modulePostCount
                     })
                })
    
                if (response['admin']) {
                    location.reload();
                }
            } else {
                return
            }
        } catch (error) {
            console.log(error)
        } finally {
            this.loadingOverlay.classList.add('hidden');
        }
    }

    handleColorCanvas(canvasContainer, colorType, moduleBgColor, moduleTextColor, previewModule) {
        const _this = this;
        canvasContainer.addEventListener('click', function (e) {
            if (e.target.closest('div[class^="color-box"]')) {
                const selectedBgColor = e.target.getAttribute('data-bg-color');
                const selectedTextColor = e.target.getAttribute('data-text-color');
        
                console.log(selectedBgColor, selectedTextColor);
        
                if (colorType.value === "background") {
                    const rgbColor = _this.getComputedColor(selectedBgColor); // Extract the RGB color
                    if (rgbColor.startsWith('rgba')) {
                        previewModule.style.backgroundColor = rgbColor; // Apply the rgba color
                        moduleBgColor.style.backgroundColor = rgbColor; // Set the input value
                        moduleBgColor.setAttribute('data-bg-color', selectedBgColor);
                    } else if (_this.isValidHexColor(rgbColor)) {
                        previewModule.style.backgroundColor = rgbColor; // Apply the hex color
                        moduleBgColor.style.backgroundColor = rgbColor; // Set the input value
                        moduleBgColor.setAttribute('data-bg-color', selectedBgColor);
                    } else {
                        console.error('Invalid color format:', rgbColor);
                    }
                } else if (colorType.value === "text") {
                    const rgbColor = _this.getComputedColor(selectedTextColor); // Extract the RGB color
                    if (rgbColor.startsWith('rgba')) {
                        previewModule.style.color = rgbColor; // Apply the rgba color
                        moduleTextColor.style.backgroundColor = rgbColor; // Set the input value
                        moduleTextColor.setAttribute('data-text-color', selectedTextColor);
                    } else if (_this.isValidHexColor(rgbColor)) {
                        previewModule.style.color = rgbColor; // Apply the hex color
                        moduleTextColor.style.backgroundColor = rgbColor; // Set the input value
                        moduleTextColor.setAttribute('data-text-color', selectedTextColor);
                    } else {
                        console.error('Invalid color format:', rgbColor);
                    }
                }
            }
        });
    }

    async start() {
        // Apply dark mode preference on page load
        await this.applyDarkModePreference();

        // Check if the current page is admin or not
        if (this.currentURL.includes('admin')) {
            this.handleAdminEvents();
        } else {
            this.handleEvents();
        }

        const postId = this.postDetailContainer ? this.postDetailContainer.getAttribute('data-value') : null;
        if (postId) {
            this.updateComments(postId);
        }
        
    }
}

// Export the class
export default EventListener;