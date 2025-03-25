<main class="mt-24 px-4 w-full md:mt-28 md:pl-[26%] lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%]">
    <div class="flex justify-between items-center transition-all">
        <div class="animate-slideRight">
            <h1 id="question-title" class="text-2xl font-semibold lg:text-4xl dark:text-gray-400">Questions</h1>
        </div>

        <div>
            <a href="main.html.php?page=newpost" id="add-btn" class="bg-black dark:text-gray-400 dark:border-1 dark:border-gray-400 dark:bg-transparent py-1 px-6 rounded-lg font-medium md:py-4 lg:text-2xl animate-slideLeft">Add question</a>
        </div>
    </div>
    <div>
        <div class="animate-slideRight transition-all">
            <h3 class="font-medium lg:text-3xl dark:text-gray-400">Total questions</h3>
            <p id="total-question" class="text-3xl lg:text-5xl dark:text-gray-400"></p>
        </div>

        <div class="animate-slideLeft">
            <h1 class="text-right text-text font-medium dark:text-gray-400">Module Filter</h1>
            <select id="question-filter" class="ml-auto w-fit py-1 px-2 border border-text dark:border-gray-600 dark:text-gray-400 flex justify-around rounded-md">
                <option value="all" selected class="dark:bg-gray-800">All</option>
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
        const eventListener = new EventListener(userId);
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('query');

        try {
            let questions;
            let questionType;
            if (query) {
                questionType = await renderer.fetchData(`../controllers/check_searchvalues.php?query=${encodeURIComponent(query)}`);
                questions = await renderer.fetchData(`../controllers/search_question.php?query=${encodeURIComponent(query)}`);
                console.log(questions);
                document.querySelector('#question-title').textContent = `Questions by ${questionType[0].type}`;
            } else {
                questions = await renderer.fetchData('../controllers/list_question.php');
                document.querySelector('#question-title').textContent = `Question`;
            }

            renderer.renderQuestions(questions, userId);
            document.querySelector('#total-question').textContent = `${questions.length}`;
            document.querySelectorAll('div[id^="question-"]').forEach(question => {
                question.classList.add('animate-postScale');
            });

            setTimeout(async () => {
                const modules = await renderer.fetchData('../controllers/list_modules.php');
                renderer.renderModules(modules);
            }, 100);

            eventListener.start();
        } catch (error) {
            console.error('Error loading data:', error);
        }

    });
</script>