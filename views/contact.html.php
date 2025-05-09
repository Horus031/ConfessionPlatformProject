<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[23%] 3xl:pl-[23%] 4xl:pl-[18%] 4xl:pr-[1%] bg-white dark:bg-gray-900">
    <h1 class="text-text text-2xl font-semibold lg:text-4xl dark:text-gray-400">Contact Us</h1>

    <form id="contactForm" class="mt-4 space-y-4 lg:w-1/2">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Name</label>
            <input type="text" id="name" name="name" required class="bg-transparent text-text mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
            <input type="email" id="email" name="email" required class="bg-transparent text-text mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Message</label>
            <textarea id="message" name="message" rows="4" required class="bg-transparent text-text mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"></textarea>
        </div>
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 cursor-pointer">Send Message</button>
    </form>

    <div id="formFeedback" class="mt-4"></div>
</main>

<script type="module" src="../controllers/render&events/contact.js"></script>