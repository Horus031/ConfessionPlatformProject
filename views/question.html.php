<main class="mt-24 px-4 w-full md:pl-[26%] lg:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <div class="flex justify-between items-center transition-all">
        <div class="animate-slideRight">
            <h1 class="text-2xl font-semibold lg:text-4xl">Questions</h1>
        </div>

        <div>
            <a href="main.html.php?page=newpost" id="add-btn" class="bg-black text-white py-1 px-6 rounded-lg font-medium md:py-4 lg:text-2xl animate-slideLeft">Add question</a>
        </div>
    </div>
    <div>
        <div class="animate-slideRight transition-all">
            <h3 class="font-medium lg:text-3xl">Total questions</h3>
            <p id="total-question" class="text-3xl lg:text-5xl">2</p>
        </div>

        <div class="animate-slideLeft">
            <h1 class="text-right text-text font-medium">Filter</h1>
            <select id="question-filter" class="ml-auto w-fit py-1 border border-text flex justify-around rounded-md">
                <option value="" selected>All</option>
            </select>
        </div>
    </div>


    <div id="question-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">

    </div>
</main>

<script type="module">
    const userId = <?= $_SESSION['user_id'] ?>;
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';

    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer('#question-container', '#question-filter');
        const eventListener = new EventListener();

        try {
            const questions = await renderer.fetchData('../controllers/list_question.php');
            renderer.renderQuestions(questions, userId);
            document.querySelector('#total-question').textContent = `${questions.length}`;
            document.querySelectorAll('div[id^="question-"]').forEach(question => {
                question.classList.add('animate-postScale');
            })

            // Add a delay to ensure the elements are rendered before calling renderTags
            setTimeout(async () => {
                const tags = await renderer.fetchData('../controllers/get_posttags.php');
                renderer.renderTagsForPost(tags);

                const modules = await renderer.fetchData('../controllers/list_modules.php');
                renderer.renderModules(modules);
            }, 100); // Adjust the delay as needed
        } catch (error) {
            console.error('Error loading data:', error);
        }

        eventListener.start();
    });
</script>
