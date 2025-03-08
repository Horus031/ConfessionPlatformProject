<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl">Edit your post</h1>


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
            <h2 class="text-lg">Select modules</h2>
            <select name="moduleValues" id="modules" class="border-1 border-secondary rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9">
                
            </select>
        </div>

        <div class="text-right md:text-left">
            <button type="submit" class="bg-black text-white rounded-lg px-4 py-2 mt-4">
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
                    option.innerHTML = `${module.name}`;
                    modulesContainer.appendChild(option);
                });
            }
        });

        // Custom file input
        const fileInput = document.getElementById('imageURL');
        const fileName = document.getElementById('file-name');

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = 'Upload your image';
            }
        });
    })
</script>