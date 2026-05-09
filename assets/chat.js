// FILE: /assets/chat.js

document.addEventListener('DOMContentLoaded', function () {
    const btnOpen   = document.getElementById('chatbot-btn');
    const win       = document.getElementById('chatbot-window');
    const btnClose  = document.getElementById('chatbot-close');
    const input     = document.getElementById('chat-input');
    const btnSend   = document.getElementById('chat-send');
    const body      = document.getElementById('chatbot-body');

    if (!btnOpen || !win || !btnClose || !input || !btnSend || !body) {
        // Required elements not present on this page
        return;
    }

    // Open / close handlers
    btnOpen.addEventListener('click', function () {
        win.style.display = 'flex';
        input.focus();
    });

    btnClose.addEventListener('click', function () {
        win.style.display = 'none';
    });

    // Send on button click
    btnSend.addEventListener('click', function () {
        sendMessage();
    });

    // Send on Enter key
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    function appendMessage(text, type) {
        const div = document.createElement('div');
        div.classList.add('chatbot-message', type === 'user' ? 'user' : 'bot');
        div.innerHTML = text;
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
    }

    function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        // Show user message
        appendMessage(escapeHtml(text), 'user');
        input.value = '';

        // Show temporary "typing" message
        const loadingDiv = document.createElement('div');
        loadingDiv.classList.add('chatbot-message', 'bot');
        loadingDiv.textContent = 'Typing...';
        body.appendChild(loadingDiv);
        body.scrollTop = body.scrollHeight;

        fetch('chatbot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ question: text })
        })
            .then(response => response.json())
            .then(data => {
                body.removeChild(loadingDiv);
                if (data.status === 'ok') {
                    appendMessage(data.answer, 'bot'); // already formatted with <br> from PHP
                } else {
                    appendMessage('Sorry, something went wrong. Please try again later.', 'bot');
                }
            })
            .catch(() => {
                body.removeChild(loadingDiv);
                appendMessage('Network error. Please check your connection and try again.', 'bot');
            });
    }

    // Simple HTML escaping for user messages
    function escapeHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }
});
