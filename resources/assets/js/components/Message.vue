<template>
    <div>
        <div v-if="!firebaseMessagesLoaded" class="ui active centered inline text loader">انتظر قليلا...</div>
        <div id="comments-container" style="max-height: 55vh;overflow-y: scroll;padding-right:10px;padding-bottom: 40px;">
            <div v-if="historyMessages.length > 0" v-for="message in historyMessages" v-cloak>

                <div v-if="!isMe(message.userId)" class="sixteen wide column">
                    <div class="comment">
                        <a class="avatar">
                          <img src="/img/avatar/default.jpg">
                        </a>
                        <div class="content">
                          <a class="author">{{ getUserName(message.userId) }}</a>
                          <div class="metadata">
                            <span class="date">{{ humanize(message.date)  }}</span>
                          </div>
                          <div class="text">
                            <p>{{ message.text }}</p>
                          </div>
                        </div>
                    </div>
                </div>

                <div v-else class="sixteen wide column">
                    <div  class="comment" style="text-align: right;">
                        <a class="avatar" style="float:right;">
                          <img src="/img/avatar/default.jpg">
                        </a>
                        <div class="content" style="margin-left:0;margin-right: 3.5em;">
                          <div class="metadata">
                            <span class="date">{{ humanize(message.date) }}</span>
                          </div>
                          <a class="author">شخص مجهول x</a>

                          <div class="text">
                            <p>{{ message.text }}</p>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>

         <div v-if="firebaseMessagesLoaded && historyMessages.length < 1">
            <p><small>أرسل أول رساله لبدء المحادثة.
            </small></p>
         </div>


        <form @submit.prevent="sendMessage()" class="ui reply form">
            <div class="field">
                <input v-model="message.text" placeholder="اكتب رسالتك هنا سم اضغط على ارسال" type="text">
            </div>
            <button type="submit" class="ui blue labeled submit icon button">
              <i class="send outline icon"></i> ارسال
            </button>
        </form>
    </div>

    <div class="messages-section" id="message-section-0" data-simplebar style="display:none" >
        <div id="profile-header-background"></div>
        <div id="profile-footer-background"></div>
        <div id="anonymous-settings-panel">
            <img id="anonymous-fadfadah-logo" src="../images/fadfadahLogo.png">
            <div id="user-info-section">
                <img id="anonymous-user-profile-image" src="/images/profilePictures/AXpPbBJzHu32SVU.jpeg">
                <h2 id="anonymous-user-profile-username">Ahmed Osama</h2>
                <div id="last-seen-div">
                    <h2 id="last-seen-text" >منذ 4 ساعات</h2>
                    <h2 id="last-seen-label">اخر ظهور</h2>
                </div>
                <hr id="profile-info-hr">
                <h2 style="margin: 13px 0px -11px 0px;">احفظ رابط المحادثة</h2>
                <h4 style="margin:10px 0px -1px 0px;">لكي تتمكن من الرجوع اليها لاحقا</h4>
                <div id="link-div">

                    <button class="copy-button-ie"   id="copy-button" onclick="copyToClipboard('link-input-text' , ' تم نسخ الرابط')"><img src="../images/copyIcon.png" id="copy-icon"><p id="copy-text">نسخ</p></button>
                    <input value="www.fadfadah.net/chat/RMh5mDtKJE" type="text" id="link-input-text">
                </div>
                <button onclick="window.location.href=window.location.href+'/downloadConversationLink'" class="download-conversation-button" style="margin: -25px 0px 0px 0px;position: relative;bottom: 5px;width: 172px;"><img src="../images/download.svg" class="download-icon"><p class="download-conversation-text">او قم بحفظها من هنا</p></button>
                <hr id="profile-info-hr">
                <div id="anonymous-name-div">
                    <h3 id="anonymous-name-text"> <span id="anonymous-name-label">اسمك المستعار</span> ميدو</h3>
                </div>
            </div>
            <div id="anonymous-create-account-button">
                <h3 style="margin:0px" onclick="goToWelcomePage()">قم بانشاء حسابك الخاص في فضفضة</h3>
            </div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ar_AR/sdk.js#xfbml=1&version=v5.0&appId=286275538778968&autoLogAppEvents=1"></script>
            <div style="position:relative; top:30px; z-index: 100">
                <div class="fb-like" data-href="https://www.facebook.com/&#x641;&#x636;&#x641;&#x636;&#x629;-Fadfadah-2570113289880557/" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true"></div>
            </div>
        </div>
    </div>
    <div class="messages-section" id="own-anonymous-conversations-section" style="display:none;height:calc(100% + 46px);overflow-y: auto;">
        <img height="50" id="loading-icon" src="/images/loadingIcon.svg">
    </div>
    </div>        <div id="footer-div" >
    <div id="emoji-section" style="display:none">
        <div id="emoji-div" >
            <p class="emoji-char">😀</p> <p class="emoji-char">😁</p> <p class="emoji-char">😂</p> <p class="emoji-char">🤣</p> <p class="emoji-char">😃</p> <p class="emoji-char">😄</p> <p class="emoji-char"> 😅</p> <p class="emoji-char">😆</p>
            <p class="emoji-char">😉</p> <p class="emoji-char">😊</p> <p class="emoji-char">😋</p> <p class="emoji-char">😎</p> <p class="emoji-char">😍</p> <p class="emoji-char">😘</p> <p class="emoji-char">😗</p> <p class="emoji-char">😙</p>
            <p class="emoji-char">😚</p> <p class="emoji-char">🙂</p> <p class="emoji-char">🤗</p> <p class="emoji-char">🤩</p> <p class="emoji-char">🤔</p> <p class="emoji-char">🤨</p> <p class="emoji-char">😐</p> <p class="emoji-char">😑</p> <p class="emoji-char">😶</p> <p class="emoji-char">🙄</p> <p class="emoji-char">😏</p> <p class="emoji-char">😣</p> <p class="emoji-char">😥</p> <p class="emoji-char">😮</p> <p class="emoji-char">🤐</p> <p class="emoji-char">😯</p> <p class="emoji-char">😪</p> <p class="emoji-char">😫</p>
            <p class="emoji-char">😴</p> <p class="emoji-char">😌</p> <p class="emoji-char">😛</p> <p class="emoji-char">😜</p> <p class="emoji-char">😝</p> <p class="emoji-char">🤤</p> <p class="emoji-char">😒</p> <p class="emoji-char">😓</p> <p class="emoji-char">😔</p> <p class="emoji-char">😕</p> <p class="emoji-char">🙃</p> <p class="emoji-char">🤑</p> <p class="emoji-char">😲</p> <p class="emoji-char">☹️</p> <p class="emoji-char">🙁</p> <p class="emoji-char">☹️</p> <p class="emoji-char">😞</p>
            <p class="emoji-char">😟</p>
            <br>
            <p class="emoji-char">❤️</p><p class="emoji-char">💛</p> <p class="emoji-char">💚</p> <p class="emoji-char">💙</p> <p class="emoji-char">💜</p> <p class="emoji-char">🖤</p> <p class="emoji-char">💔</p>
        </div>
    </div>

    <div id="conversation-footer" >
        <div id="send-message-div" class="send-message-div-safari">
            <div class="emoji-button-firefox" id="emoji-button"><img id="emoji-icon" src="../../images/emojiIcon.png"></div>
            <textarea placeholder="ضع رسالتك هنا" maxlength="150" class="send-message-textarea-firefox" id="send-message-textarea" rows="1"></textarea>
        </div>
        <div class="send-message-button-ie send-message-button-firefox" id="send-message-button" ><img id="send-message-icon" src="../../images/sendMessageIcon.png"></div>
    </div>


</template>

<script>
    export default {
        props: ['userId', 'chatId', 'receptorName'],
        data() {
            return {
                message: {
                    text: '',
                    date: null
                },
                historyMessages: [],
                firstLoad: false   ,
                firebaseMessagesLoaded: false 
            }
        },
        mounted(){
            database.ref('/chats/' + this.chatId)
                .on('value', snapshot => this.loadMessages(snapshot.val()))
        },
        methods:{

            loadMessages(messages){
                this.firebaseMessagesLoaded= false;
                this.historyMessages = [];
                for(let key in messages) {
                    this.historyMessages.push({
                        userId: messages[key].userId,
                        text: messages[key].text,
                        date: messages[key].date
                    });
                }
                this.showNotification(this.historyMessages.slice(-1).pop());
                this.firstLoad = true;
                //scroll to bottom
                document.querySelector('#comments-container').scrollTop =  document.querySelector('#comments-container').scrollHeight - document.querySelector('#comments-container').clientHeight;
                this.firebaseMessagesLoaded= true;
            },

            sendMessage(){
                if(this.message.text.length > 0){
                    database.ref('/chats/' + this.chatId).push({
                        userId: this.userId,
                        text: this.message.text,
                        date: moment().format()
                    })
                    .then(() => {
                        this.message.text = '';
                    });
                }else {
                    alert('Primero debes escribir algo antes de enviar');
                }
            },

            getUserName(id){
                if(id == this.message.userId) {
                    return "شخص مجهول x";
                }else {
                    return "شخص غريب z"
                }
            },

            isMe(id) {
                if(id == this.userId) {
                    return true;
                }else {
                    return false;
                }
            },

            humanize(date) {
                return moment(date).format('DD-MM-YY h:mma');
            },

            showNotification(message){
                if(this.firstLoad && message.userId != this.message.userId && !windowFocus) {
                    pushjs.create(this.getUserName(message.userId), {
                        body: message.text,
                        timeout: 4000,
                        onClick: function () {
                            window.focus();
                            this.close();
                        }
                    });
                }
                
            }
        }
    }
</script>
