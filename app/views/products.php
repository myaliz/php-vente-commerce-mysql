<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Electronic Products</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 160px;
            background-color: #e0e0e0;
            color: #333;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 20px 40px;
            text-align: center;
            margin-top: 40px;
        }

        .footer-contact p {
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
        }

        .footer-contact p i {
            margin-right: 10px;
            color: #FF9800;
            font-size: 1em;
            width: 1em;
            text-align: center;
        }

        .topbar {
            width: 100%;
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .spacer {
            flex: 1;
        }

        .menu {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex: 2;
        }

        .menu a {
            color: #FF9800;
            text-decoration: none;
            font-size: 1.1em;
        }

        .menu a:hover {
            text-decoration: underline;
        }

        .login-link {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            padding-right: 20px;
        }

        .login-link a {
            color: #FF9800;
            text-decoration: none;
            font-size: 1em;
            display: flex;
            align-items: center;
        }

        .login-link a i {
            margin-right: 6px;
        }

        /* New styles for video grid */
        .video-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Distribute videos evenly */
            padding: 10px;
            background-color: #f0f0f0; /* Light background for the video section */
        }

        .video-item {
            width: calc(20% - 20px); /* 5 videos per row */
            margin: 10px;
            aspect-ratio: 16 / 9; /* Maintain 16:9 aspect ratio */
            border-radius: 8px;
            overflow: hidden; /* Ensure the video doesn't overflow the rounded corners */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .video-item iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        @media (max-width: 1200px) {
            .video-item {
                width: calc(33.333% - 20px); /* 3 videos per row */
            }
        }

        @media (max-width: 800px) {
            .video-item {
                width: calc(50% - 20px); /* 2 videos per row */
            }
        }

        @media (max-width: 500px) {
            .video-item {
                width: 100%; /* 1 video per row */
            }
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            padding: 10px;
        }

        .product {
            width: calc(14.285% - 20px);
            border: 1px solid #ccc;
            margin: 10px;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
            background-color: #f0f0f0;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            min-height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: background-color 0.3s ease;
            box-sizing: border-box;
        }

        .product:hover {
            background-color: #d3d3d3;
            cursor: pointer;
        }

        .product img {
            width: 100%;
            height: 120px;
            object-fit: contain;
            border-radius: 4px;
        }

        .product-name {
            font-weight: bold;
            margin-top: 5px;
            font-size: 0.9em;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            height: 1.2em;
        }

        .product-description {
            font-size: 0.8em;
            color: #555;
            margin-top: 5px;
            margin-bottom: 3px;
            line-height: 1.4;
            overflow: visible;
            text-overflow: clip;
            display: block;
            -webkit-line-clamp: unset;
            -webkit-box-orient: vertical;
        }

        @media (max-width: 1400px) {
            .product {
                width: calc(20% - 20px);
            }
        }

        @media (max-width: 1000px) {
            .product {
                width: calc(33.333% - 20px);
            }
        }

        @media (max-width: 600px) {
            .product {
                width: calc(50% - 20px);
            }
        }

        .product-price {
            color: green;
            font-size: 1em;
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .product-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 3px;
        }

        .product-buttons button {
            padding: 5px;
            margin: 2px;
            font-size: 0.8em;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .add-to-cart {
            background-color: rgba(27, 233, 27, 0.74);
            color: white;
            font-size: 1em;
            padding: 5px 6px;
        }

        .buy-now {
            background-color: #FF9800;
            color: white;
            font-size: 0.9em;
            padding: 5px 6px;
        }

        .cart-count {
            background-color: #FF9800;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            padding: 1px 4px;
            font-size: 0.7em;
            margin-left: 3px;
        }

        /* Messenger */
        #messenger-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        #messenger-toggle {
            position: absolute;
            right: 0;
            bottom: 0;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        #messenger-toggle:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        #messenger-window {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 350px;
            max-height: 80vh;
            height: 500px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            opacity: 1;
            transform: scale(1) translateY(0);
            transition: opacity 0.3s cubic-bezier(0.25, 0.1, 0.25, 1), transform 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
            transform-origin: bottom right;
        }

        #messenger-window.hidden {
            opacity: 0;
            transform: scale(0.5) translate(30px, 30px);
            pointer-events: none;
        }

        .messenger-header {
            background-color: #007bff;
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .messenger-header span {
            font-size: 1.1em;
            font-weight: bold;
        }

        #messenger-close {
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
            padding: 0 5px;
            opacity: 0.8;
            transition: opacity 0.2s ease;
        }

        #messenger-close:hover {
            opacity: 1;
        }

        .messenger-content {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #f9f9f9;
            font-size: 0.95em;
            color: #333;
            display: flex;
            flex-direction: column;
        }

        .messenger-content p#initial-greeting:first-child {
            margin-top: 0;
        }

        #support-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 6px;
            font-size: 0.88em;
            color: #444;
            font-weight: 600;
        }

        .form-group input[type="text"],
        .form-group input[type="tel"],
        .form-group input[type="email"],
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 0.9em;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="tel"]:focus,
        .form-group input[type="email"]:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 70px;
        }

        .messenger-input-area {
            display: flex;
            padding: 12px 15px;
            border-top: 1px solid #e0e0e0;
            background-color: #ffffff;
            gap: 10px;
        }

        #form-submit-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }

        #form-submit-button:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
        }

        #form-submit-button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            transform: none;
        }

        #chat-input {
            flex-grow: 1;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 10px 15px;
            font-size: 0.9em;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        #chat-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        #chat-send-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 0.9em;
            font-weight: bold;
            transition: background-color 0.3s ease;
            flex-shrink: 0;
        }

        #chat-send-button:hover {
            background-color: #0056b3;
        }

        .system-message {
            padding: 12px 15px;
            background-color: #e9f5ff;
            border-left: 5px solid #007bff;
            margin: 10px 0;
            border-radius: 0 4px 4px 0;
            font-size: 0.9em;
        }

        .system-message p {
            margin: 0;
        }

        .chat-message {
            padding: 8px 12px;
            margin-bottom: 8px;
            border-radius: 18px;
            max-width: 85%;
            word-wrap: break-word;
            line-height: 1.4;
            font-size: 0.9em;
        }

        .user-message {
            background-color: #007bff;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 5px;
        }

        .bot-message {
            background-color: #e9ecef;
            color: #333;
            margin-right: auto;
            border-bottom-left-radius: 5px;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="spacer"></div>
        <div class="menu">
            <a href="/products">products on promotion</a>
            <a href="index.php?action=showCart">Cart</a>
            <a href="/contact">Contact</a>
        </div>
        <div class="login-link" style="margin-right: 20px;">
            <a href="index.php?action=adminPage"><i class="fas fa-user"></i> Admin Login</a>
        </div>
    </div>

    <div class="video-grid">
        <div class="video-item">
           <iframe width="560" height="315" src="https://www.youtube.com/embed/QNUFMKnZK40?si=v2J1lpeI0Gf1Iai0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="video-item">
<iframe width="560" height="315" src="https://www.youtube.com/embed/AQL9q8W-mns?si=7fr6DB0KGBD8JBId" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>        </div>
         <div class="video-item">
<iframe width="560" height="315" src="https://www.youtube.com/embed/ncndRCxqjL8?si=k7_McFglGsM7TmQ6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>        </div>
       
       
    </div>

    <div class="product-container">
        <?php if (!empty($products) && is_array($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product" onclick="showProductDetail(<?= $product['id'] ?>)">
                    <img src="<?= htmlspecialchars($product['image'] ?? 'path/to/default-image.png'); ?>"
                         alt="<?= htmlspecialchars($product['name'] ?? 'Product Image'); ?>">
                    <div class="product-name"><?= htmlspecialchars($product['name'] ?? 'N/A'); ?></div>
                     <div class="product-description">
                        <?= ($product['description'] ); ?>
                    </div>
                    <div class="product-price"><?= number_format($product['price'] ?? 0, 2, ',', ' '); ?> $</div>
                   <div class="product-buttons">
    <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(this)">
        <i class="fas fa-shopping-cart"></i>
    </button>
    <button class="buy-now" onclick="event.stopPropagation(); showProductDetail(<?= $product['id'] ?>)">Buy Now</button>
</div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>

    <script>
        function showProductDetail(productId) {
    window.location.href = `index.php?action=showProductDetail&id=${productId}`;
}
        function addToCart(button) {
            const icon = button.querySelector("i");
            const productName = button.closest(".product").querySelector(".product-name").innerText;

            if (!button.classList.contains('added')) {
                button.classList.add('added');
                icon.classList.remove("fa-shopping-cart");
                icon.classList.add("fa-cart-plus");

                let counter = document.createElement("span");
                counter.className = "cart-count";
                counter.innerText = "1";
                button.appendChild(counter);

                fetch('index.php?action=addToCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'product=' + encodeURIComponent(productName)
                });
            } else {
                button.classList.remove('added');
                icon.classList.remove("fa-cart-plus");
                icon.classList.add("fa-shopping-cart");

                let count = button.querySelector(".cart-count");
                if (count) count.remove();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const messengerToggle = document.getElementById('messenger-toggle');
            const messengerWindow = document.getElementById('messenger-window');
            const messengerClose = document.getElementById('messenger-close');
            const supportForm = document.getElementById('support-form');
            const formSubmitButton = document.getElementById('form-submit-button');
            const messengerContent = document.querySelector('.messenger-content');
            const initialGreeting = document.getElementById('initial-greeting');
            const chatInput = document.getElementById('chat-input');
            const chatSendButton = document.getElementById('chat-send-button');

            messengerToggle.addEventListener('click', () => {
                messengerWindow.classList.remove('hidden');
                messengerToggle.style.display = 'none';
                resetFormState();
            });

            messengerClose.addEventListener('click', () => {
                messengerWindow.classList.add('hidden');
                messengerToggle.style.display = 'flex';
                resetFormState();
            });

            function resetFormState() {
                if (supportForm) {
                    supportForm.reset();
                    supportForm.style.display = 'flex';
                }
                if (initialGreeting) {
                    initialGreeting.style.display = 'block';
                }
                const dynamicMessages = messengerContent.querySelectorAll('.user-message, .bot-message, .system-message');
                dynamicMessages.forEach(msg => msg.remove());
                if (formSubmitButton) {
                    formSubmitButton.disabled = false;
                    formSubmitButton.textContent = 'Send Message';
                    formSubmitButton.classList.remove('hidden');
                }
                if (chatInput) {
                    chatInput.classList.add('hidden');
                    chatInput.value = '';
                }
                if (chatSendButton) {
                    chatSendButton.classList.add('hidden');
                }
            }
            if (supportForm) {
                supportForm.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const formData = new FormData(supportForm);

                    try {
                        const response = await fetch('index.php?action=submitMessage', {
                            method: 'POST',
                            body: formData
                        });

                        const data = await response.json();

                        if (data.status === 'success') {
                            const successMessage = document.createElement('div');
                            successMessage.className = 'system-message success';
                            successMessage.textContent = data.message;
                            messengerContent.appendChild(successMessage);

                            supportForm.reset();

                            supportForm.style.display = 'none';
                            initialGreeting.style.display = 'none';
                            formSubmitButton.classList.add('hidden');
                            chatInput.classList.remove('hidden');
                            chatSendButton.classList.remove('hidden');
                            chatInput.focus();
                        } else {
                            const errorMessage = document.createElement('div');
                            errorMessage.className = 'system-message error';
                            errorMessage.textContent = data.message;
                            messengerContent.appendChild(errorMessage);
                        }

                        messengerContent.scrollTop = messengerContent.scrollHeight;
                    } catch (error) {
                        console.error('Error:', error);
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'system-message error';
                        errorMessage.textContent = 'An error occurred. Please try again.';
                        messengerContent.appendChild(errorMessage);
                        messengerContent.scrollTop = messengerContent.scrollHeight;
                    }
                });
            }

            function appendMessageToChat(text, type) {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('chat-message');
                messageDiv.classList.add(type);
                messageDiv.textContent = text;
                messengerContent.appendChild(messageDiv);
                messengerContent.scrollTop = messengerContent.scrollHeight;
            }

            function appendUserMessage(text) {
                appendMessageToChat(text, 'user-message');
            }

            function appendBotMessage(text) {
                appendMessageToChat(text, 'bot-message');
            }

            function sendChatMessage() {
                const messageText = chatInput.value.trim();
                if (messageText) {
                    appendUserMessage(messageText);
                    chatInput.value = '';
                    chatInput.focus();
                    setTimeout(() => {
                        appendBotMessage("Thanks for your message! An agent will be with you shortly.");
                    }, 1000);
                }
            }

            if (chatSendButton && chatInput) {
                chatSendButton.addEventListener('click', sendChatMessage);
                chatInput.addEventListener('keypress', (event) => {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        sendChatMessage();
                    }
                });
            }

            console.log("Interactive form messenger script loaded and updated for chat.");
        });

        function showProductDetail(productId) {
            window.location.href = `index.php?action=showProductDetail&id=${productId}`;
        }
    </script>

    <div id="messenger-container">
        <div id="messenger-window" class="hidden">
            <div class="messenger-header">
                <span>Support Chat</span>
                <button id="messenger-close" aria-label="Close chat window">&times;</button>
            </div>
            <div class="messenger-content">
                <p id="initial-greeting">Hi there! How can we help you today?</p>
                <form id="support-form" action="index.php?action=sendMessage" method="post">
                    <div class="form-group">
                        <label for="form-name">Name</label>
                        <input type="text" id="form-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="form-tel">Telephone</label>
                        <input type="tel" id="form-tel" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="form-email">Email</label>
                        <input type="email" id="form-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="form-message">Your Message</label>
                        <textarea id="form-message" name="message" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="messenger-input-area">
                <button type="submit" id="form-submit-button" form="support-form">Send Message</button>
                <input type="text" id="chat-input" placeholder="Type your message..." class="hidden">
                <button id="chat-send-button" class="hidden">Send</button>
            </div>
        </div>
        <button id="messenger-toggle" aria-label="Open chat window">
            <svg viewBox="0 0 24 24" fill="white" width="30px" height="30px" aria-hidden="true">
                <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
            </svg>
        </button>
    </div>

    <footer>
        <div class="footer-contact">
            <p><i class="fas fa-phone"></i> +1 418 446 8760</p>
            <p><i class="fas fa-envelope"></i> benalizied83@gmail.com</p>
            <p><i class="fas fa-map-marker-alt"></i> 77 rue Hochelaga H1N 1X7</p>
        </div>
    </footer>
</body>
</html>