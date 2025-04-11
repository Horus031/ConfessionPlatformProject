<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[20%]">
    <h1 class="text-2xl font-semibold lg:text-4xl text-border dark:text-gray-400">Edit your profile</h1>
    <hr class="border-1 border-secondary mt-2 dark:white">

    <form id="edit-form" action="../controllers/edit_userinfo.php" method="post" enctype="multipart/form-data">
        <div class="edit-container">
            <div class="mt-2">
                <h2 class="text-text text-xl font-semibold dark:text-white">Profile Picture</h2>
                <p class="text-text font-semibold dark:text-gray-400">Let's upload your picture so that everyone can recognize you</p>

                <div id="uploadimg-container" class="relative flex border-1 z-5 bg-none border-text rounded-full space-x-4 m-4 cursor-pointer md:mx-30 lg:mx-50 lg:space-x-12 2xl:w-1/3 2xl:mx-0 dark:border-gray-600">


                    <div id="img-child" class="mt-4">
                        <label for="avatarURL" class="block absolute w-full z-1 left-0 right-0 top-0 py-7 cursor-pointer rounded-full  text-text text-center dark:text-gray-400">
                            <input type="file" name="avatarURL" id="avatarURL" class="hidden">
                            <span id="file-name" class="ml-12"> Upload your image</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <h2 class="text-text text-xl font-semibold dark:text-white">Account Information</h2>

                <div id="accountinfo-container" class="mt-2 space-y-4">

                </div>
            </div>

            <div class="mt-2">
                <h2 class="text-text text-xl font-semibold dark:text-white">Bio</h2>

                <div id="bio-container" class="mt-2 space-y-4">

                </div>
            </div>


            <div class="mt-2">
                <h2 class="text-text text-xl font-semibold dark:text-white">Profile Social Link</h2>
                <p class="text-text font-semibold dark:text-gray-400">Let’s give us some links to connect with you</p>

                <div id="social-container" class="mt-2 space-y-4">
                    <div id="facebook-link" class="relative 2xl:w-1/3">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" class="fill-text absolute top-8 left-3 h-8 dark:fill-gray-400">
                            <path d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z"></path>
                        </svg>
                        <label for="Facebook" class="dark:text-white">Facebook</label>
                        <input type="url" name="social_links[Facebook]" id="Facebook" class="bg-transparent text-text border-1 border-text rounded-lg p-2 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your Facebook  Link" value="">
                    </div>

                    <div id="github-link" class="relative 2xl:w-1/3">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 72 72" class="fill-text absolute top-7 left-2 h-10 dark:fill-gray-400">
                            <path d="M36,12c13.255,0,24,10.745,24,24c0,10.656-6.948,19.685-16.559,22.818c0.003-0.009,0.007-0.022,0.007-0.022	s-1.62-0.759-1.586-2.114c0.038-1.491,0-4.971,0-6.248c0-2.193-1.388-3.747-1.388-3.747s10.884,0.122,10.884-11.491	c0-4.481-2.342-6.812-2.342-6.812s1.23-4.784-0.426-6.812c-1.856-0.2-5.18,1.774-6.6,2.697c0,0-2.25-0.922-5.991-0.922	c-3.742,0-5.991,0.922-5.991,0.922c-1.419-0.922-4.744-2.897-6.6-2.697c-1.656,2.029-0.426,6.812-0.426,6.812	s-2.342,2.332-2.342,6.812c0,11.613,10.884,11.491,10.884,11.491s-1.097,1.239-1.336,3.061c-0.76,0.258-1.877,0.576-2.78,0.576	c-2.362,0-4.159-2.296-4.817-3.358c-0.649-1.048-1.98-1.927-3.221-1.927c-0.817,0-1.216,0.409-1.216,0.876s1.146,0.793,1.902,1.659	c1.594,1.826,1.565,5.933,7.245,5.933c0.617,0,1.876-0.152,2.823-0.279c-0.006,1.293-0.007,2.657,0.013,3.454	c0.034,1.355-1.586,2.114-1.586,2.114s0.004,0.013,0.007,0.022C18.948,55.685,12,46.656,12,36C12,22.745,22.745,12,36,12z"></path>
                        </svg>
                        <label for="Github" class="dark:text-white">Github</label>
                        <input type="url" name="social_links[Github]" id="Github" class="bg-transparent text-text border-1 border-text rounded-lg p-2 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your Github  Link" value="">
                    </div>

                    <div id="linkedin-link" class="relative 2xl:w-1/3">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" class="fill-text absolute top-8 left-3 h-8 dark:fill-gray-400">
                            <path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10 c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56 c3.97,0,7.19,2.73,7.19,8.26V39z"></path>
                        </svg>
                        <label for="LinkedIn" class="dark:text-white">LinkedIn</label>
                        <input type="url" name="social_links[LinkedIn]" id="LinkedIn" class="bg-transparent text-text border-1 border-text rounded-lg p-2 py-3 pl-12 w-full dark:border-gray-700 dark:text-gray-400" placeholder="Your LinkedIn  Link" value="">
                    </div>

                </div>
            </div>

            <div class="my-4 flex justify-between 2xl:w-1/3">
                <button id="cancel-user-btn" type="button" class="bg-white border-1 border-text px-6 rounded-lg dark:bg-transparent dark:text-gray-600 dark:border-gray-600" name="Edit" value="Cancel">Cancel</button>

                <button id="save-user-btn" type="submit" class="bg-black text-white border-1 border-text px-8 py-2 rounded-lg" name="Edit" value="Save">Save</button>
            </div>
        </div>
    </form>
</main>

<script type="module" src="../controllers/render&events/editprofile.js"></script>