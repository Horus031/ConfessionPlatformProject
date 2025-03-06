<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl text-border">Edit your profile</h1>
    <hr class="border-1 border-secondary mt-2">

    <div class="mt-2">
        <h2 class="text-xl font-semibold">Profile Picture</h2>
        <p class="text-text font-semibold">Let's upload your picture so that everyone can recognize you</p>

        <div class="flex border-1 border-text rounded-full space-x-4 m-4 cursor-pointer md:mx-30 lg:mx-50 lg:space-x-12 2xl:w-1/3 2xl:mx-0">
            <img src="../assets/images/user.png" alt="" class="h-20">

            <div class="flex items-center space-x-2">
                <img src="../assets/images/camera.png" alt="" class="h-6">

                <span>Choose your image</span>
            </div>
        </div>
    </div>

    <div class="mt-2">
        <h2 class="text-xl font-semibold">Account Information</h2>

        <div class="mt-2 space-y-4">
            <div class="relative">
                <img src="../assets/images/name.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="nameValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your name">
            </div>
            <div class="relative">
                <img src="../assets/images/username.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="usernameValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your username">
            </div>
            <div class="relative">
                <img src="../assets/images/email.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="emailValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your email">
            </div>
        </div>
    </div>

    <div class="mt-2">
        <h2 class="text-xl font-semibold">Bio</h2>

        <div class="mt-2 space-y-4">
            <textarea name="bioValue" id="" placeholder="Your bio..." cols="40" rows="8" class="border-1 border-text p-2 rounded-lg"></textarea>
        </div>
    </div>


    <div class="mt-2">
        <h2 class="text-xl font-semibold">Profile Social Link</h2>
        <p class="text-text font-semibold">Let’s give us some links to connect with you</p>

        <div class="mt-2 space-y-4">
            <div class="relative">
                <img src="../assets/images/github.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="githubLink" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your Github Link">
            </div>
            <div class="relative">
                <img src="../assets/images/linkedin.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="LinkedInLink" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your LinkedIn Link">
            </div>
            <div class="relative">
                <img src="../assets/images/link.png" alt="" class="absolute top-1/4 left-4 h-6">
                <input type="text" name="websiteLink" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your Website Link">
            </div>
        </div>
    </div>

    <div class="my-4 flex justify-between">
        <button class="bg-white border-1 border-text px-6 rounded-lg">Cancel</button>

        <button class="bg-black text-white border-1 border-text px-8 py-2 rounded-lg">Save</button>
    </div>
</main>

<script>
    
</script>