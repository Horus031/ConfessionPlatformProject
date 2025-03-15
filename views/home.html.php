<main class="flex flex-col overflow-hidden px-2 mt-24 items-end w-full md:pl-[2%] lg:mt-28 2xl:pl-0">
    <div class="flex justify-between w-full items-center rounded-xl p-3 bg-linear-160 z-30 from-[#4CAF50] via-[#A5B82C] to-[#FFC107] md:w-3/4 lg:w-5/6 lg:px-8 animate-postSlideIn transition-all">
        <div class="md:w-72 lg:w-96 animate-fadeIn">
            <h1 class="text-2xl text-white font-bold leading-10 lg:leading-15 lg:text-6xl">Welcome to Knowledge Nexus, <?= isset($_SESSION['username']) ? $_SESSION["username"] : 'Users'; ?></h1>
            <button id="addques-btn" class="bg-black text-white font-medium rounded-xl py-1.5 px-8 mt-4 cursor-pointer">Add question</button>
        </div>
        <div class="animate-fadeIn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" class="-m-10 h-44 md:h-72 lg:h-96">
                <!-- Background -->
                <rect width="300" height="300" fill="white" opacity="0" />

                <!-- Gradient definitions -->
                <defs>
                    <linearGradient id="centralGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#2962FF" />
                        <stop offset="100%" stop-color="#1E88E5" />
                    </linearGradient>

                    <linearGradient id="node1Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#43A047" />
                        <stop offset="100%" stop-color="#2E7D32" />
                    </linearGradient>

                    <linearGradient id="node2Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#FB8C00" />
                        <stop offset="100%" stop-color="#EF6C00" />
                    </linearGradient>

                    <linearGradient id="node3Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#E53935" />
                        <stop offset="100%" stop-color="#C62828" />
                    </linearGradient>

                    <linearGradient id="node4Gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8E24AA" />
                        <stop offset="100%" stop-color="#6A1B9A" />
                    </linearGradient>

                    <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
                        <feGaussianBlur stdDeviation="5" result="blur" />
                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                    </filter>
                </defs>

                <!-- Connection lines with animation -->
                <line x1="150" y1="150" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="3s" repeatCount="indefinite" />
                </line>
                <line x1="250" y1="150" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="2.5s" repeatCount="indefinite" />
                </line>
                <line x1="150" y1="250" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="3.5s" repeatCount="indefinite" />
                </line>
                <line x1="250" y1="250" x2="200" y2="200" stroke="#666666" stroke-width="6" stroke-linecap="round" opacity="0.7">
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="4s" repeatCount="indefinite" />
                </line>

                <!-- Outer ring -->
                <circle cx="200" cy="200" r="110" fill="none" stroke="#2196F3" stroke-width="4" stroke-opacity="0.3" />

                <!-- Middle ring with pulse animation -->
                <circle cx="200" cy="200" r="90" fill="none" stroke="#2196F3" stroke-width="3" stroke-opacity="0.5">
                    <animate attributeName="r" values="85;95;85" dur="4s" repeatCount="indefinite" />
                    <animate attributeName="stroke-opacity" values="0.3;0.6;0.3" dur="4s" repeatCount="indefinite" />
                </circle>

                <!-- Inner ring -->
                <circle cx="200" cy="200" r="75" fill="none" stroke="#2196F3" stroke-width="2" stroke-opacity="0.7" />

                <!-- Nodes (representing knowledge sources) -->
                <circle cx="150" cy="150" r="28" fill="url(#node1Gradient)" filter="url(#glow)" />
                <circle cx="250" cy="150" r="28" fill="url(#node2Gradient)" filter="url(#glow)" />
                <circle cx="150" cy="250" r="28" fill="url(#node3Gradient)" filter="url(#glow)" />
                <circle cx="250" cy="250" r="28" fill="url(#node4Gradient)" filter="url(#glow)" />

                <!-- Central hub with glow effect -->
                <circle cx="200" cy="200" r="45" fill="url(#centralGradient)" filter="url(#glow)" />

                <!-- K letter stylized in the center -->
                <path d="M185,180 L185,220 M185,200 L215,180 M185,200 L215,220" transform="translate(-10, 0)" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />

                <!-- N letter stylized representing connectivity -->
                <path d="M225,180 L225,220 M225,180 L245,220 M245,180 L245,220" transform="translate(-20,0)" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div id="question-container" class="grid w-full md:grid-cols-2 lg:grid-cols-3 gap-4 md:w-3/4 lg:w-5/6 animate-postSlideIn transition-all">



    </div>
</main>

<script type="module">
    const userId = <?= $_SESSION['user_id'] ?>;
    import QuestionRenderer from '../src/js/render.js';
    import EventListener from '../src/js/events.js';
    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer('#question-container');
        const eventListener = new EventListener();
        const addQuestionButton = document.querySelector('#addques-btn');

        if (addQuestionButton) {
            addQuestionButton.addEventListener('click', function() {
                window.location.href = '../views/main.html.php?page=newpost';
            });
        }

        try {
            const questions = await renderer.fetchData('../controllers/list_question.php');
            renderer.renderQuestions(questions, userId);
            const tags = await renderer.fetchData('../controllers/get_posttags.php');
            renderer.renderTagsForPost(tags);


            eventListener.start();
        } catch (error) {
            console.error('Error loading data:', error);
        }
    });
</script>