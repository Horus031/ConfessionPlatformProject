<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl text-border">Edit your profile</h1>
    <hr class="border-1 border-secondary mt-2">

    <form action="../controllers/edit_userinfo.php" method="post" enctype="multipart/form-data">
        <div class="edit-container">
            <div class="mt-2">
                <h2 class="text-xl font-semibold">Profile Picture</h2>
                <p class="text-text font-semibold">Let's upload your picture so that everyone can recognize you</p>

                <div id="uploadimg-container" class="relative flex border-1 z-5 bg-none border-text rounded-full space-x-4 m-4 cursor-pointer md:mx-30 lg:mx-50 lg:space-x-12 2xl:w-1/3 2xl:mx-0">


                    <div id="img-child" class="mt-4">
                        <label for="avatarURL" class="block absolute w-full z-1 left-0 right-0 top-0 py-7 cursor-pointer rounded-full  text-text text-center ">
                            <input type="file" name="avatarURL" id="avatarURL" class="hidden">
                            <span id="file-name" class="ml-12"> Upload your image</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <h2 class="text-xl font-semibold">Account Information</h2>

                <div id="accountinfo-container" class="mt-2 space-y-4">
                    
                </div>
            </div>

            <div class="mt-2">
                <h2 class="text-xl font-semibold">Bio</h2>

                <div id="bio-container" class="mt-2 space-y-4">

                </div>
            </div>


            <div class="mt-2">
                <h2 class="text-xl font-semibold">Profile Social Link</h2>
                <p class="text-text font-semibold">Let’s give us some links to connect with you</p>

                <div id="social-container" class="mt-2 space-y-4">
                    
                    
                </div>
            </div>

            <div class="my-4 flex justify-between">
                <button class="bg-white border-1 border-text px-6 rounded-lg" name="Edit" value="Cancel">Cancel</button>

                <button type="submit" class="bg-black text-white border-1 border-text px-8 py-2 rounded-lg" name="Edit" value="Save">Save</button>
            </div>
        </div>
    </form>
</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer('#edit-container');
        const username = "<?=$_SESSION['username']?>";
        const avatarURL = "<?= isset($_SESSION['avatarURL']) ? $_SESSION["avatarURL"] : '../assets/images/user.png'; ?>";

        try {
            const editUserInfo = await renderer.fetchData('../controllers/get_userinfo.php');
            renderer.renderEditUser(editUserInfo, username, avatarURL);
        } catch (error) {
            console.error('Error loading data:', error);
        }
        
        
    })
</script>