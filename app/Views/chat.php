<h2>Welcome to the Chat Room!</h2>
<p>This will be the main chat interface.</p>
<a href="<?= site_url('logout'); ?>">Logout</a>
<h2>Chat Room</h2>
<div id="chat-box">
    <!-- Messages will be dynamically loaded here -->
</div>

<input type="text" id="message-input" placeholder="Type your message..." />
<button onclick="sendMessage()">Send</button>

<script>
// Function to load messages from the server
function loadMessages() {
    fetch('<?= site_url("chat/retrieveMessages"); ?>')
        .then(response => response.json())
        .then(data => {
            let chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = ''; // Clear previous messages
            data.forEach(message => {
                chatBox.innerHTML += `<p>${message}</p>`;
            });
        });
}

// Function to send a new message to the server
function sendMessage() {
    let message = document.getElementById('message-input').value;
    fetch('<?= site_url("chat/sendMessage"); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: message })
    }).then(() => {
        document.getElementById('message-input').value = ''; // Clear input field
        loadMessages(); // Reload messages after sending
    });
}

// Automatically load messages every 2 seconds for real-time effect
setInterval(loadMessages, 2000);
loadMessages(); // Initial load
</script>

