<?php

require '../../config/session.php';
require '../../config/database.php';

if(!isset($_SESSION['user_id'])){
    exit;
}

$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("
SELECT
sender,
message,
created_at
FROM chat_messages
WHERE conversation_id = :id
ORDER BY id ASC
");

$stmt->execute([
    ':id'=>$id
]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($messages)==0){

    echo '
    <center class="text-muted mt-5">
        No messages yet.
    </center>
    ';

    exit;
}

foreach($messages as $msg){

    $sender = htmlspecialchars($msg['sender']);

    $message = nl2br(htmlspecialchars($msg['message']));

    $time = date(
        "M d, h:i A",
        strtotime($msg['created_at'])
    );

    if($sender=="Visitor"){

        ?>

        <div
        style="
        display:flex;
        justify-content:flex-start;
        margin-bottom:15px;
        ">

            <div
            style="
            max-width:70%;
            background:#f1f1f1;
            padding:12px;
            border-radius:12px;
            ">

                <strong>

                    Visitor

                </strong>

                <br>

                <?= $message ?>

                <br>

                <small class="text-muted">

                    <?= $time ?>

                </small>

            </div>

        </div>

        <?php

    }else{

        ?>

        <div
        style="
        display:flex;
        justify-content:flex-end;
        margin-bottom:15px;
        ">

            <div
            style="
            max-width:70%;
            background:#198754;
            color:white;
            padding:12px;
            border-radius:12px;
            ">

                <strong>

                    You

                </strong>

                <br>

                <?= $message ?>

                <br>

                <small style="color:#d6ffd6;">

                    <?= $time ?>

                </small>

            </div>

        </div>

        <?php

    }

}