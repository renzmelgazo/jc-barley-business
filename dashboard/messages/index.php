<?php

require '../../config/session.php';
require '../../config/database.php';
require '../../config/app.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

$pageTitle="Messages";

$stmt=$conn->prepare("
SELECT

c.id,

c.visitor_name,

c.visitor_phone,

c.status,

c.last_activity,

(
SELECT message
FROM chat_messages
WHERE conversation_id=c.id
ORDER BY id DESC
LIMIT 1
) AS last_message

FROM chat_conversations c

WHERE c.owner_id=:owner

ORDER BY c.last_activity DESC, c.id DESC
");

$stmt->execute([
    ':owner'=>$_SESSION['user_id']
]);

$conversations=$stmt->fetchAll(PDO::FETCH_ASSOC);

include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/navbar.php';

?>

<div class="main-content">

<div class="content">

<h2 class="fw-bold mb-4">

💬 Customer Messages

</h2>

<div class="card shadow">

<div class="row g-0">

<!-- LEFT -->

<div class="col-md-4 border-end">

<div
class="list-group list-group-flush"
id="conversationList">

<?php foreach($conversations as $chat): ?>

<a

href="#"

class="list-group-item conversation-item"

data-id="<?= $chat['id'] ?>">

<div class="fw-bold">

<?= htmlspecialchars($chat['visitor_name'] ?: 'Unknown Visitor') ?>

</div>

<small class="text-muted">

<?= htmlspecialchars($chat['last_message']) ?>

</small>

</a>

<?php endforeach; ?>

</div>

</div>

<!-- RIGHT -->

<div class="col-md-8">

<div
id="conversationArea"
style="height:650px;display:flex;flex-direction:column;">

<div
id="chatMessages"
style="
flex:1;
overflow-y:auto;
padding:20px;
background:#f8f9fa;
">

<center class="text-muted mt-5">

Select a conversation

</center>

</div>

<div
class="border-top p-3">

<form id="replyForm">

<input
type="hidden"
id="conversationId"
name="conversation_id">

<div class="input-group">

<input

type="text"

id="replyMessage"

class="form-control"

placeholder="Type your reply...">

<button

class="btn btn-success"

type="submit">

Send

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

let currentConversation=0;

document.querySelectorAll(".conversation-item").forEach(function(item){

item.onclick=function(e){

e.preventDefault();

currentConversation=this.dataset.id;

document.getElementById("conversationId").value=currentConversation;

loadConversation();

};

});

function loadConversation(){

fetch("load_conversation.php?id="+currentConversation)

.then(r=>r.text())

.then(html=>{

document.getElementById("chatMessages").innerHTML=html;

document.getElementById("chatMessages").scrollTop=

document.getElementById("chatMessages").scrollHeight;

});

}

document.getElementById("replyForm").onsubmit=function(e){

e.preventDefault();

const fd=new FormData();

fd.append("conversation_id",currentConversation);

fd.append("message",

document.getElementById("replyMessage").value);

fetch("send_reply.php", {

method:"POST",

body:fd

})

.then(r=>r.json())

.then(data=>{

document.getElementById("replyMessage").value="";

loadConversation();

});

};

setInterval(function(){

if(currentConversation>0){

loadConversation();

}

},2000);

</script>

<?php include '../../includes/footer.php'; ?>