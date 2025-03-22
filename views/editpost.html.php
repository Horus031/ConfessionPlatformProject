<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl">Edit your post</h1>


    <form id="edit-form" action="../controllers/editpost.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="postValues" id="post-value">
        <div class="mt-2 space-y-4">
            <input type="text" name="titleValue" id="title" class="border-1 border-text rounded-lg p-2 q px-4 w-full md:w-5/8 lg:w-4/9" placeholder="Post title">
        </div>

        <div class="mt-6 flex flex-col w-fit">
            <textarea name="contentValue" id="content" cols="40" rows="8" class="p-2 border-1 border-text rounded-lg" placeholder="Post content"></textarea>

            <div class="mt-4">
                <label for="imageURL" class="block py-1.5 px-3 cursor-pointer border-1 border-secondary rounded-md bg-[#f8f8f8] text-text text-center hover:bg-[#e8e8e8]">
                    <input type="file" name="imageURL" id="imageURL" class="hidden">
                    <span id="file-name" class="w-44 text-wrap line-clamp-1 m-auto">Upload your image</span>
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
                <option value="carrer">Career & Guidance</option>
            </select>

            <div class="flex items-center mt-4 space-x-6">
                <select name="tagList" id="tag-list" class="border-1 border-secondary rounded-lg py-1 px-4 overflow-y-scroll w-full  md:w-5/8 lg:w-4/9">

                </select>

                <div id="button-container" class="space-x-2 flex">
                    <button type="button" id="add-btn" class="bg-blue-500 p-2 rounded-md text-white">Add</button>
                    <button type="button" id="remove-btn" class="bg-red-500 p-2 rounded-md text-white">Remove</button>
                </div>
            </div>

            <div id="tag-container" class="mt-4">
                <input type="text" name="tagInput" id="tag-input" class="border-1 border-text-light rounded-lg py-1 px-4 w-full md:w-5/8 lg:w-4/9" readonly>
            </div>
        </div>

        <div class="mt-4 flex flex-col">
            <h2 class="text-lg">Select modules</h2>
            <select name="moduleValues" id="modules" class="border-1 border-secondary rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9">

            </select>
        </div>

        <div class="flex justify-between md:w-2/3 lg:w-4/9">
            <button id="cancel-btn" type="button" class="border border-black rounded-lg px-4 py-2 mt-4">
                Cancel
            </button>
            <button type="submit" name="submit" class="bg-black text-white rounded-lg px-4 py-2 mt-4">
                Save
            </button>
        </div>
    </form>

</main>

<script type="module">
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';
    document.addEventListener('DOMContentLoaded', async function() {
        const postId = sessionStorage.getItem('editPostId');
        const renderer = new QuestionRenderer(null, '#modules');

        try {
            const modules = await renderer.fetchData('../controllers/list_modules.php');
            renderer.renderModules(modules);

            if (!postId) {
                alert("There is no post for editing!");
                window.location.href = "../views/main.html.php?page=home"; // Chuyển về trang chính nếu không có post_id
                return;
            }

            const editPost = await renderer.fetchData('../controllers/get_postdetails.php', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    post_id: postId
                })
            })
            renderer.renderEditPosts(editPost, postId);

            renderer.renderTagsWithType();



        } catch (error) {
            console.error('Error loading data:', error);
        }

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
    })
</script>