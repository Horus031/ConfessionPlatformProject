class EventListener {
    constructor() {
        this.currentURL = window.location.href;
    }

    initElements() {
        this.menuBtn = document.querySelector('#openMenu');
        this.closeBtn = document.querySelector('#closeMenu');
        this.menu = document.querySelector('#menu');
        this.overlay = document.querySelector('#overlay');
        this.navbar = document.querySelector('#navbar');
        this.btnWrapper = document.querySelector('#btn-wrapper');
        this.userBtn = document.querySelector('#user-btn');
        this.userPopup = document.querySelector('#user-popup');
        this.notifyBtn = document.querySelector('#notify-btn');
        this.notifyPopup = document.querySelector('#notify-popup');
    }

    handleEvents() {
        this.initElements();

        // Bật menu
        this.menuBtn.addEventListener('click', () => {
            this.menu.classList.add('animate-menuTransition');
            this.overlay.classList.remove('hidden');
            this.closeBtn.classList.remove('hidden');
        });

        // Tắt menu
        this.closeBtn.addEventListener('click', () => {
            this.menu.classList.add('animate-menuOut');
            this.menu.classList.remove('animate-menuTransition');
            this.overlay.classList.add('hidden');
            this.closeBtn.classList.add('hidden');
        });

        this.overlay.addEventListener('click', () => {
            this.menu.classList.add('animate-menuOut');
            this.menu.classList.remove('animate-menuTransition');
            this.overlay.classList.add('hidden');
            this.closeBtn.classList.add('hidden');
        });

        // Lặp qua các link trong navbar, check xem đang ở trang nào để thêm class tương ứng
        const buttons = this.navbar.querySelectorAll('a[id$="btn"]');
        buttons.forEach(link => {
            link.classList.remove("bg-gray-200");
            if (link.href === this.currentURL) {
                link.classList.add("bg-gray-200");
            }
        });

        this.userBtn.addEventListener('click', () => {
            this.userPopup.classList.toggle('hidden');
        });

        this.notifyBtn.addEventListener('click', () => {
            this.notifyPopup.classList.toggle('hidden');
        });

        // Check khi click ra ngoài các menu & popup
        document.addEventListener('click', (event) => {
            if (!this.userBtn.contains(event.target) && !this.userPopup.contains(event.target)) {
                this.userPopup.classList.add('hidden');
            }

            if (!this.notifyBtn.contains(event.target) && !this.notifyPopup.contains(event.target)) {
                this.notifyPopup.classList.add('hidden');
            }
        });
    }

    start() {
        this.handleEvents();
    }
}

// Export the class
export default EventListener;