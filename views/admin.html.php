<header class="font-poppins fixed top-0 w-full flex justify-between items-center z-60 p-3 bg-gray-900 shadow-2xl border-b border-gray-700">
    <div class="flex items-center w-full -ml-4 text-3xl font-light text-white px-4">
        <span id="adminmenu-btn" class="material-symbols-rounded custom-icon">
            menu
        </span>
        <img loading="lazy" src="../assets/images/weblogo.png" alt="" class="h-20">
        <span class="text-sm md:text-lg font-semibold text-white">Knowledge Nexus</span>
    </div>
</header>


<aside class="w-64 -translate-x-full fixed top-0 h-full mt-26 bg-gray-900 border-r border-gray-700 md:-translate-0">
    <div class="flex items-center text-white bg-gray-800 mt-4 p-4">
        <div class="mr-4">
            <img src="../assets/images/user.png" alt="" class="h-12 rounded-full">
        </div>
        <div>
            <h2 class="font-semibold text-lg">Horus Weaver</h2>
            <p class="text-text-light text-sm">Administrator</p>
        </div>
    </div>

    <div class="mt-10 flex flex-col text-gray-400 font-semibold space-y-4">
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

<main class="font-poppins mt-26 md:ml-64 p-4 w-full bg-gray-900 text-gray-400">
    <!-- Users Management -->
    <section id="user-management">
        <div class="text-2xl font-bold  bg-gray-800 p-4 rounded-lg w-full">
            Users Management
        </div>

        <div class="flex space-x-4 px-4 mt-4 bg-gray-800 rounded-lg p-4">
            <div class="flex items-center space-x-2">
                <h2>Status:</h2>
                <select name="statusValue" id="" class="bg-gray-700 rounded-md p-2">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <h2>Status:</h2>
                <select name="statusValue" id="" class="bg-gray-700 rounded-md p-2">
                    <option value="all">All Role</option>
                    <option value="active">Admin</option>
                    <option value="inactive">User</option>
                </select>
            </div>
            <div class="flex-1 relative text-3xl font-light">
                <span class="material-symbols-rounded custom-icon absolute top-1/4 left-2">
                    search
                </span>
                <input type="text" name="userInput" id="user-input" placeholder="Search users..." class="text-lg font-normal w-full rounded-lg border-1 border-gray-600 pl-10 p-4 focus:outline-none">
            </div>

            <div id="adduser-btn" class="relative text-3xl font-light text-white active:scale-90">
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
                    <h3 id="total-users" class="text-3xl font-normal">3.249</h3>
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
                    <input type="text" name="newFirstName" id="first-name" class="w-full p-4 border-b-1 border-gray-600 focus:outline-0" placeholder="Enter first name...">
                </div>
                <div class="relative">
                    <input type="text" name="newLastName" id="last-name" class="w-full p-4 border-b-1 border-gray-600 focus:outline-0" placeholder="Enter last name...">

                </div>
                <div class="relative">
                    <input type="text" name="newUserValue" id="username" class="w-full p-4 border-b-1 border-gray-600 focus:outline-0" placeholder="Enter username...">

                </div>
                <div class="relative">
                    <input type="text" name="newTagName" id="tagname" class="w-full p-4 border-b-1 border-gray-600 focus:outline-0" placeholder="Enter tag name...">

                </div>
                <div class="relative">
                    <input type="text" name="newEmail" id="email" class="w-full p-4 border-b-1 border-gray-600 focus:outline-0" placeholder="Enter email...">

                </div>
                <div class="relative">
                    <input type="text" name="newPassword" id="password" class="w-full p-4 border-b-1 border-gray-600 focus:outline-0" placeholder="Enter password...">

                </div>
                <div class="relative">
                    <input type="text" name="newConfirmPassword" id="confirm-password" class="w-full p-4 border-b-1 border-gray-600 focus:outline-0" placeholder="Confirm password...">

                </div>

                <div class="flex justify-between p-4">
                    <button type="button" id="cancel-create" class="border-1 border-gray-600 p-2 px-8 rounded-lg cursor-pointer">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white p-2 px-8 rounded-lg cursor-pointer">Create</button>
                </div>
            </div>
        </form>
    </section>
</main>

<script type="module" src="../controllers/render&events/admin.js"></script>