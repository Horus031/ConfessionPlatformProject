<main class="mt-28 w-full px-4 md:pl-[26%] lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <div id="profile-container" class="flex flex-col md:flex-row md:items-center">
        <div class="flex  justify-between items-start px-2 space-y-4 md:flex-col md:items-center md:justify-start bg-white z-30">
            <img src="<?= isset($_SESSION['avatarURL']) ? $_SESSION["avatarURL"] : '../assets/images/user.png';?>" alt="" aspect-ratio="1/1" class="h-30 w-30 rounded-full">

            <a href="main.html.php?page=editprofile" class="border-1 border-secondary rounded-lg px-3 py-1 font-semibold cursor-pointer">Edit profile</a>
        </div>

        <div class="space-y-2 mt-1">
            <div id="info-container" class="flex flex-col space-y-2 animate-infoSlide">
                <h2 class="text-2xl my-1"><?=$_SESSION['username']?></h2>
                

                
            </div>
        </div>
    </div>

    <div id="bio-container" class="mt-4 animate-fadeIn">

    </div>

    <div class="mt-4 space-y-2 transition-all">
        <h2 class="font-medium animate-fadeIn">Top tags by reading days</h2>
        <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg animate-slideRight ">
            <div class="flex justify-between text-sm">
                <span class="text-sm text-text-light font-semibold">#frondend</span>
                <span class="font-semibold">80%</span>
            </div>
            <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
        </div>
        <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg animate-slideRight ">
            <div class="flex justify-between text-sm">
                <span class="text-sm text-text-light font-semibold">#frondend</span>
                <span class="font-semibold">80%</span>
            </div>
            <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
        </div>
        <div class="relative border-1 border-secondary w-56 p-2 rounded-xl shadow-lg animate-slideRight ">
            <div class="flex justify-between text-sm">
                <span class="text-sm text-text-light font-semibold">#frondend</span>
                <span class="font-semibold">80%</span>
            </div>
            <span class="absolute w-8/12 h-[2px] border-2 border-[#4CAF50] left-1.5 rounded-2xl -bottom-0.5"></span>
        </div>
        
    </div>

    <div  class="mt-4 font-medium">
        <h2 class="animate-fadeIn">Your posts</h2>
        <div id="mypost-container" class="grid w-full lg:grid-cols-2 2xl:grid-cols-3 gap-4">
            
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/get_userinfo.php')
        .then(response => response.json())
        .then(data => {
            const profileContainer = document.querySelector('#info-container');
            const bioContainer = document.querySelector('#bio-container');
            let hasLinks = false;
            if (data.error) {
                profileContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
            } else {
                console.log(data);
                const profileElements = document.createElement('div');
                profileElements.classList.add('flex', 'flex-col', 'space-y-2');

                const createdAt = new Date(data[0].created_at);
                const formattedDate = createdAt.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });

                profileElements.innerHTML = `
                        <div>
                            <span class="text-text font-medium">@${data[0].tag_name ?? ''}</span>
                            <span class="text-text">•</span>
                            <span class="text-text-light font-medium">Joined ${formattedDate}</span>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <div>
                                <span>0</span>
                                <span class="text-text">Followers</span>

                                <span>0</span>
                                <span class="text-text">Following</span>
                            </div>

                            <div>
                                <span>0</span>
                                <span class="text-text">Views</span>

                                <span>0</span>
                                <span class="text-text">Likes</span>
                            </div>
                        </div>                
                `;

                const socialContainer = document.createElement('div');
                socialContainer.classList.add('space-x-2');
                data.forEach(link => {
                    if (link.url && link.platform) {
                        const socialLink = document.createElement('a');
                        socialLink.href = link.url;
                        socialLink.target = '_blank';
                        socialLink.classList.add('border-1', 'border-secondary', 'rounded-xl', 'px-4', 'py-1', 'font-semibold');
                        socialLink.textContent = `@${link.platform}`;
                        socialContainer.appendChild(socialLink);
                    }
                });

                const bioContext = document.createElement('span');
                bioContext.classList.add('font-semibold', 'text-text-light');
                bioContext.textContent = `${data[0].bio}`;

                bioContainer.appendChild(bioContext);

                
                profileElements.appendChild(socialContainer);
                profileContainer.appendChild(profileElements);
            }
        });


        fetch('../controllers/list_question.php')
        .then(response => response.json())
        .then(data => {
            const mypostContainer = document.querySelector('#mypost-container');
            let hasPosts = false;
            if (data.error) {
                mypostContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
            } else {
                console.log(data);
                data.forEach(myPost => {
                    if (myPost.user_id == <?= $_SESSION['user_id'] ?>) {
                        hasPosts = true;
                        const mypostElements = document.createElement('div');
                        mypostElements.classList.add('flex', 'items-center', 'justify-between', 'border-2', 'border-secondary', 'mt-2', 'p-4', 'rounded-lg', 'w-full', 'hover:border-black', 'cursor-pointer' ,'animate-slideRight' ,'transition-all');
                        mypostElements.innerHTML = `
                            <div class="space-y-2">
                                <h2 class="font-semibold text-xl line-clamp-2">${myPost.post_title}</h2>
                                <p class="text-sm text-text-light font-medium">${myPost.post_content}</p>
                                <div class="flex items-center w-fit justify-around border-2 border-secondary rounded-xl p-2 ">
                                    <div class="flex items-center space-x-2 text-text font-medium px-2">
                                        <img src="../assets/images/like.png" alt="" class="h-6">
                                        <span>${myPost.likes}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-text font-medium px-2">
                                        <img src="../assets/images/comments.png" alt="" class="h-6">
                                        <span>${myPost.comments}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-2 border-gray-200 rounded-md">
                                <img loading="lazy" src="${myPost.imageURL}" alt="" class="rounded-md h-30 w-30 md:w-60 md:h-40 2xl:h-50">
                            </div>
                            
                        `;

                        mypostElements.addEventListener('click', function() {
                            window.location.href = `../views/main.html.php?page=postdetails&id=${myPost.post_id}`;
                        })

                        mypostContainer.appendChild(mypostElements);
                    }

                    if (!hasPosts) {
                        mypostContainer.innerHTML = ``;
                    }
                })
            }
        })
    })
</script>