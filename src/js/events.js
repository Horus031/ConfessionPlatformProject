const menuBtn = document.querySelector('#openMenu');
const closeBtn = document.querySelector('#closeMenu');
const menu = document.querySelector('#menu');
const overlay = document.querySelector('#overlay');
const navbar = document.querySelector('#navbar');
const btnWrapper = document.querySelector('#btn-wrapper');
const currentURL = window.location.href;
const userBtn = document.querySelector('#user-btn');
const userPopup = document.querySelector('#user-popup');
const notifyBtn = document.querySelector('#notify-btn');
const notifyPopup = document.querySelector('#notify-popup');

const app = {
    handleEvents: function() {
        // Bật menu
        menuBtn.addEventListener('click', function() {
            menu.classList.add('animate-menuTransition');
            overlay.classList.remove('hidden');
            closeBtn.classList.remove('hidden');
        });

        // Tắt menu
        closeBtn.addEventListener('click', function() {
            menu.classList.add('animate-menuOut');
            menu.classList.remove('animate-menuTransition');
            overlay.classList.add('hidden');
            closeBtn.classList.add('hidden');
        });

        overlay.addEventListener('click', function() {
            menu.classList.add('animate-menuOut');
            menu.classList.remove('animate-menuTransition');
            overlay.classList.add('hidden');
            closeBtn.classList.add('hidden');
        });

        // Lặp qua các link trong navbar, check xem đang ở trang nào để thêm class tương ứng
        const buttons = navbar.querySelectorAll('a[id$="btn"]');
        buttons.forEach(link => {
            link.classList.remove("bg-gray-200");
            if (link.href === currentURL) {
                link.classList.add("bg-gray-200");
            }
        });

        userBtn.addEventListener('click', function() {
            userPopup.classList.toggle('hidden');
        });

        notifyBtn.addEventListener('click', function() {
            notifyPopup.classList.toggle('hidden');
        });

        // Check khi click ra ngoài các menu & popup
        document.addEventListener('click', function(event) {
            if (!userBtn.contains(event.target) && !userPopup.contains(event.target)) {
                userPopup.classList.add('hidden');
            }

            if (!notifyBtn.contains(event.target) && !notifyPopup.contains(event.target)) {
                notifyPopup.classList.add('hidden');
            }
        });

        
    },

    start: function() {
        this.handleEvents();


    }
}

app.start();