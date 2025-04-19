import EventListener from '../../src/js/events.js';
document.addEventListener('DOMContentLoaded', async function() {
    const eventListener = new EventListener();


    function focusNextInput(el, prevId, nextId) {
        if (el.value.length === 0) {
            if (prevId) {
                document.getElementById(prevId).focus();
            }
        } else {
            if (nextId) {
                document.getElementById(nextId).focus();
            }
        }
    }
    
    document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
        element.addEventListener('keyup', function() {
            const prevId = this.getAttribute('data-focus-input-prev');
            const nextId = this.getAttribute('data-focus-input-next');
            focusNextInput(this, prevId, nextId);
        });
        
    // Handle paste event to split the pasted code into each input
        element.addEventListener('paste', function(event) {
            event.preventDefault();
            const pasteData = (event.clipboardData || window.clipboardData).getData('text');
            const digits = pasteData.replace(/\D/g, ''); // Only take numbers from the pasted data
    
            // Get all input fields
            const inputs = document.querySelectorAll('[data-focus-input-init]');
            
            // Iterate over the inputs and assign values from the pasted string
            inputs.forEach((input, index) => {
                if (digits[index]) {
                    input.value = digits[index];
                    // Focus the next input after filling the current one
                    const nextId = input.getAttribute('data-focus-input-next');
                    if (nextId) {
                        document.getElementById(nextId).focus();
                    }
                }
            });
        });
    });

    eventListener.start();
})