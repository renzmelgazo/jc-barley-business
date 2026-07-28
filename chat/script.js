const owner = new URLSearchParams(window.location.search).get("owner");

fetch("chat/index.php?owner="+owner);

const button=document.getElementById("chat-button");

const box=document.getElementById("chat-box");

button.onclick=()=>{

box.style.display=

box.style.display==="block"

?

"none"

:

"block";

};

document.getElementById("sendBtn").onclick=sendMessage;

function sendMessage(){

let input=document.getElementById("message");

let message=input.value.trim();

if(message=="")return;

fetch("chat/send.php",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:"message="+encodeURIComponent(message)

});

let div=document.createElement("div");

div.className="user";

div.innerHTML=message;

document.getElementById("chat-messages").appendChild(div);

input.value="";

}

const supportLink = document.getElementById("support-link");

if (supportLink) {
    supportLink.onclick = function () {
        box.style.display = "block";
    };
}