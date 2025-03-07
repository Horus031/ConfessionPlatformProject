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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/get_userinfo.php')
        .then(response => response.json())
        .then(data => {
            const editContainer = document.querySelector('#edit-container');
            if (data.error) {
                editContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
            } else {
                const imageInput = document.querySelector('#uploadimg-container');
                const imageChildren = document.querySelector('#img-child');

                const accountInput = document.querySelector('#accountinfo-container');
                const bioInput = document.querySelector('#bio-container');
                const socialInput = document.querySelector('#social-container');

                const imageElements = document.createElement('img');
                imageElements.id = 'image';
                imageElements.classList.add('h-20', 'rounded-full');
                imageElements.src = "<?= isset($_SESSION['avatarURL']) ? $_SESSION["avatarURL"] : '../assets/images/user.png'; ?>";
                imageInput.insertBefore(imageElements, imageChildren);

                accountInput.innerHTML = `
                    <div class="relative">
                        <img src="../assets/images/name.png" alt="" class="absolute top-1/4 left-4 h-6">
                        <input type="text" name="usernameValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your username" value="<?=$_SESSION['username']?>">
                    </div>
                    <div class="relative">
                        <img src="../assets/images/username.png" alt="" class="absolute top-1/4 left-4 h-6">
                        <input type="text" name="tagnameValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your tagname" value="${data[0].tag_name ?? ''}">
                    </div>
                    <div class="relative">
                        <img src="../assets/images/email.png" alt="" class="absolute top-1/4 left-4 h-6">
                        <input type="text" name="emailValue" id="" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your email" value="${data[0].email ?? ''}">
                    </div>
                `;

                const bioElement = document.createElement('textarea');
                bioElement.name = 'bioValue';
                bioElement.placeholder = 'Your bio...';
                bioElement.cols = '40';
                bioElement.rows = '8';
                bioElement.classList.add('border-1', 'border-text', 'p-2', 'rounded-lg');

                bioInput.appendChild(bioElement);

                data.forEach(link => {
                    const socialLinkBox = document.createElement('div');
                    socialLinkBox.classList.add('relative');
                    socialLinkBox.innerHTML = `
                        <img src="../assets/images/facebook.png" alt="" class="absolute top-1/2 left-4 h-6">
                        <label for="${link.platform}">${link.platform}</label>
                        <input type="url" name="social_links[${link.platform}]" id="${link.platform}" class="border-1 border-text rounded-lg p-2 py-3 pl-12 w-full" placeholder="Your ${link.platform.toUpperCase()}  Link" value="${link.url}">
                    `; 

                    socialInput.appendChild(socialLinkBox);
                })
            }
        })

        const fileInput = document.getElementById('avatarURL');
        const fileName = document.getElementById('file-name');

        fileInput.addEventListener('change', function() {
            setTimeout(function() {
                if (fileInput.files.length > 0) {
                    const image = document.getElementById('image');
                    const file = fileInput.files[0];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        image.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                    fileName.textContent = file.name;
                } else {
                    fileName.textContent = 'Upload your image';
                }
            }, 1000);
        });
    })
</script>