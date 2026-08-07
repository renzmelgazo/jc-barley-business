document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const startChatBtn =
        document.getElementById("startChatBtn");

    const chatStartArea =
        document.getElementById("chatStartArea");

    const chatInputArea =
        document.getElementById("chatInputArea");

    const messageInput =
        document.getElementById("message");

    const sendBtn =
        document.getElementById("sendBtn");

    const chatMessages =
        document.getElementById("chat-messages");


    /*
    |--------------------------------------------------------------------------
    | Visitor Token
    |--------------------------------------------------------------------------
    */

    let visitorToken =
        localStorage.getItem(
            "jc_barley_visitor_token"
        );

    if (!visitorToken) {

        if (
            window.crypto &&
            crypto.randomUUID
        ) {

            visitorToken =
                crypto.randomUUID();

        } else {

            visitorToken =
                "visitor_" +
                Math.random()
                    .toString(36)
                    .substring(2) +
                Date.now();
        }

        localStorage.setItem(
            "jc_barley_visitor_token",
            visitorToken
        );
    }


    window.visitorToken =
        visitorToken;


    /*
    |--------------------------------------------------------------------------
    | Chat State
    |--------------------------------------------------------------------------
    */

    let chatStarted = false;

    let contactStep = "waiting_first_message";

    let visitorName = "";

    let visitorPhone = "";

    let visitorFirstMessage = "";

    let conversationId = 0;


    /*
    |--------------------------------------------------------------------------
    | Add Bot Message
    |--------------------------------------------------------------------------
    */

    function addBotMessage(message) {

        const div =
            document.createElement("div");

        div.className = "bot";

        div.textContent = message;

        chatMessages.appendChild(div);

        chatMessages.scrollTop =
            chatMessages.scrollHeight;
    }


    /*
    |--------------------------------------------------------------------------
    | Add Visitor Message
    |--------------------------------------------------------------------------
    */

    function addVisitorMessage(message) {

        const div =
            document.createElement("div");

        div.className = "visitor";

        div.textContent = message;

        chatMessages.appendChild(div);

        chatMessages.scrollTop =
            chatMessages.scrollHeight;
    }


    /*
    |--------------------------------------------------------------------------
    | START CHAT
    |--------------------------------------------------------------------------
    */

    if (startChatBtn) {

        startChatBtn.addEventListener(
            "click",
            function () {

                if (chatStarted) {
                    return;
                }

                chatStarted = true;


                /*
                | Hide Start Chat
                */

                if (chatStartArea) {

                    chatStartArea.style.display =
                        "none";

                }


                /*
                | Show message input
                */

                if (chatInputArea) {

                    chatInputArea.style.display =
                        "flex";

                }


                /*
                | Focus message box
                */

                if (messageInput) {

                    messageInput.focus();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    |--------------------------------------------------------------------------
    */

    function sendMessage() {

        if (!chatStarted) {
            return;
        }


        const message =
            messageInput.value.trim();


        if (message === "") {
            return;
        }


        /*
        | Show Visitor Message
        */

        addVisitorMessage(message);

        messageInput.value = "";


        /*
        |--------------------------------------------------------------------------
        | FIRST MESSAGE
        |--------------------------------------------------------------------------
        */

        if (
            contactStep ===
            "waiting_first_message"
        ) {

            visitorFirstMessage =
                message;


            addBotMessage(
                "👋 Welcome to JC Barley! Before we proceed, could you please tell us your name?"
            );


            contactStep = "waiting_name";

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | NAME
        |--------------------------------------------------------------------------
        */

        if (
            contactStep ===
            "waiting_name"
        ) {

            visitorName =
                message;


            addBotMessage(
                "Thank you, " +
                visitorName +
                "! May we also have your phone number, please?"
            );


            contactStep = "waiting_phone";

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PHONE
        |--------------------------------------------------------------------------
        */

        if (
            contactStep ===
            "waiting_phone"
        ) {

            visitorPhone =
                message;


            /*
            | Save visitor information
            */

            localStorage.setItem(
                "jc_barley_visitor_name",
                visitorName
            );

            localStorage.setItem(
                "jc_barley_visitor_phone",
                visitorPhone
            );


            addBotMessage(
                "Thank you! How can we help you today?"
            );


            contactStep =
                "waiting_message";


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | FINAL VISITOR MESSAGE
        |--------------------------------------------------------------------------
        */

        if (
            contactStep ===
            "waiting_message"
        ) {

            /*
            | Save the visitor's actual concern
            */

            sendVisitorInquiry(message);

            return;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | SEND VISITOR INFORMATION + MESSAGE
    |--------------------------------------------------------------------------
    */

    function sendVisitorInquiry(message) {

        const formData =
            new FormData();


        formData.append(
            "message",
            message
        );


        formData.append(
            "owner_id",
            window.ownerId
        );


        formData.append(
            "visitor_token",
            window.visitorToken
        );


        formData.append(
            "visitor_name",
            visitorName
        );


        formData.append(
            "visitor_phone",
            visitorPhone
        );


        fetch(
            "chat/send.php",
            {
                method: "POST",
                body: formData
            }
        )

        .then(function (response) {

            return response.json();

        })

        .then(function (data) {

            if (!data.success) {

                addBotMessage(
                    "I’m unable to process your message at the moment. Please wait for the owner to assist you."
                );

                return;
            }


            conversationId =
                data.conversation_id || 0;


            /*
            | Final response
            */

            addBotMessage(
                "Got it! Please wait for a representative to reach out to you as soon as possible for a smooth discussion."
            );


            /*
            | Prevent additional messages
            */

            contactStep =
                "completed";


            /*
            | Disable input
            */

            messageInput.disabled =
                true;

            sendBtn.disabled =
                true;

        })

        .catch(function (error) {

            console.error(error);


            addBotMessage(
                "I’m unable to process your message at the moment. Please wait for the owner to assist you."
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SEND BUTTON
    |--------------------------------------------------------------------------
    */

    if (sendBtn) {

        sendBtn.addEventListener(
            "click",
            sendMessage
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ENTER KEY
    |--------------------------------------------------------------------------
    */

    if (messageInput) {

        messageInput.addEventListener(
            "keydown",
            function (event) {

                if (
                    event.key === "Enter"
                ) {

                    event.preventDefault();

                    sendMessage();

                }

            }
        );

    }

});