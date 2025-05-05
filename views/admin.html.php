<header class="font-poppins fixed top-0 w-full flex justify-between items-center z-60 p-3 bg-gray-900 shadow-2xl border-b border-gray-700">
    <div class="flex items-center w-full -ml-4 text-4xl font-light text-white px-4">
        <span id="adminmenu-btn" class="ml-4 material-symbols-rounded custom-icon">
            menu
        </span>
        <img loading="lazy" src="../assets/images/weblogo.png" alt="" class="h-20">
        <span class="text-sm md:text-lg font-semibold text-white">Knowledge Nexus</span>
    </div>
</header>


<aside id="menu-container" class="w-64 fixed top-0 h-full mt-26 -translate-x-full xl:-translate-x-0  bg-gray-900 border-r border-gray-700 z-50">
    <div id="admin-infor" class="flex items-center text-white bg-gray-800 mt-4 p-4">
        <div class="mr-4">
            <img id="admin-avatar" src="../assets/images/user.png" alt="" class="h-12 rounded-full">
        </div>
        <div>
            <h2 id="admin-username" class="font-semibold text-lg">Horus Weaver</h2>
            <p class="text-text-light text-sm">Administrator</p>
        </div>
    </div>

    <div id="admin-menu" class="mt-10 flex flex-col text-gray-400 font-semibold space-y-4 w-full">
        <div id="user-tab" class="p-4 flex items-center bg-gray-700 hover:bg-gray-700 cursor-pointer transition-all">
            <span class="material-symbols-rounded mr-2">
                group
            </span>
            Users Management
        </div>
        <div id="question-tab" class="p-4 flex items-center hover:bg-gray-700 cursor-pointer transition-all">
            <span class="material-symbols-rounded mr-2">
                help
            </span>
            Questions
        </div>
        <div id="module-tab" class="p-4 flex items-center hover:bg-gray-700 cursor-pointer transition-all">
            <span class="material-symbols-rounded mr-2">
                view_module
            </span>
            Modules
        </div>
        <div id="backToHome" class="p-4 flex items-center hover:bg-gray-700 cursor-pointer transition-all text-red-400">
            <span class="material-symbols-rounded custom-icon mr-2">
                logout
            </span>
            Back To Home
        </div>

    </div>
</aside>

<main id="section-container" class="dark font-poppins h-full mt-26 xl:ml-64 2xl:ml-64 p-4 w-full bg-gray-900 text-gray-400">
    <!-- Users Management -->
    <div id="user">
        <section id="user-management">
            <div class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Users Management
            </div>

            <div class="flex space-x-4 px-4 mt-4 bg-gray-800 rounded-lg p-4">
                <div class="flex items-center space-x-2">
                    <h2>Status:</h2>
                    <select name="statusValue" id="status-filter" class="bg-gray-700 rounded-md p-2">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <h2>Role:</h2>
                    <select name="roleValue" id="role-filter" class="bg-gray-700 rounded-md p-2">
                        <option value="all">All Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="flex-1 relative text-3xl font-light">
                    <span class="material-symbols-rounded custom-icon absolute top-1/4 left-2">
                        search
                    </span>
                    <input type="text" name="userInput" id="user-search" placeholder="Search users..." class="bg-transparent text-lg font-normal w-full rounded-lg border-1 border-gray-600 pl-10 p-4 focus:outline-none">
                </div>

                <div id="adduser-btn" class="relative text-3xl font-light text-white active:scale-90 cursor-pointer">
                    <span class="material-symbols-rounded custom-icon absolute top-1/4 left-4">
                        add
                    </span>
                    <button class="bg-blue-500 text-white p-4 pl-12 rounded-lg cursor-pointer text-lg font-normal">Add New User</button>
                </div>
            </div>

            <div class="mt-4 space-y-4 md:space-y-0 md:space-x-4 w-full">
                <div class="bg-gray-800 p-4 rounded-lg w-full flex justify-between">
                    <div class="text-3xl font-light">
                        <div class="flex space-x-2">
                            <h3 class="font-semibold text-lg">Total Users</h3>
                            <span class="material-symbols-rounded custom-icon">
                                group
                            </span>
                        </div>
                        <h3 id="total-users" class="text-3xl font-normal"></h3>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-4 bg-gray-800">
                <h2 class="font-semibold text-2xl">All Users</h2>


                <div class="overflow-x-auto">
                    <table class="w-full mt-4 rounded-lg overflow-x-auto">
                        <thead class="bg-gray-900 rounded-lg p-4 font-semibold">
                            <td class="p-4 text-left">User</td>
                            <td>Username</td>
                            <td>Role</td>
                            <td>Status</td>
                            <td>Joined</td>
                            <td>Actions</td>
                        </thead>
                        <tbody id="user-container">

                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Add New Users -->
        <section id="new-user" class="mt-4 hidden">
            <div class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Add New User
            </div>

            <form id="create-user-form" action="" method="post" class="bg-gray-800 mt-4 p-4 rounded-lg ">
                <div class="w-1/2 flex flex-col space-y-4 px-4">
                    <div class="relative">
                        <input type="text" name="newFirstName" id="first-name" class="w-full bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter first name...">
                        <span class="font-light"></span>
                    </div>
                    <div class="relative">
                        <input type="text" name="newLastName" id="last-name" class="w-full bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter last name...">
                        <span class="font-light"></span>
                    </div>
                    <div class="relative">
                        <input type="text" name="newUserValue" id="username" class="w-full bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter username...">
                        <span class="font-light"></span>
                    </div>
                    <div class="relative">
                        <input type="text" name="newTagName" id="tagname" class="w-full bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter tag name...">
                        <span class="font-light"></span>
                    </div>
                    <div class="relative">
                        <input type="text" name="newEmail" id="email" class="w-full bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter email...">
                        <span class="font-light"></span>
                    </div>
                    <div class="relative text-3xl font-light">
                        <span class="password-visible absolute right-3 top-1/5 material-symbols-rounded custom-icon text-gray-900 dark:text-gray-400 cursor-pointer select-none">
                            visibility_off
                        </span>
                        <input type="password" name="newPassword" id="password" class="w-full text-lg bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter password...">
                        <span class="font-light text-lg"></span>
                    </div>
                    <div class="relative text-3xl font-light">
                        <span class="password-visible absolute right-3 top-1/5 text-xl material-symbols-rounded custom-icon text-gray-900 dark:text-gray-400 cursor-pointer select-none">
                            visibility_off
                        </span>
                        <input type="password" name="newConfirmPassword" id="confirm-password" class="w-full text-lg bg-transparent border-0 p-4 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Confirm password...">
                        <span class="font-light"></span>
                    </div>

                    <div class="flex justify-between p-4">
                        <button type="button" id="cancel-create" class="border-1 border-gray-600 p-2 px-8 rounded-lg cursor-pointer">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white p-2 px-8 rounded-lg cursor-pointer">Create</button>
                    </div>
                </div>
            </form>
        </section>

        <!-- Edit Users -->
        <section id="edit-user" class="mt-4 hidden">
            <div id="edit-title" class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Edit User
            </div>

            <form id="admin-edit" method="post" enctype="multipart/form-data" class="bg-gray-800 mt-4 p-4 rounded-lg ">
                <div class="edit-container">
                    <div class="mt-2">
                        <h2 class="text-xl font-semibold dark:text-white">Profile Picture</h2>

                        <div id="uploadimg-container" class="relative flex border-1 z-5 bg-none border-text rounded-full space-x-4 m-4 cursor-pointer md:mx-30 lg:mx-50 lg:space-x-12 2xl:w-1/3 2xl:mx-0 dark:border-gray-600">


                            <div id="img-child" class="mt-4">
                                <label for="avatarURL" class="flex items-center absolute left-0 right-0 top-0 h-full rounded-full  text-text text-center dark:text-gray-400 cursor-pointer">
                                    <input type="file" name="avatarURL" id="avatarURL" class="hidden">
                                    <span id="file-user-name" class="w-56 line-clamp-1 mx-auto">Change their image</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <h2 class="text-xl font-semibold dark:text-white">Account Information</h2>

                        <div id="accountinfo-container" class="mt-2 space-y-4">

                        </div>
                    </div>

                    <div class="mt-2">
                        <h2 class="text-xl font-semibold dark:text-white">Bio</h2>

                        <div id="bio-container" class="mt-2 space-y-4">

                        </div>
                    </div>


                    <div class="mt-2">
                        <h2 class="text-xl font-semibold dark:text-white">Profile Social Link</h2>

                        <div id="social-container" class="mt-2 space-y-4">
                            <div id="facebook-link" class="relative 2xl:w-1/3">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" class="absolute top-8 left-3 h-8 dark:fill-gray-400">
                                    <path d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z"></path>
                                </svg>
                                <label for="Facebook" class="dark:text-white">Facebook</label>
                                <input type="url" name="social_links[Facebook]" id="Facebook" class="bg-transparent border-1 border-text rounded-lg p-2 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your Facebook  Link" value="">
                            </div>

                            <div id="github-link" class="relative 2xl:w-1/3">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 72 72" class="absolute top-7 left-2 h-10 dark:fill-gray-400">
                                    <path d="M36,12c13.255,0,24,10.745,24,24c0,10.656-6.948,19.685-16.559,22.818c0.003-0.009,0.007-0.022,0.007-0.022	s-1.62-0.759-1.586-2.114c0.038-1.491,0-4.971,0-6.248c0-2.193-1.388-3.747-1.388-3.747s10.884,0.122,10.884-11.491	c0-4.481-2.342-6.812-2.342-6.812s1.23-4.784-0.426-6.812c-1.856-0.2-5.18,1.774-6.6,2.697c0,0-2.25-0.922-5.991-0.922	c-3.742,0-5.991,0.922-5.991,0.922c-1.419-0.922-4.744-2.897-6.6-2.697c-1.656,2.029-0.426,6.812-0.426,6.812	s-2.342,2.332-2.342,6.812c0,11.613,10.884,11.491,10.884,11.491s-1.097,1.239-1.336,3.061c-0.76,0.258-1.877,0.576-2.78,0.576	c-2.362,0-4.159-2.296-4.817-3.358c-0.649-1.048-1.98-1.927-3.221-1.927c-0.817,0-1.216,0.409-1.216,0.876s1.146,0.793,1.902,1.659	c1.594,1.826,1.565,5.933,7.245,5.933c0.617,0,1.876-0.152,2.823-0.279c-0.006,1.293-0.007,2.657,0.013,3.454	c0.034,1.355-1.586,2.114-1.586,2.114s0.004,0.013,0.007,0.022C18.948,55.685,12,46.656,12,36C12,22.745,22.745,12,36,12z"></path>
                                </svg>
                                <label for="Github" class="dark:text-white">Github</label>
                                <input type="url" name="social_links[Github]" id="Github" class="bg-transparent border-1 border-text rounded-lg p-2 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your Github  Link" value="">
                            </div>

                            <div id="linkedin-link" class="relative 2xl:w-1/3">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" class="absolute top-8 left-3 h-8 dark:fill-gray-400">
                                    <path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10 c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56 c3.97,0,7.19,2.73,7.19,8.26V39z"></path>
                                </svg>
                                <label for="LinkedIn" class="dark:text-white">LinkedIn</label>
                                <input type="url" name="social_links[LinkedIn]" id="LinkedIn" class="bg-transparent border-1 border-text rounded-lg p-2 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your LinkedIn  Link" value="">
                            </div>

                        </div>
                    </div>

                    <div class="my-4 flex justify-between 2xl:w-1/3">
                        <button id="cancel-user-btn" type="button" class="bg-transparent border-1 border-gray-400 px-6 rounded-lg cursor-pointer" name="Edit" value="Cancel">Cancel</button>

                        <button type="submit" class="bg-black text-white border-1 border-text px-8 py-2 rounded-lg cursor-pointer" name="Edit" value="Save">Save</button>
                    </div>
                </div>
            </form>
        </section>
    </div>


    <div id="question" class="hidden">
        <!-- Question Management -->
        <section id="question-management">
            <div class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Question Management
            </div>

            <div class="flex space-x-4 px-4 mt-4 bg-gray-800 rounded-lg p-4">
                <div class="flex items-center space-x-2">
                    <h2>Modules:</h2>
                    <select name="moduleValue" id="module-filter" class="bg-gray-700 rounded-md p-2">
                        <option value="all">All Modules</option>

                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="date" name="fromDate" id="from-date" class="bg-gray-700 rounded-md p-2">
                    <span>to</span>
                    <input type="date" name="toDate" id="to-date" class="bg-gray-700 rounded-md p-2">
                </div>
                <div class="flex-1 relative text-3xl font-light">
                    <span class="material-symbols-rounded custom-icon absolute top-1/4 left-2">
                        search
                    </span>
                    <input type="text" name="questionInput" id="question-search" placeholder="Search questions by title" class="bg-transparent text-lg font-normal w-full rounded-lg border-1 border-gray-600 pl-10 p-4 focus:outline-none">
                </div>


            </div>

            <div class="mt-4 space-y-4 md:space-y-0 md:space-x-4 w-full">
                <div class="bg-gray-800 p-4 rounded-lg w-full flex justify-between">
                    <div class="text-3xl font-light">
                        <div class="flex space-x-2">
                            <h3 class="font-semibold text-lg">Total Questions</h3>
                            <span class="material-symbols-rounded custom-icon">
                                quiz
                            </span>
                        </div>
                        <h3 id="total-questions" class="text-3xl font-normal"></h3>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-4 bg-gray-800">
                <h2 class="font-semibold text-2xl">All Questions</h2>


                <div class="overflow-x-auto">
                    <table class="w-full mt-4 rounded-lg overflow-x-auto">
                        <thead class="bg-gray-900 rounded-lg p-4 font-semibold">
                            <td class="p-4 text-left">Question</td>
                            <td class="">Module</td>
                            <td>User</td>
                            <td>Posted</td>
                            <td>Actions</td>
                        </thead>
                        <tbody id="question-container">

                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        <section id="edit-question" class="mt-4 hidden">
            <div id="edit-title" class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Edit Question
            </div>


            <form id="admin-edit-post" action="../controllers/edit_post.php" method="post" enctype="multipart/form-data" class="bg-gray-800 mt-4 p-4 rounded-lg ">
                <input type="hidden" name="postValues" id="post-value">
                <div class="relative mt-2 space-y-4">
                    <input type="text" name="titleValue" id="title" class="text-gray-400 bg-transparent border-1 border-gray-400 rounded-lg p-2 q px-4 w-full md:w-5/8 lg:w-4/9" placeholder="Post title">
                    <span class="error-message absolute text-red-500 bottom-0 left-0 text-xs"></span>
                </div>

                <div class="relative mt-6 flex flex-col w-fit">
                    <textarea name="contentValue" id="content" cols="40" rows="8" class="p-2 text-gray-400 border-1 border-gray rounded-lg" placeholder="Post content"></textarea>
                    <span class="error-message absolute text-red-500 top-54 left-0 text-xs"></span>

                    <div class="mt-10">
                        <label for="imageURL" class="block py-1.5 px-3 cursor-pointer border-1 rounded-md bg-transparent text-center dark:bg-transparent border-gray-600 text-gray-400 hover:bg-gray-700">
                            <input type="file" name="imageURL" id="imageURL" class="hidden">
                            <span id="file-name" class="w-44 text-wrap line-clamp-1 m-auto">Upload your image</span>
                        </label>
                    </div>
                </div>

                <div class="mt-4 flex flex-col">
                    <label for="select-tag-type" class="*:text-gray-400">Select your tag here</label>
                    <select name="selectTagType" id="select-tag-type" class="border-1 rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9 text-gray-400 border-gray-700 focus:outline-0 focus:ring-0">
                        <option value="" selected class=" text-gray-400 bg-gray-900"></option>
                        <option value="general" class=" text-gray-400 bg-gray-900">General Subject</option>
                        <option value="prog&tech" class=" text-gray-400 bg-gray-900">Programming & Technology</option>
                        <option value="study" class=" text-gray-400 bg-gray-900">Study Tips</option>
                        <option value="career" class=" text-gray-400 bg-gray-900">Career & Guidance</option>
                    </select>

                    <div class="flex items-center mt-4 space-x-6">
                        <select name="tagList" id="tag-list" class="border-1 bg-gray-800 rounded-lg py-1 px-4 overflow-y-scroll w-full  md:w-5/8 lg:w-4/9 text-gray-400 border-gray-700 focus:outline-0">

                        </select>

                        <div id="button-container" class="space-x-2 flex">
                            <button type="button" id="add-btn" class="bg-blue-500 p-2 rounded-md text-white cursor-pointer">Add</button>
                            <button type="button" id="remove-btn" class="bg-red-500 p-2 rounded-md text-white cursor-pointer">Remove</button>
                        </div>
                    </div>

                    <div id="tag-container" class="mt-4">
                        <input type="text" name="tagInput" id="tag-input" class="bg-transparent border-1 rounded-lg py-1 px-4 w-full md:w-5/8 lg:w-4/9 text-gray-400 border-gray-700" readonly>
                    </div>
                </div>

                <div class="mt-4 flex flex-col">
                    <h2 class="text-lg text-gray-400">Select modules</h2>
                    <select name="moduleValues" id="modules" class="border-1 rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9 text-gray-400 border-gray-700">

                    </select>
                </div>

                <div class="flex justify-between md:w-2/3 lg:w-4/9">
                    <button id="cancel-edit-post" type="button" class="border border-gray-700 rounded-lg px-4 py-2 mt-4 cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" name="submit" class="bg-black text-white rounded-lg px-4 py-2 mt-4 cursor-pointer">
                        Save
                    </button>
                </div>
            </form>
        </section>
    </div>


    <div id="modules" class="hidden">
        <section id="module-management">
            <div class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Module Management
            </div>

            <div class="flex space-x-4 px-4 mt-4 bg-gray-800 rounded-lg p-4">
                <div class="flex-1 relative text-3xl font-light">
                    <span class="material-symbols-rounded custom-icon absolute top-1/4 left-2">
                        search
                    </span>
                    <input type="text" name="moduleInput" id="module-search" placeholder="Search modules by name" class="bg-transparent text-lg font-normal w-full rounded-lg border-1 border-gray-600 pl-10 p-4 focus:outline-none">
                </div>

                <div id="addmodule-btn" class="relative text-3xl font-light text-white active:scale-90 cursor-pointer">
                    <span class="material-symbols-rounded custom-icon absolute top-1/4 left-4">
                        add
                    </span>
                    <button class="bg-blue-500 text-white p-4 pl-12 rounded-lg cursor-pointer text-lg font-normal ">Add New Module</button>
                </div>
            </div>

            <div class="mt-4 space-y-4 md:space-y-0 md:space-x-4 w-full">
                <div class="bg-gray-800 p-4 rounded-lg w-full flex justify-between">
                    <div class="text-3xl font-light">
                        <div class="flex space-x-2">
                            <h3 class="font-semibold text-lg">Total Modules</h3>
                            <span class="material-symbols-rounded custom-icon">
                                category
                            </span>
                        </div>
                        <h3 id="total-modules" class="text-3xl font-normal"></h3>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-4 bg-gray-800">
                <h2 class="font-semibold text-2xl">All Modules</h2>


                <div class="overflow-x-auto">
                    <table class="w-full mt-4 rounded-lg overflow-x-auto">
                        <thead class="bg-gray-900 rounded-lg p-4 font-semibold">
                            <td class="p-4 text-left">Module Name</td>
                            <td>Post Using</td>
                            <td>Actions</td>
                        </thead>
                        <tbody id="module-container">

                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="new-module" class="mt-4 hidden">
            <div class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Add New Module
            </div>

            <form id="create-module-form" action="" method="post" class="bg-gray-800 flex justify-between mt-4 p-4 rounded-lg ">
                <div class="w-1/2 flex flex-col space-y-4 px-4">
                    <div class="relative">
                        <input type="text" name="newModuleName" id="module-name" class="w-full bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter module name...">
                        <span class="font-light"></span>
                    </div>
                    <div class="relative flex items-center space-x-2">
                        <span>Module Background Color:</span>
                        <span name="moduleBackground" id="module-bg" class="w-12 h-7"></span>
                    </div>
                    <div class="relative flex items-center space-x-2">
                        <span>Module Text Color:</span>
                        <span name="moduleTextColor" id="module-text-color" class="w-12 h-7"></span>
                    </div>

                    <div class="flex space-x-4">
                        <span class="font-medium">Preview your module:</span>

                        <span id="module-preview" class="w-fit h-fit text-sm font-medium rounded-full p-1 "></span>
                    </div>

                    <div class="flex justify-between p-4">
                        <button type="button" id="cancel-create-module" class="border-1 border-gray-600 p-2 px-8 rounded-lg cursor-pointer">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white p-2 px-8 rounded-lg cursor-pointer">Create</button>
                    </div>
                </div>


                <div>
                    <h3 class="text-2xl font-medium text-white">Choose Module Color:</h3>
                    <div id="color-canvas" class="relative not-prose grid grid-cols-[auto_minmax(0,_1fr)] items-center gap-4 bg-black rounded-lg p-4">
                        <select id="color-type" class="sticky flex items-center top-28 z-9 bg-white lg:top-14 dark:bg-gray-950 cursor-pointer focus:outline-0 focus:ring-0">
                            <option value="background">Background Color</option>
                            <option value="text">Text Color</option>
                        </select>
                        <div class="sticky top-28 z-9 col-start-2 grid grid-cols-11 justify-items-center gap-1.5 bg-white font-medium text-gray-950 *:rotate-180 *:[writing-mode:vertical-lr] max-sm:py-1 sm:gap-4 sm:*:rotate-0 sm:*:[writing-mode:horizontal-tb] lg:top-14 dark:bg-gray-950 dark:text-white">
                            <div>50</div>
                            <div>100</div>
                            <div>200</div>
                            <div>300</div>
                            <div>400</div>
                            <div>500</div>
                            <div>600</div>
                            <div>700</div>
                            <div>800</div>
                            <div>900</div>
                            <div>950</div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <section id="edit-module" class="mt-4 hidden">
            <div class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
                Edit Module
            </div>

            <form action="" id="edit-module-form" method="post" class="bg-gray-800 flex justify-between mt-4 p-4 rounded-lg">
                <div class="w-1/2 flex flex-col space-y-4 px-4">
                    <div class="relative">
                        <input type="text" name="editModuleName" id="edit-module-name" class="w-full bg-transparent p-4 border-0 border-b-1 border-gray-600 focus:outline-0 focus:ring-0" placeholder="Enter module name...">
                        <span class="font-light"></span>
                    </div>
                    <div class="relative flex items-center space-x-2">
                        <span>Module Background Color:</span>
                        <span name="editBackground" id="edit-bg" class="w-12 h-7"></span>
                    </div>
                    <div class="relative flex items-center space-x-2">
                        <span>Module Text Color:</span>
                        <span name="editText" id="edit-text-color" class="w-12 h-7"></span>
                    </div>

                    <div class="flex space-x-4">
                        <span class="font-medium">Preview your module:</span>

                        <span id="edit-preview" class="w-fit h-fit text-sm font-medium rounded-full p-1 "></span>
                    </div>

                    <div class="flex justify-between p-4">
                        <button type="button" id="cancel-edit-module" class="border-1 border-gray-600 p-2 px-8 rounded-lg cursor-pointer">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white p-2 px-8 rounded-lg cursor-pointer">Save</button>
                    </div>
                </div>


                <div>
                    <h3 class="text-2xl font-medium text-white">Choose Module Color:</h3>
                    <div id="edit-color-canvas" class="relative not-prose grid grid-cols-[auto_minmax(0,_1fr)] items-center gap-4 bg-black rounded-lg p-4">
                        <select id="color-edit-type" class="sticky flex items-center top-28 z-9 lg:top-14 bg-gray-950 cursor-pointer focus:outline-0 focus:ring-0">
                            <option value="background">Background Color</option>
                            <option value="text">Text Color</option>
                        </select>
                        <div class="sticky top-28 z-9 col-start-2 grid grid-cols-11 justify-items-center gap-1.5 bg-white font-medium text-gray-950 *:rotate-180 *:[writing-mode:vertical-lr] max-sm:py-1 sm:gap-4 sm:*:rotate-0 sm:*:[writing-mode:horizontal-tb] lg:top-14 dark:bg-gray-950 dark:text-white">
                            <div>50</div>
                            <div>100</div>
                            <div>200</div>
                            <div>300</div>
                            <div>400</div>
                            <div>500</div>
                            <div>600</div>
                            <div>700</div>
                            <div>800</div>
                            <div>900</div>
                            <div>950</div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>


</main>




<script type="module" src="../controllers/render&events/admin.js"></script>