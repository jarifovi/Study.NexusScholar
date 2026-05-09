<?php
// FILE: footer.php
?>
</main>

<!-- Chatbot floating button -->
<div class="chatbot-btn" id="chatbot-btn">
    <i class="fa-solid fa-robot"></i>
</div>

<!-- Chatbot Window -->
<div class="chatbot-window" id="chatbot-window">
    <div class="chatbot-header">
        <div style="display:flex; flex-direction:column;">
            <span style="font-weight:800; font-size:16px;">Nexus AI Mentor</span>
            <select id="ai-persona" style="background:none; border:none; color:rgba(255,255,255,0.7); font-size:11px; padding:0; margin:0; outline:none; cursor:pointer;">
                <option value="general" style="color:#000;">General Advisor</option>
                <option value="stem" style="color:#000;">STEM Specialist</option>
                <option value="business" style="color:#000;">MBA/Business Coach</option>
                <option value="arts" style="color:#000;">Arts & Design Mentor</option>
            </select>
        </div>
        <button id="chatbot-close" style="background:none; border:none; color:#fff; font-size:24px; cursor:pointer;">&times;</button>
    </div>

    <div class="chatbot-body" id="chatbot-body">
        <div class="chatbot-message bot">
            Hi! Ask me anything about CGPA, Scholarships, IELTS or Admission.
        </div>
    </div>

    <div class="chatbot-footer">
        <input type="text" id="chat-input" placeholder="Type your question...">
        <button id="chat-send"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
</div>

<!-- Dropdown toggles (Profile + Notifications) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const profile      = document.querySelector('.profile-dropdown');
    const notification = document.querySelector('.notification-dropdown');

    // Helper: toggle open on click
    function setupDropdown(dropdown) {
        if (!dropdown) return;
        const menu = dropdown.querySelector('.dropdown-menu');

        dropdown.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = dropdown.classList.contains('open');
            // close all first
            if (profile) profile.classList.remove('open');
            if (notification) notification.classList.remove('open');
            // then open this one if it was closed
            if (!isOpen) dropdown.classList.add('open');
        });

        if (menu) {
            menu.addEventListener('click', function (e) {
                e.stopPropagation(); // keep open when clicking inside
            });
        }
    }

    setupDropdown(profile);
    setupDropdown(notification);

    // Click anywhere else => close both
    document.addEventListener('click', function () {
        if (profile) profile.classList.remove('open');
        if (notification) notification.classList.remove('open');
    });
});
</script>

<!-- Chatbot JS -->
<script src="assets/chat.js"></script>

</div> <!-- page-wrapper -->
</body>
</html>
