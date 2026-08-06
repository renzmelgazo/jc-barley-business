document.addEventListener("DOMContentLoaded", function () {

const chatButton = document.getElementById("chat-button");
const chatBox = document.getElementById("chat-box");
const sendBtn = document.getElementById("sendBtn");
const messageInput = document.getElementById("message");
const messages = document.getElementById("chat-messages");

console.log(chatButton);
console.log(chatBox);
console.log(sendBtn);
console.log(messageInput);
console.log(messages);

chatButton.onclick = function () {

    chatBox.classList.toggle("show");

};

function appendMessage(sender,text){

    const div=document.createElement("div");

    div.className=sender;

    div.innerHTML=text.replace(/\n/g,"<br>");

    messages.appendChild(div);


}

sendBtn.onclick = sendMessage;

messageInput.addEventListener("keypress",function(e){

    if(e.key==="Enter"){

        sendMessage();

    }

});

function sendMessage(){

    const text = messageInput.value.trim();

    if(text==="") return;

    appendMessage("user",text);

    messageInput.value="";

    const formData = new FormData();

    formData.append("message",text);
    formData.append("owner_id",window.ownerId);
    formData.append(
    "visitor_token",
    window.visitorToken
);

    fetch("chat/send.php",{

        method:"POST",
        body:formData

    })

    .then(res=>res.json())
    .then(data=>{

    if(data.success){

        conversationId = data.conversation_id;

        loadMessages();

    }else{

        appendMessage("bot","Unable to send message.");

    }

})

    .catch(()=>{

        appendMessage("bot","Unable to connect.");

    });

}

});

setInterval(function(){

    if(!window.conversationId) return;

    fetch(
        "chat/load_messages.php?conversation_id="
        +
        window.conversationId
    )

    .then(res=>res.json())

    .then(data=>{

        messages.innerHTML="";

        data.forEach(function(msg){

            if(msg.sender==="Visitor"){

                appendMessage("user",msg.message);

            }else if(msg.sender==="Owner"){

                appendMessage("bot",msg.message);

            }else{

                appendMessage("bot",msg.message);

            }

        });

    });

},2000);

let conversationId = null;

function loadMessages(){

    if(!conversationId) return;

    fetch("chat/load_messages.php?conversation_id=" + conversationId)

    .then(res => res.text())

    .then(html => {

        messages.innerHTML = html;

        messages.scrollTop = messages.scrollHeight;

    });

}

setInterval(function(){

    loadMessages();

},3000);

fetch("chat/get_conversation.php?owner_id="+window.ownerId)

.then(res=>res.text())

.then(id=>{

    if(id!=""){

        conversationId=id;

        loadMessages();

    }

});