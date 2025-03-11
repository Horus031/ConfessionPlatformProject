<main class="mt-24 px-4 w-full md:pl-[26%] lg:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <div class="flex justify-between items-center transition-all">
        <div class="animate-slideRight">
            <h1 class="text-2xl font-semibold lg:text-4xl">Questions</h1>
        </div>

        <div>
            <button class="bg-black text-white py-1 px-6 rounded-lg font-medium md:py-4 lg:text-2xl animate-slideLeft">Add question</button>
        </div>
    </div>
    <div>
        <div class="animate-slideRight transition-all">
            <h3 class="font-medium lg:text-3xl">Total questions</h3>
            <p id="total-question" class="text-3xl lg:text-5xl">2</p>
        </div>

        <div class="animate-slideLeft"">
            <h1 class="text-right text-text font-medium">Filter</h1>
            <select id="question-filter" class="ml-auto w-fit py-1 border border-text flex justify-around rounded-md">
                <option value="" selected>All</option>
            </select>
        </div>
    </div>


    <div id="question-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/list_question.php')
        .then(response => response.json())
        .then(data => {
            const questionContainer = document.querySelector('#question-container');
            if (data.error) {
                console.log(data.error)
            } else {
                document.querySelector('#total-question').textContent = `${data.length}`;

                data.forEach(question => {
                    const questionElement = document.createElement('div');
                    questionElement.classList.add('mt-2', 'border-2', 'p-4', 'rounded-md', 'border-gray-200', 'cursor-pointer', 'hover:border-black', 'animate-postScale');
                    questionElement.id = `value-${question.post_id}`;
                    questionElement.setAttribute('data-value', `${question.post_id}`);
                    questionElement.innerHTML = `
                        <div class="flex flex-col">
                            <span id="module-title" data-value=${question.module_id} class="w-fit rounded-full text-xs ${question.bg_class} ${question.text_class} px-2 font-medium">${question.module_name}</span>

                            <h2 class="mt-3 font-semibold text-lg w-56">${question.post_title}</h2>

                            <p class="mt-3 text-xs text-text-light font-medium">${question.post_content}</p>

                            <div class="mt-3 border-2 border-gray-200 rounded-md">
                                <img loading="lazy" src="${question.imageURL}" alt="" width="100%" height="100px" class="rounded-md">
                            </div>
                            
                            <div class="flex justify-between items-center mt-3">
                                <div class="flex items-center space-x-2">
                                    <img loading="lazy" src="${question.avatar ? question.avatar : '../assets/images/user.png'}" alt="" class="h-10 rounded-full">
                                    <span class="text-xs">${question.username}</span>
                                    <span class="text-xs">${new Date(question.created_at).toLocaleString()}</span>
                                </div>
                                <div id="tags-container-${question.post_id}" class="flex items-center space-x-2 text-sm">
                                    
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-3">
                                <div class="flex justify-between w-fit border-2 border-text-light rounded-md space-x-2">
                                    <button id="likes-btn" class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                                        <img loading="lazy" src="../assets/images/like.png" alt="" class="h-10 p-2">
                                        <span>${question.likes}</span>
                                    </button>
                                    <button id="comment-btn" class="flex items-center px-2 rounded-md hover:bg-gray-300 w-full transition-all">
                                        <img loading="lazy" src="../assets/images/comments.png" alt="" class="h-10 p-2">
                                        <span>${question.comments}</span>
                                    </button>
                                </div>

                                <div class="flex items-center space-x-2 ">
                                    <button id="save-btn" class="rounded-md hover:bg-gray-300 transition-all">
                                        <img loading="lazy" src="../assets/images/bookmark.png" alt="" class="h-10 p-2">
                                    </button>
                                    <button id="link-btn" class="rounded-md hover:bg-gray-300 transition-all">
                                        <img loading="lazy" src="../assets/images/link.png" alt="" class="h-10 p-2">
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    questionElement.addEventListener('click', function(e) {
                        let button = e.target.closest('button');
                        let anchor = e.target.closest('a');
                        if (!button) {
                            window.location.href = `../views/main.html.php?page=postdetails&id=${question.post_id}`;
                        }
                        switch (true) {
                            case button.id == "likes-btn":
                                console.log('likes');
                                break;
                            case button.id == "comment-btn":
                                console.log('comment');
                                break;
                            case button.id == "save-btn":
                                console.log('bookmark');
                                break;
                            case button.id == "links-btn":
                                console.log('link-btn');
                                break;
                            case button.id == "view-btn":
                                window.location.href = `../views/main.html.php?page=postdetails&id=${question.post_id}`;
                                break;
                            case button.id == "edit-btn":
                                const postId = questionElement.getAttribute('data-value');

                                sessionStorage.setItem('editPostId', postId);
                                window.location.href = '../views/main.html.php?page=editpost';
                                break;
                        }
                    })

                    questionContainer.appendChild(questionElement);
                });

                fetch('../controllers/get_posttags.php')
                .then(response => response.json())
                .then(tagsData => {
                    if (tagsData.error) {
                        tagContainer.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                    } else {
                        tagsData.forEach(tag => {
                            const tagContainer = document.querySelector(`#tags-container-${tag.post_id}`);
                            if (tagContainer) {
                                const existingTags = tagContainer.querySelectorAll('span');
                                if (existingTags.length === 0) {
                                    const tagElement = document.createElement('span');
                                    tagElement.classList.add('bg-tags', 'p-1', 'rounded-md');
                                    tagElement.textContent = `#${tag.tag_name}`;
                                    tagContainer.appendChild(tagElement);
                                } else {
                                    const additionalTags = tagContainer.querySelector('.additional-tags');
                                    const tagPopup = document.querySelector('#tags-popup');
                                    if (additionalTags) {
                                        const count = parseInt(additionalTags.getAttribute('data-count')) + 1;
                                        const tagSpan = document.querySelector('#tag-count');
                                        additionalTags.setAttribute('data-count', count);
                                        tagSpan.textContent = `+${count}`;


                                        const additionalTagPopup = document.createElement('span');
                                        additionalTagPopup.classList.add('p-2')
                                        additionalTagPopup.textContent = `#${tag.tag_name}`;
                                        tagPopup.appendChild(additionalTagPopup);

                                    } else {
                                        const additionalTagElement = document.createElement('div');

                                        additionalTagElement.classList.add('relative', 'group', 'bg-tags', 'p-1', 'rounded-md', 'additional-tags');
                                        additionalTagElement.setAttribute('data-count', 1);
                                        additionalTagElement.innerHTML = `
                                            <span id="tag-count">+1</span>

                                            <div id="tags-popup" class="absolute space-y-2 bg-tags p-2 rounded-md right-1 top-8 shadow-lg hidden group-hover:block before:absolute before:content-[''] before:bg-black before:-top-2 before:w-6 before:h-3 before:right-0 before:bg-transparent">
                                                <span class="p-2">#${tag.tag_name}</span>
                                            </div>
                                        `;
                                        tagContainer.appendChild(additionalTagElement);
                                    }
                                }
                            }
                        });
                    }
                })

                fetch('../controllers/list_modules.php')
                .then(response => response.json())
                .then(data => {
                    const filterContainer = document.querySelector('#question-filter');
                    if (data.error) {
                        filterContainer.innerHTML = `${data.error}`;
                    } else {
                        data.forEach(module => {
                            const option = document.createElement('option');
                            option.value = `${module.module_id}`;
                            option.textContent = `${module.module_name}`;

                            filterContainer.appendChild(option);
                        })

                        const questionElement = document.querySelectorAll('div[id^="value-"]');
                        filterContainer.addEventListener('input', function() {
                            if (filterContainer.value == "") {
                                questionElement.forEach(question => {
                                    question.classList.remove('hidden');
                                })
                            } else {
                                questionElement.forEach(question => {
                                    const moduleName = question.querySelector('#module-title');
                                    const moduleValue = moduleName.getAttribute('data-value');
                                    if (moduleValue == filterContainer.value) {
                                        question.classList.remove('hidden');
                                    } else {
                                        question.classList.add('hidden');
                                    }
                                })
                            }

                            
                        })
                    }
                    
                })
            }
        })

        
    })


</script>