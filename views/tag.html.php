<main class="mt-24 px-4 w-full md:pl-[26%] md:mt-28 lg:pl-[20%] xl:pl-[20%] 2xl:pl-[16%] transition-all">
    <h1 class="text-2xl font-semibold lg:text-4xl animate-postSlideIn transition-all">Tags</h1>

    <div class="mt-4 space-y-4 transition-all">
        <div class="relative flex animate-postSlideIn">
            <img src="../assets/images/magnify.png" alt="" class="absolute h-6 left-4 top-1/5">
            <input type="text" name="tagInput" id="" placeholder="Search tags by name" class="border-1 border-secondary rounded-lg pl-12 p-2 flex-1">
        </div>

        <div class="flex flex-col items-end animate-postSlideIn">
            <h4 class="text-right font-medium">Filters</h4>

            <div class="border border-text rounded-md text-right w-fit ">
                <select name="filter-tags" id="filter-tags" class="w-fit p-2 font-medium">
                    <option value="all">All</option>
                    <option value="general">General Subject</option>
                    <option value="prog&tech">Programming & Technology</option>
                    <option value="study">Study & Productivity</option>
                    <option value="career">Career & Guidance</option>
                </select>
            </div>
        </div>

        <div id="tags-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-2 p-2 mt-2">
            
        </div>
    </div>
</main>
<script type="module">
    import QuestionRenderer from '../src/js/render.js';

    document.addEventListener('DOMContentLoaded', async function() {
        const renderer = new QuestionRenderer('#tags-container');

        try {
            const tags = await renderer.fetchData('../controllers/list_tags.php');
            renderer.renderTags(tags);
            renderer.filterTags();
        } catch (error) {
            console.error('Error loading data:', error);
        }
    });
</script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/list_tags.php')
        .then(response => response.json())
        .then(data => {
            const tagContainer = document.querySelector('#tags-container');
            if (data.error) {
                tagContainer.innerHTML = `${data.error}`;
            } else {
                data.forEach(tag => {
                    const tagElement = document.createElement('div');
                    tagElement.id = `tag-${tag.tag_id}`;
                    tagElement.classList.add('border', 'border-gray-300', 'rounded-md', 'p-4', 'tag-element', 'animate-postSlideIn');
                    tagElement.innerHTML = `
                        <input id="tag-value" type="hidden" value="${tag.tag_type}">
                        <span class="w-fit rounded-full bg-gray-300 px-2 text-sm font-medium">#${tag.tag_name}</span>
                        <p class="text-sm mt-4 text-text-light font-normal">${tag.tag_description}</p>
                    `;

                    tagContainer.appendChild(tagElement);
                })

                const filterTags = document.querySelector('#filter-tags');
                const tagElements = document.querySelectorAll('div[id^="tag-"]');
                filterTags.addEventListener('change', function() {
                    if (filterTags.value == "all") {
                        tagElements.forEach(tag => {
                            tag.classList.remove('hidden');
                            tag.classList.add('animate-postSlideIn');
                        })
                    } else {
                        tagElements.forEach(tag => {
                            const tagValue = tag.querySelector('#tag-value');
                            const tagType = tagValue.value;
                            if (tagType == filterTags.value) {
                                tag.classList.remove('hidden');
                                tag.classList.add('animate-postSlideIn');
                            } else {
                                tag.classList.add('hidden');
                            }
                        })
                    }
                })
            }
        })
    })
</script> -->