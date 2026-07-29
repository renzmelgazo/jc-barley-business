const owner = new URLSearchParams(window.location.search).get("owner");

const button = document.getElementById("chat-button");
const box = document.getElementById("chat-box");

button.onclick = function () {

    if (box.style.display === "block") {
        box.style.display = "none";
    } else {
        box.style.display = "block";
    }

};

document.getElementById("sendBtn").onclick = sendMessage;

async function sendMessage() {

    let input = document.getElementById("message");

    let message = input.value.trim();

    if (message === "") return;

    addUserMessage(message);

    input.value = "";

    const response = await fetch("chat/reply.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body:
            "owner=" + encodeURIComponent(owner) +
            "&message=" + encodeURIComponent(message)

    });

    const text = await response.text();

    addBotMessage(text);

}

function addUserMessage(message){

    let div=document.createElement("div");

    div.className="user";

    div.innerHTML=message;

    document.getElementById("chat-messages").appendChild(div);

    scrollBottom();

}

function addBotMessage(message){

    let div=document.createElement("div");

    div.className="bot";

    div.innerHTML=message;

    document.getElementById("chat-messages").appendChild(div);

    scrollBottom();

}

function scrollBottom(){

    let box=document.getElementById("chat-messages");

    box.scrollTop=box.scrollHeight;

}