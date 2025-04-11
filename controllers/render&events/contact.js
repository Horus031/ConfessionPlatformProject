import EventListener from '../../src/js/events.js';


document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    await eventListener.initSessionData();

    eventListener.start();
})

