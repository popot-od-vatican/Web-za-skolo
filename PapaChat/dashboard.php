<?php
    session_start();

    if(!isset($_SESSION['Username']))
    {
        header("Location: /login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Dashboard</title>
    </head>
    <body>
        <div class="top-menu">
            <div class="papalogo">
                PapaChat
            </div>
            <div class="user-menu">
                <img src="images/person-icon.png" alt="Person Icon" width="47px" height="47px" valign="middle">
                <a class="top-menu-items" href="profile.php">
                    <?php echo $_SESSION['Username']; ?>
                </a>
                <a class="top-menu-items" href="login.php">
                    Log out
                </a>
            </div>
        </div>
        <div class="main">
            <div class="groups">
                <div class="group-item">
                    <input type="text" size="24" class="group-input" placeholder="Search for a person" onkeyup="Search(this.value)"
                        onclick="ShowDropdown()">
                    <div class="drop-down" id="DROPDOWN_ID">
                        <ul id="search-content">
                        </ul>
                    </div>
                </div>
                <div class="group-item" id="CHATLIST_ID">
                </div>
            </div>
            <div class="chat">
                <div class="chat-content" id="CHATCONTENT_ID">
                </div>
                <div class="message-box">
                    <input type="text" placeholder="Enter your message" class="message-box" id="MESSAGEBOX_ID" size=60>
                    <button id="SENDBUTTON_ID" onclick="SendMessage()">Send</button>
                </div>
            </div>
        </div>
        <script>
            let DropDown = document.getElementById("DROPDOWN_ID");
            let DropDownContent = document.getElementById("search-content");
            let ChatContent = document.getElementById("CHATCONTENT_ID");
            let CurrentUser = "<?php echo $_SESSION['Username'] ?>";
            let SendButton = document.getElementById("SENDBUTTON_ID");
            let MessageBox = document.getElementById("MESSAGEBOX_ID");
            let ChatList = document.getElementById("CHATLIST_ID");

            function Search(Str)
            {

                DropDownContent.innerHTML = "";
                let Data;

                let XMLRequest = new XMLHttpRequest();
                XMLRequest.onreadystatechange = function()
                {
                    if (this.readyState == 4 && this.status == 200) {
                        Data = JSON.parse(this.responseText);
                        
                        for(let i = 0; i < Data.length-1; ++i)
                        {
                            let ListItem = document.createElement("li");
                            ListItem.innerHTML = Data[i];
                            ListItem.classList.add("drop-down-item");
                            DropDownContent.appendChild(ListItem);
                        }
                        
                        if(Data.length >= 2)
                        {
                            let ResultsFound = document.createElement("li");
                            ResultsFound.innerHTML = Data[Data.length - 1] + " Results found!";
                            ResultsFound.classList.add("drop-down-item");
                            DropDownContent.appendChild(ResultsFound);
                        }
                        else
                        {
                            let ResultsFound = document.createElement("li");
                            ResultsFound.innerHTML = Data[Data.length - 1];
                            ResultsFound.classList.add("drop-down-item");
                            DropDownContent.appendChild(ResultsFound);
                        }
                    }
                }

                XMLRequest.open("GET", "search.php?target="+Str, true);
                XMLRequest.send();
            }

            function ShowDropdown()
            {
                DropDown.style.display = "block";
            }
            
            function HideDropdown()
            {
                DropDown.style.display = "none";
            }


            window.onclick = e => 
            {

                if(e.target.tagName == 'LI')
                {
                    let Chat = new XMLHttpRequest();
                    Chat.onreadystatechange = function()
                    {
                        if (this.readyState == 4 && this.status == 200) {
                            ChatContent.innerHTML = "";
                            let Data;
                            
                            try{
                                Data = JSON.parse(this.responseText);
                                Data = JSON.parse(Data);
                            }catch(err)
                            {
                                return;
                            }
                            
                            for(let i = 0; i < Data.length; ++i)
                            {
                                let MessageContainer = document.createElement('div');
                                let MessageOwner = document.createElement('div');
                                let MessageText = document.createElement('div');
                                let OwnerSpan = document.createElement('span');
                                let TextSpan = document.createElement('span');

                                OwnerSpan.innerHTML = Data[i]['Owner'];
                                TextSpan.innerHTML = Data[i]['Content'];

                                if(Data[i]['Owner'] == CurrentUser)
                                {
                                    OwnerSpan.innerHTML = "You";
                                    OwnerSpan.classList.add("chat-current");
                                    TextSpan.classList.add("chat-current");
                                    MessageOwner.style.textAlign = "right";
                                    MessageText.style.textAlign = "right";
                                }
                                else
                                {
                                    OwnerSpan.classList.add("chat-other");
                                    TextSpan.classList.add("chat-other");
                                }

                                OwnerSpan.style.backgroundColor = "inherit";
                                OwnerSpan.style.color = "#d0d0d0";

                                MessageOwner.appendChild(OwnerSpan);
                                MessageText.appendChild(TextSpan);

                                MessageContainer.appendChild(MessageOwner);
                                MessageContainer.appendChild(MessageText);
                                MessageContainer.classList.add("Message");
                                ChatContent.appendChild(MessageContainer);
                                ChatContent.scrollTop = ChatContent.scrollHeight - ChatContent.clientHeight;
                            }
                        }
                    }
                    Chat.open("GET", "createchat.php?target="+e.target.innerHTML+"&source=" + "<?php echo $_SESSION["Username"] ?>", true);
                    Chat.send();
                }
                else if(e.target.tagName == 'INPUT' && e.target.size == 24)
                {
                    ShowDropdown();
                }
                else if(e.target.tagName == "DIV" && e.target.children.length == 2)
                {
                    let Chat = new XMLHttpRequest();
                    Chat.onreadystatechange = function()
                    {
                        if (this.readyState == 4 && this.status == 200) {
                            ChatContent.innerHTML = "";
                            let Data;
                            
                            try{
                                Data = JSON.parse(this.responseText);
                                Data = JSON.parse(Data);
                            }catch(err)
                            {
                                return;
                            }
                            
                            for(let i = 0; i < Data.length; ++i)
                            {
                                let MessageContainer = document.createElement('div');
                                let MessageOwner = document.createElement('div');
                                let MessageText = document.createElement('div');
                                let OwnerSpan = document.createElement('span');
                                let TextSpan = document.createElement('span');

                                OwnerSpan.innerHTML = Data[i]['Owner'];
                                TextSpan.innerHTML = Data[i]['Content'];

                                if(Data[i]['Owner'] == CurrentUser)
                                {
                                    OwnerSpan.innerHTML = "You";
                                    OwnerSpan.classList.add("chat-current");
                                    TextSpan.classList.add("chat-current");
                                    MessageOwner.style.textAlign = "right";
                                    MessageText.style.textAlign = "right";
                                }
                                else
                                {
                                    OwnerSpan.classList.add("chat-other");
                                    TextSpan.classList.add("chat-other");
                                }

                                OwnerSpan.style.backgroundColor = "inherit";
                                OwnerSpan.style.color = "#d0d0d0";

                                MessageOwner.appendChild(OwnerSpan);
                                MessageText.appendChild(TextSpan);

                                MessageContainer.appendChild(MessageOwner);
                                MessageContainer.appendChild(MessageText);
                                MessageContainer.classList.add("Message");
                                ChatContent.appendChild(MessageContainer);
                                ChatContent.scrollTop = ChatContent.scrollHeight - ChatContent.clientHeight;
                            }
                        }
                    }
                    Chat.open("GET", "createchat.php?target="+e.target.children[1].innerHTML+"&source=" + "<?php echo $_SESSION["Username"] ?>", true);
                    Chat.send();
                    HideDropdown();
                }
                else if((e.target.tagName == "SPAN" || e.target.tagName == "IMG" || e.target.tagName == "DIV") && e.target.parentElement.children.length == 2
                    && e.target.parentElement.children[1].tagName == "SPAN")
                {
                    let Chat = new XMLHttpRequest();
                    Chat.onreadystatechange = function()
                    {
                        if (this.readyState == 4 && this.status == 200) {
                            ChatContent.innerHTML = "";
                            let Data;
                            
                            try{
                                Data = JSON.parse(this.responseText);
                                Data = JSON.parse(Data);
                            }catch(err)
                            {
                                return;
                            }
                            
                            for(let i = 0; i < Data.length; ++i)
                            {
                                let MessageContainer = document.createElement('div');
                                let MessageOwner = document.createElement('div');
                                let MessageText = document.createElement('div');
                                let OwnerSpan = document.createElement('span');
                                let TextSpan = document.createElement('span');

                                OwnerSpan.innerHTML = Data[i]['Owner'];
                                TextSpan.innerHTML = Data[i]['Content'];

                                if(Data[i]['Owner'] == CurrentUser)
                                {
                                    OwnerSpan.innerHTML = "You";
                                    OwnerSpan.classList.add("chat-current");
                                    TextSpan.classList.add("chat-current");
                                    MessageOwner.style.textAlign = "right";
                                    MessageText.style.textAlign = "right";
                                }
                                else
                                {
                                    OwnerSpan.classList.add("chat-other");
                                    TextSpan.classList.add("chat-other");
                                }

                                OwnerSpan.style.backgroundColor = "inherit";
                                OwnerSpan.style.color = "#d0d0d0";

                                MessageOwner.appendChild(OwnerSpan);
                                MessageText.appendChild(TextSpan);

                                MessageContainer.appendChild(MessageOwner);
                                MessageContainer.appendChild(MessageText);
                                MessageContainer.classList.add("Message");
                                ChatContent.appendChild(MessageContainer);
                                ChatContent.scrollTop = ChatContent.scrollHeight - ChatContent.clientHeight;
                            }
                        }
                    }
                    Chat.open("GET", "createchat.php?target="+e.target.parentElement.children[1].innerHTML+"&source=" + "<?php echo $_SESSION["Username"] ?>", true);
                    Chat.send();
                    HideDropdown();
                }
                else
                {
                    HideDropdown();
                }
            }

            function SendMessage()
            {
                if(MessageBox.value.trim() === '')
                {
                    return;
                }

                let Request = new XMLHttpRequest();

                Request.onreadystatechange = function()
                {
                    if (this.readyState == 4 && this.status == 200) {
                    }
                }

                Request.open("GET", "handlemessages.php?message="+MessageBox.value, true);
                Request.send();

                MessageBox.value = "";
            }

            function Update()
            {
                let UpdateContents = new XMLHttpRequest();

                UpdateContents.onreadystatechange = function()
                {
                    if (this.readyState == 4 && this.status == 200)
                    {
                        ChatContent.innerHTML = "";
                        let Data;

                        try{
                            Data = JSON.parse(this.responseText);
                            Data = JSON.parse(Data);
                        }catch(err)
                        {
                            return;
                        }
                            
                        for(let i = 0; i < Data.length; ++i)
                        {
                            let MessageContainer = document.createElement('div');
                            let MessageOwner = document.createElement('div');
                            let MessageText = document.createElement('div');
                            let OwnerSpan = document.createElement('span');
                            let TextSpan = document.createElement('span');

                            OwnerSpan.innerHTML = Data[i]['Owner'];
                            TextSpan.innerHTML = Data[i]['Content'];

                            if(Data[i]['Owner'] == CurrentUser)
                            {
                                OwnerSpan.innerHTML = "You";
                                OwnerSpan.classList.add("chat-current");
                                TextSpan.classList.add("chat-current");
                                MessageOwner.style.textAlign = "right";
                                MessageText.style.textAlign = "right";
                                OwnerSpan.style.padding = "1px 6px 1px 1px";
                            }
                            else
                            {
                                OwnerSpan.classList.add("chat-other");
                                TextSpan.classList.add("chat-other");
                                OwnerSpan.style.padding = "1px 1px 1px 6px";
                            }

                            OwnerSpan.style.backgroundColor = "inherit";
                            OwnerSpan.style.color = "#d0d0d0";

                            MessageOwner.appendChild(OwnerSpan);
                            MessageText.appendChild(TextSpan);

                            MessageContainer.appendChild(MessageOwner);
                            MessageContainer.appendChild(MessageText);
                            MessageContainer.classList.add("Message");
                            ChatContent.appendChild(MessageContainer);
                        }
                    }
                }

                UpdateContents.open("GET", "updatecontent.php", true);
                UpdateContents.send();

                let UpdateChatList = new XMLHttpRequest();

                UpdateChatList.onreadystatechange = function ()
                {
                    if (this.readyState == 4 && this.status == 200)
                    {
                        ChatList.innerHTML = "";

                        let Data = JSON.parse(this.responseText);

                        for(let i = 0; i < Data['direct'].length; ++i)
                        {
                            let Item = document.createElement("div");
                            let ItemHeader = document.createElement("div");
                            let ItemBody = document.createElement("div");
                            let ItemImage = document.createElement("img");
                            let ItemName = document.createElement("span");

                            ItemName.innerHTML = Data['direct'][i]['Name'];
                            ItemImage.src = 'images/person-icon.png';
                            ItemImage.style.width = "40px";
                            ItemImage.classList.add("item-image");

                            ItemBody.innerHTML = Data['direct'][i]['Message'];
                            
                            ItemHeader.appendChild(ItemImage);
                            ItemHeader.appendChild(ItemName);

                            ItemBody.classList.add("group-item-body");
                            ItemHeader.classList.add("group-item-head");

                            Item.appendChild(ItemHeader);
                            Item.appendChild(ItemBody);
                            Item.classList.add("group-item");
                            ChatList.appendChild(Item);
                        }
                    }
                }

                UpdateChatList.open("GET", "updatechatlist.php", true);
                UpdateChatList.send();
            }

            setInterval(Update, 500);

        </script>
    </body>
</html>