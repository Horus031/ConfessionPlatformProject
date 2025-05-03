import EventListener from '../../src/js/events.js';
import ValidateUsers from '../../src/js/validate_users.js';


document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();
    const validation = new ValidateUsers();
    
    try {
        document.querySelector('#loading-overlay').classList.remove('hidden');

        await validation.checkUserPermissions();

        await eventListener.initSessionData();

    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        document.querySelector('#loading-overlay').classList.add('hidden');
    }

    eventListener.start();

})  

