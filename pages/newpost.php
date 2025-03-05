<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl">New post</h1>

    <div class="mt-2 space-y-4">
        <input type="text" name="titleValue" id="" class="border-1 border-text rounded-lg p-2 q px-4 w-full md:w-5/8 lg:w-4/9" placeholder="Post title">
    </div>

    <div class="mt-6">
        <textarea name="contentValue" id="" cols="40" rows="8" class="p-2 border-1 border-text rounded-lg" placeholder="Post content"></textarea>
    </div>

    <div class="mt-4 flex flex-col">
        <h2 class="text-lg">Select modules</h2>
        <select name="moduleValues" id="" class="border-1 border-secondary rounded-lg py-1 px-4 mt-4 md:w-5/8 lg:w-4/9">
            <option value="1">Module 1</option>
            <option value="2">Module 2</option>
            <option value="3">Module 3</option>
            <option value="4">Module 4</option>
            <option value="5">Module 5</option>
        </select>
    </div>

    <div class="text-right md:text-left">
        <button class="bg-black text-white rounded-lg px-4 py-2 mt-4">
            Post
        </button>
    </div>
</main>