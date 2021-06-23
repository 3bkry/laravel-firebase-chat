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
                          <a class="author">{{ getUserName(message.userId) }}</a>

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


        <form @submit.prevent="sendMessage()" class="ui reply form" dir="rtl">
            <div class="field">
                <input v-model="message.text" placeholder="اكتب رسالتك هنا ثم اضغط على ارسال" type="text">
            </div>
            <button type="submit" class="ui blue labeled submit icon button">
              <i class="send outline icon"></i> ارسال
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['userId','operatorId','chatId', 'clientName'],
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
                setTimeout(function(){
                  document.querySelector('#comments-container').scrollTop =  document.querySelector('#comments-container').scrollHeight - document.querySelector('#comments-container').clientHeight;
                }, 200);
                this.firebaseMessagesLoaded= true;
            },

            sendMessage(){
                if(this.message.text.length > 0){
                    database.ref('/chats/' + this.chatId).push({
                        userId: this.operatorId,
                        text: this.message.text,
                        date: moment().format()
                    })
                    .then(() => {
                        this.message.text = '';
                    });

                  const requestOptions = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(
                        {
                          "from": "page",
                          "to": this.userId,
                          "text": this.message.text
                        }
                    )
                  };
                  fetch("https://customerservice.dospost.com/send", requestOptions)
                      .then(response => response.json());


                }else {
                    alert('يجب كتابة شئ قبل الارسال');
                }
            },

            getUserName(id){
                if(id == this.message.userId) {
                    return this.clientName;
                }else {
                  return this.clientName;
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
