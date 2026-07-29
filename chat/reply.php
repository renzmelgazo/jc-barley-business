<?php

require "../config/database.php";

header("Content-Type: text/plain");

$message = trim($_POST['message'] ?? '');
$ownerSlug = trim($_POST['owner'] ?? '');

if ($message == '') {
    exit("Please type your message.");
}

/*
|--------------------------------------------------------------------------
| Find Website Owner
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
SELECT id
FROM users
WHERE site_slug = :slug
LIMIT 1
");

$stmt->execute([
    ':slug' => $ownerSlug
]);

$owner = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$owner) {
    exit("Website owner not found.");
}

$ownerId = $owner['id'];

/*
|--------------------------------------------------------------------------
| Temporary AI Responses
|--------------------------------------------------------------------------
*/

$text = strtolower($message);

if (strpos($text,"price")!==false){

    echo "I'd be happy to help with pricing. Could you tell me which JC Barley product you're interested in?";

    exit;

}

if (strpos($text,"contact")!==false){

    echo "Sure! May I have your Full Name, Phone Number, and Email Address so our business owner can contact you?";

    exit;

}

if (strpos($text,"hello")!==false || strpos($text,"hi")!==false){

    echo "Hello 👋 Thank you for visiting our website. How may I assist you today?";

    exit;

}

echo "Thank you for your message. I'm here to assist you. Could you please tell me more about your inquiry?";