<?php

require "config.php";

$conn = db();

$conversationId = intval($_GET['conversation_id'] ?? 0);

$stmt = $conn->prepare("
SELECT *
FROM chat_messages
WHERE conversation_id=?
ORDER BY id ASC
");

$stmt->execute([$conversationId]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);