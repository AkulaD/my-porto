// Jam Sistem Real-time
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour12: false, 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit' 
    });
    document.getElementById('clock').textContent = timeString;
}
setInterval(updateClock, 1000);
updateClock();

// Smooth Scroll Navigasi
document.querySelectorAll('.nav-item').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        window.scrollTo({
            top: target.offsetTop - 70,
            behavior: 'smooth'
        });
    });
});

// Animasi Bar Skill saat Scroll
const skillObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const bars = entry.target.querySelectorAll('.bar-fill');
            bars.forEach(bar => {
                bar.style.width = bar.getAttribute('data-width');
            });
            skillObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

const skillPanel = document.getElementById('skill-panel');
if (skillPanel) skillObserver.observe(skillPanel);

// Efek Reveal Panel
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateY(0)";
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.panel-box').forEach(panel => {
    panel.style.opacity = "0";
    panel.style.transform = "translateY(30px)";
    panel.style.transition = "all 0.8s ease-out";
    revealObserver.observe(panel);
});