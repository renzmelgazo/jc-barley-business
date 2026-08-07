document.addEventListener("DOMContentLoaded", function () {
    const chatButton =
    document.getElementById("chat-button");

const chatBox =
    document.getElementById("chat-box");

if (chatButton && chatBox) {

    chatButton.addEventListener(
        "click",
        function () {

            chatBox.classList.toggle("show");

        }
    );

}

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
    | Website Owner
    |--------------------------------------------------------------------------
    */

    const ownerId =
        window.CHAT_OWNER_ID || 0;


    /*
    |--------------------------------------------------------------------------
    | Visitor Token
    |--------------------------------------------------------------------------
    */

    let visitorToken =
        localStorage.getItem("jc_barley_visitor_token");


    if (!visitorToken) {

        visitorToken =
            crypto.randomUUID();

        localStorage.setItem(
            "jc_barley_visitor_token",
            visitorToken
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Conversation
    |--------------------------------------------------------------------------
    */

    let conversationId =
        parseInt(
            localStorage.getItem(
                "jc_barley_conversation_id"
            ) || "0"
        );


    /*
    |--------------------------------------------------------------------------
    | Visitor Information
    |--------------------------------------------------------------------------
    */

    let visitorName =
        localStorage.getItem(
            "jc_barley_visitor_name"
        ) || "";

    let visitorPhone =
        localStorage.getItem(
            "jc_barley_visitor_phone"
        ) || "";


    /*
    |--------------------------------------------------------------------------
    | Chat State
    |--------------------------------------------------------------------------
    */

    let chatStarted = false;

    let waitingForName = false;

    let waitingForPhone = false;


    /*
    |--------------------------------------------------------------------------
    | Add Message
    |--------------------------------------------------------------------------
    */

    function appendMessage(sender, message) {

        const div =
            document.createElement("div");

        div.className =
            sender === "user"
                ? "user"
                : "bot";

        div.textContent = message;

        chatMessages.appendChild(div);

        chatMessages.scrollTop =
            chatMessages.scrollHeight;
    }


    /*
    |--------------------------------------------------------------------------
    | Start Chat
    |--------------------------------------------------------------------------
    */

    startChatBtn.addEventListener(
        "click",
        async function () {

            chatStartArea.style.display = "none";

            chatInputArea.style.display = "flex";

            chatStarted = true;


            /*
            |--------------------------------------------------------------------------
            | Existing Visitor
            |--------------------------------------------------------------------------
            */

            if (
                conversationId > 0 &&
                visitorName !== "" &&
                visitorPhone !== ""
            ) {

                await loadMessages();

                messageInput.focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Create / Find Conversation
            |--------------------------------------------------------------------------
            */

            try {

                const formData =
                    new FormData();

                formData.append(
                    "action",
                    "start"
                );

                formData.append(
                    "owner_id",
                    ownerId
                );

                formData.append(
                    "visitor_token",
                    visitorToken
                );


                const response =
                    await fetch(
                        "save_contact.php",
                        {
                            method: "POST",
                            body: formData
                        }
                    );


                const data =
                    await response.json();


                if (!data.success) {

                    appendMessage(
                        "bot",
                        "Sorry, we were unable to start the conversation. Please try again."
                    );

                    return;
                }


                conversationId =
                    parseInt(
                        data.conversation_id
                    );


                localStorage.setItem(
                    "jc_barley_conversation_id",
                    conversationId
                );


                /*
                |--------------------------------------------------------------------------
                | Existing Contact
                |--------------------------------------------------------------------------
                */

                if (
                    data.visitor_name &&
                    data.visitor_phone
                ) {

                    visitorName =
                        data.visitor_name;

                    visitorPhone =
                        data.visitor_phone;

                    localStorage.setItem(
                        "jc_barley_visitor_name",
                        visitorName
                    );

                    localStorage.setItem(
                        "jc_barley_visitor_phone",
                        visitorPhone
                    );


                    await loadMessages();

                    messageInput.focus();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Ask Name
                |--------------------------------------------------------------------------
                */

                waitingForName = true;

                appendMessage(
                    "bot",
                    "👋 Hello! Before we proceed, may I know your name and contact number please?"
                );


                messageInput.focus();

            } catch (error) {

                console.error(error);

                appendMessage(
                    "bot",
                    "Sorry, we were unable to connect. Please try again."
                );
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Send Message
    |--------------------------------------------------------------------------
    */

    sendBtn.addEventListener(
        "click",
        sendMessage
    );


    messageInput.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Enter") {

                event.preventDefault();

                sendMessage();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Send Message Function
    |--------------------------------------------------------------------------
    */

    async function sendMessage() {

        const message =
            messageInput.value.trim();


        if (!message) {
            return;
        }


        appendMessage(
            "user",
            message
        );


        messageInput.value = "";


        /*
        |--------------------------------------------------------------------------
        | NAME COLLECTION
        |--------------------------------------------------------------------------
        */

        if (waitingForName) {

            visitorName = message;

            localStorage.setItem(
                "jc_barley_visitor_name",
                visitorName
            );


            waitingForName = false;

            waitingForPhone = true;


            appendMessage(
                "bot",
                "Thank you, " +
                visitorName +
                ". May I have your phone number please?"
            );


            messageInput.focus();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PHONE COLLECTION
        |--------------------------------------------------------------------------
        */

        if (waitingForPhone) {

            const phone =
                message.replace(
                    /[\s\-\(\)\+]/g,
                    ""
                );


            /*
            |--------------------------------------------------------------------------
            | Validate Phone
            |--------------------------------------------------------------------------
            */

            if (!/^\d{7,15}$/.test(phone)) {

                appendMessage(
                    "bot",
                    "We cannot proceed with the chat without a valid phone number. Please provide your phone number so the owner can contact you."
                );

                messageInput.focus();

                return;
            }


            visitorPhone = message;


            localStorage.setItem(
                "jc_barley_visitor_phone",
                visitorPhone
            );


            /*
            |--------------------------------------------------------------------------
            | Save Contact
            |--------------------------------------------------------------------------
            */

            try {

                const formData =
                    new FormData();

                formData.append(
                    "action",
                    "save_contact"
                );

                formData.append(
                    "owner_id",
                    ownerId
                );

                formData.append(
                    "visitor_token",
                    visitorToken
                );

                formData.append(
                    "name",
                    visitorName
                );

                formData.append(
                    "phone",
                    visitorPhone
                );


                const response =
                    await fetch(
                        "save_contact.php",
                        {
                            method: "POST",
                            body: formData
                        }
                    );


                const data =
                    await response.json();


                if (!data.success) {

                    appendMessage(
                        "bot",
                        "Sorry, we could not save your contact information. Please try again."
                    );

                    return;
                }


                conversationId =
                    parseInt(
                        data.conversation_id
                    );


                localStorage.setItem(
                    "jc_barley_conversation_id",
                    conversationId
                );


                waitingForPhone = false;


                appendMessage(
                    "bot",
                    "Thank you! Your contact information has been saved. How may I assist you today?"
                );


                messageInput.focus();

                return;

            } catch (error) {

                console.error(error);

                appendMessage(
                    "bot",
                    "Sorry, we could not save your contact information. Please try again."
                );

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL CHAT
        |--------------------------------------------------------------------------
        */

        await sendToServer(message);

    }


    /*
    |--------------------------------------------------------------------------
    | Send Normal Message To PHP
    |--------------------------------------------------------------------------
    */

    async function sendToServer(message) {

        try {

            const formData =
                new FormData();

            formData.append(
                "message",
                message
            );

            formData.append(
                "owner_id",
                ownerId
            );

            formData.append(
                "visitor_token",
                visitorToken
            );

            formData.append(
                "conversation_id",
                conversationId
            );


            const response =
                await fetch(
                    "send.php",
                    {
                        method: "POST",
                        body: formData
                    }
                );


            const data =
                await response.json();


            if (!data.success) {

                appendMessage(
                    "bot",
                    "Sorry, something went wrong. Please try again."
                );

                return;
            }


            appendMessage(
                "bot",
                data.reply
            );


        } catch (error) {

            console.error(error);

            appendMessage(
                "bot",
                "I’m unable to answer that at the moment. Please wait for the owner to assist you."
            );
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Load Previous Messages
    |--------------------------------------------------------------------------
    */

    async function loadMessages() {

        try {

            const url =
                "load_messages.php" +
                "?owner_id=" +
                encodeURIComponent(ownerId) +
                "&visitor_token=" +
                encodeURIComponent(visitorToken) +
                "&conversation_id=" +
                encodeURIComponent(conversationId);


            const response =
                await fetch(url);


            const data =
                await response.json();


            if (!data.success) {
                return;
            }


            chatMessages.innerHTML = "";


            data.messages.forEach(
                function (msg) {

                    appendMessage(
                        msg.sender === "Visitor"
                            ? "user"
                            : "bot",
                        msg.message
                    );

                }
            );


        } catch (error) {

            console.error(error);

        }

    }


});