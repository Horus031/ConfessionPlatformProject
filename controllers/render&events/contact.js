import EventListener from '../../src/js/events.js';


document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    
    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');
        await eventListener.start();
        await eventListener.initSessionData();

    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }


})

