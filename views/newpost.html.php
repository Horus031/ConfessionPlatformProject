<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl">New post</h1>


    <form id="newpost-form" action="../controllers/add_newpost.php" method="post" enctype="multipart/form-data">
        <div class="mt-2 space-y-4">
            <input type="text" name="titleValue" id="title" class="border-1 border-text rounded-lg p-2 q px-4 w-full md:w-5/8 lg:w-4/9" placeholder="Post title">
        </div>

        <div class="mt-6 flex flex-col w-fit">
            <textarea name="contentValue" id="content" cols="40" rows="8" class="p-2 border-1 border-text rounded-lg" placeholder="Post content"></textarea>

            <div class="mt-4">
                <label for="imageURL" class="block py-1.5 px-3 cursor-pointer border-1 border-secondary rounded-md bg-[#f8f8f8] text-text text-center hover:bg-[#e8e8e8]">
                    <input type="file" name="imageURL" id="imageURL" class="hidden">
                    <span id="file-name">Upload your image</span>
                </label>
            </div>
        </div>

        <div class="mt-4 flex flex-col">
            <label for="select-tag-type">Select your tag here</label>
            <select name="selectTagType" id="select-tag-type" class="border-1 border-secondary rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9">
                <option value="" selected></option>
                <option value="general">General Subject</option>
                <option value="prog&tech">Programming & Technology</option>
                <option value="study">Study Tips</option>
                <option value="career">Career & Guidance</option>
            </select>

            <div class="flex items-center mt-4 space-x-6">
                <select name="tagList" id="tag-list" class="border-1 border-secondary rounded-lg py-1 px-4 overflow-y-scroll md:w-5/8 lg:w-4/9 hidden">
                    
                </select>

                <div id="button-container" class="space-x-2 hidden">
                    <button type="button" id="add-btn" class="bg-blue-500 p-2 rounded-md text-white">Add</button>
                    <button type="button" id="remove-btn" class="bg-red-500 p-2 rounded-md text-white">Remove</button>
                </div>
            </div>

            <div id="tag-container" class="mt-4">
                <input type="text" name="tagInput" id="tag-input" class="border-1 border-text-light hidden rounded-lg py-1 px-4 md:w-5/8 lg:w-4/9" readonly>
            </div>
        </div>

        <div class="mt-4 flex flex-col">
            <h2 class="text-lg">Select modules</h2>
            <select name="moduleValues" id="modules" class="border-1 border-secondary rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9">
                
            </select>
        </div>

        <div class="text-right md:text-left">
            <button type="submit" name="submit" class="bg-black text-white rounded-lg px-4 py-2 mt-4">
                Post
            </button>
        </div>
    </form>
    
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        

        fetch('../controllers/list_modules.php')
        .then(response => response.json())
        .then(data => {
            const modulesContainer = document.querySelector('#modules');
            if (data.error) {
                container.innerHTML = `<p class="text-red-500">${data.error}</p>`;
            } else {
                data.forEach(module => {
                    const option = document.createElement('option');
                    option.setAttribute('value', `${module.module_id}`);
                    option.innerHTML = `${module.module_name}`;
                    modulesContainer.appendChild(option);
                });
            }
        });

        // Custom ô hình ảnh
        const fileInput = document.querySelector('#imageURL');
        const fileName = document.querySelector('#file-name');

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = 'Upload your image';
            }
        });

        // Tạo logic chọn tag
        const selectTagType = document.querySelector('#select-tag-type');
        const buttonContainer = document.querySelector('#button-container');
        const tagList = document.querySelector('#tag-list');
        const tagInput = document.querySelector('#tag-input');
        selectTagType.addEventListener('change', function() {
            let selectedValue = selectTagType.value;
            
            while (tagList.firstChild) {
                tagList.removeChild(tagList.firstChild);
            }

            fetch('../controllers/tags_withtype.php', {
                method: 'POST',
                header: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ type: selectedValue })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    tagList.innerHTML = `<option>${data.error}</option>`
                } else {
                    if (selectedValue == '') {
                        tagList.classList.add('hidden');
                        buttonContainer.classList.add('hidden');
                        tagInput.classList.add('hidden');
                    } else {
                        tagList.classList.remove('hidden');
                        buttonContainer.classList.remove('hidden');
                        tagInput.classList.remove('hidden');
                        data.forEach(tag => {
                            const tagElement = document.createElement('option');
                            tagElement.value = `${tag.tag_name}`;
                            tagElement.textContent = `${tag.tag_name}`;
                            tagList.appendChild(tagElement);
                        })
                    }
                }
            })
        })

        // Tạo tương tác giữa nút thêm và xóa tag

        buttonContainer.addEventListener('click', function(e) {
            if (e.target.closest('button[id="add-btn"]')) {
                const selectedTag = tagList.value;
                const currentTags = tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag !== '');

                if (currentTags.includes(selectedTag)) {
                    console.log('You cannot duplicate the tag!');
                } else {
                    currentTags.push(selectedTag);
                    tagInput.value = currentTags.join(', ');
                }

            } else if (e.target.closest('button[id="remove-btn"]')) {
                const selectedTag = tagList.value;
                let currentTags = tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag !== '');

                currentTags = currentTags.filter(tag => tag !== selectedTag);
                tagInput.value = currentTags.join(', ');
            }
        });

    })
</script>