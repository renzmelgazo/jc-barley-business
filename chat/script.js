const chatButton = document.getElementById("chat-button");
const chatBox = document.getElementById("chat-box");

const sendBtn = document.getElementById("sendBtn");
const messageInput = document.getElementById("message");
const messages = document.getElementById("chat-messages");

let conversationCreated = false;

/*
|--------------------------------------------------------------------------
| Open / Close Chat
|--------------------------------------------------------------------------
*/

chatButton.onclick = function () {

    if (getComputedStyle(chatBox).display === "none") {

        chatBox.style.display = "flex";

    } else {

        chatBox.style.display = "none";

    }

};

/*
|--------------------------------------------------------------------------
| Save Visitor
|--------------------------------------------------------------------------
*/

async function createConversation() {

    if (conversationCreated) return;

    const ownerId = window.ownerId;

    const form = new FormData();

    form.append("owner_id", ownerId);
    form.append("fullname", "");
    form.append("email", "");
    form.append("phone", "");

    await fetch("chat/save_visitor.php", {

        method: "POST",
        body: form

    });

    conversationCreated = true;

}

/*
|--------------------------------------------------------------------------
| Send Message
|--------------------------------------------------------------------------
*/

async function sendMessage() {

    const text = messageInput.value.trim();

    if (text === "") return;

    await createConversation();

    messages.innerHTML += `
        <div class="user">${text}</div>
    `;

    messageInput.value = "";

    messages.scrollTop = messages.scrollHeight;

    const form = new FormData();

    form.append("message", text);

    const sendResponse = await fetch("chat/send.php",{
    method:"POST",
    body:form
});

const sendText = await sendResponse.text();

console.log(sendText);

    const response = await fetch("chat/reply.php");

    const reply = await response.text();

    messages.innerHTML += `
        <div class="bot">${reply}</div>
    `;

    messages.scrollTop = messages.scrollHeight;

}

sendBtn.onclick = sendMessage;

messageInput.addEventListener("keypress", function (e) {

    if (e.key === "Enter") {

        sendMessage();

    }

});

const supportLink = document.getElementById("support-link");

if (supportLink) {

    supportLink.onclick = function () {

        chatBox.style.display = "flex";

    };

}