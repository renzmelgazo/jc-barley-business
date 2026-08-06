<?php

require "config.php";

$conn = db();

$id = intval($_GET['conversation_id'] ?? 0);

$stmt = $conn->prepare("
SELECT *
FROM chat_messages
WHERE conversation_id=?
ORDER BY id ASC
");

$stmt->execute([$id]);

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    if($row['sender']=="Visitor"){

        echo "<div class='user'>".nl2br(htmlspecialchars($row['message']))."</div>";

    }else{

        echo "<div class='bot'>".nl2br(htmlspecialchars($row['message']))."</div>";

    }

}