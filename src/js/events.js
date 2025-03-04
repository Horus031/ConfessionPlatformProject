const menuBtn = document.querySelector('#openMenu');
const closeBtn = document.querySelector('#closeMenu');
const menu = document.querySelector('#menu');
const overlay = document.querySelector('#overlay');



const app = {
    handleEvents: function() {
        menuBtn.addEventListener('click', function() {
            menu.classList.add('animate-menuTransition');
            overlay.classList.remove('hidden');
            closeBtn.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', function() {
            menu.classList.add('animate-menuOut');
            menu.classList.remove('animate-menuTransition');
            overlay.classList.add('hidden');
            closeBtn.classList.add('hidden');
        });
    },

    start: function() {
        this.handleEvents();
    }
}

app.start();