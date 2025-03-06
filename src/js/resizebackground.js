const waveBackground = document.querySelector('#waves-bg');
const wavePath = document.querySelector('#waves-path');

// Thay đổi wave background dựa trên breakpoint
function updateWaveBackground() {
    if (window.innerWidth >= 1536) {
        waveBackground.setAttribute('height', '1700px');
        wavePath.setAttribute('d', "M 0 60 q 400 100 800 -20 q 600 -150 1700 300 l 0 900 l -2500 0");
    } else if (window.innerWidth >= 1280) {
        waveBackground.setAttribute('height', '1500px');
        wavePath.setAttribute('d', "M 0 60 q 130 80 500 -20 q 200 -70 800 60 l 0 900 l -1300 0");
    } else if (window.innerWidth >= 1024) {
        waveBackground.setAttribute('height', '1200px');
        wavePath.setAttribute('d', "M 0 60 q 130 80 400 -20 q 200 -70 700 60 l -80 900 l -1100 0");
    } else if (window.innerWidth >= 768) {
        waveBackground.setAttribute('height', '1100px');
        wavePath.setAttribute('d', "M 0 60 q 130 80 300 -20 q 200 -70 700 60 l -100 1000 l -1000 -100");
    } else {
        waveBackground.setAttribute('height', '700px');
        wavePath.setAttribute('d', "M 0 60 q 100 30 160 -20 q 150 -100 500 40 l 180 600 l -1000 0");
    }
}

document.addEventListener('DOMContentLoaded', updateWaveBackground);

window.addEventListener('resize', updateWaveBackground);