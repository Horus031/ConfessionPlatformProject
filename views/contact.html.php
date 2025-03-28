<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <h1 class="text-2xl font-semibold lg:text-4xl dark:text-gray-400">Contact Us</h1>

    <form id="contactForm" class="mt-4 space-y-4 lg:w-1/2">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Name</label>
            <input type="text" id="name" name="name" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
            <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Message</label>
            <textarea id="message" name="message" rows="4" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"></textarea>
        </div>
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500">Send Message</button>
    </form>

    <div id="formFeedback" class="mt-4"></div>
</main>

<script type="module">
    import EventListener from '../src/js/events.js';
    import QuestionRenderer from '../src/js/render.js';

    const userId = <?= $_SESSION['user_id'] ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const eventListener = new EventListener(userId);

        eventListener.start();
    })

    document.getElementById('contactForm').addEventListener('submit', async function(event) {
        const renderer = new QuestionRenderer();
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const formFeedback = document.getElementById('formFeedback');

        try {
            const response = await renderer.fetchData('../controllers/send_message.php', {
                method: 'POST',
                body: formData
            })

            const result = typeof response === 'string' ? JSON.parse(response) : response;
            try {
                if (result.success) {
                    formFeedback.textContent = 'Message sent successfully! Thank you for contacting us.';
                    formFeedback.classList.add('text-green-500');
                    form.reset();

                    setTimeout(function() {
                        formFeedback.textContent = '';
                    }, 3000)
                } else {
                    formFeedback.textContent = 'Failed to send message. Please try again.';
                    formFeedback.classList.add('text-red-500');

                    setTimeout(function() {
                        formFeedback.textContent = '';
                    }, 3000)
                }
            } catch (error) {
                console.error('Invalid JSON response:', result);
                formFeedback.textContent = 'An error occurred. Please try again.';
                formFeedback.classList.add('text-red-500');
            }

        } catch (error) {
            console.log(error);
            formFeedback.textContent = 'An error occurred. Please try again.';
            formFeedback.classList.add('text-red-500');
        }
    });
</script>