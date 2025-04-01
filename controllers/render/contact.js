import EventListener from '../../src/js/events.js';
import QuestionRenderer from '../../src/js/render.js';


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


document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    await eventListener.initSessionData();

    eventListener.start();
})

