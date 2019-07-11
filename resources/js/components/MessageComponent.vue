<template>
    <div class="chat_container">
        <div class="chat_header">
            <span>{{ user_email }}</span>
        </div>
        <div class="chat_text_container" id="chat_text_container">
            <div v-if="isMessages">
                <div v-for="message in messages" class="user_msg">
                    <p class="user_info">
                        <span class="username">{{message.user_name}}</span>
                        <span class="user_id"><a :href="'/user/' + message.user_id" >#{{message.user_id}}</a></span>
                        <span class="msg_timestamp">{{convertTo(message.created_at)}}</span>
                    </p>
                    <p class="msg_text">
                       <span v-html="urlify(message.message)"></span>
                    </p>
                </div>
            </div>
             <div v-if="!isMessages">
                 Empty messages
             </div>
           
        </div>
        <div class="chat_footer" v-if="userLoggedin">           
            <div class="send">
               <div class="input-group">
                  <textarea-autosize
                    v-model="message"   
                    @keyup.enter.exact.native="sendMessage($event)"
                    @keydown.enter.ctrl.exact.native="newline"
                    @keydown.enter.shift.exact.native="newline"
                    placeholder="Type something here..."                       
                    :min-height="10"
                    :max-height="350"
                    class="form-control"
                  ></textarea-autosize>                
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
export default {
  props: {
    auth: [Object, Number]
  },
  data() {
    return {
      socketConnected: {
        status: false,
        msg: "Connecting Please Wait..."
      },
      socket:null,
      userLoggedin: false,
      messages: [],
      isMessages: false,
      message: "",
      typing: "",
      timeout: "",
      user: this.auth
    };
  },
  computed: {
    user_email: function() {
      if (this.auth != 0) {
        this.userLoggedin = true;
        return this.auth.email;
      } else {
        return "Guest";
      }
    },

  },
  mounted() {
    
    var socket = io(process.env.MIX_SOCKET_SERVER, { query: "id= " + this.auth.id });
    this.socket = socket;

    socket.on("connect", () => {
      socket.emit("getMessages");
    });
    socket.on("getMessagesResponse", data => {
      this.getMessagesResponse(data);
    });

    socket.on("addMessageResponse", data => {
      this.addChatMessage(data);
    });
    socket.on("user-join", data => {
      this.log(data + " joined at this room");
    });
    socket.on("user-unjoin", data => {
      this.log(data + " left this room");
    });
  },
  methods: {
    getMessagesResponse: function(data) {
      if (data != null) {
        this.messages = data.result;
        this.isMessages = true;
      }
    },
    newline() {
      this.message = `${this.message}\n`;
    },
    sendMessage(event) {
      if (this.message.length > 0) {
        let messagePacket = this.createMsgObj(this.wrapperTxt(this.message));
        event.preventDefault();
        let currentObj = this;
        let self = this;
        axios.post('/chat/insert_message', messagePacket)
        .then(function (response) {           
            if(response.data.status == 'ok') {
              let data = {'id':response.data.id, 'user_id': response.data.user}               
              self.socket.emit("sendMessage", data);
            }
        })
        .catch(function (error) {
            currentObj.output = error;
        });
        
        this.message = "";
      } else {
        alert("Please Enter Your Message.");
      }      
    },
    createMsgObj: function(message) {
      return {
        user_id: this.auth.id,
        file_path: "",
        message: message,
        imo: ""
      };
    },

    urlify:function(text) {
        text.replace(/(\\r)*\\n/g, '<br>')
        var urlRegex = /(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$])/igm;
        return text.replace(urlRegex, function(url) {
            return '<a href="' + url + '">' + url + '</a>';
        })
    },
    wrapperTxt: function(text) {
      let lines = text.split('\n');
      let wrap_text = '';
      lines.forEach(function(item, index){
        if(item != '')
          wrap_text += '<p>' +item+ '</p>'
      });
      return wrap_text;
    },
    addChatMessage: function(data) {
      this.messages.unshift(data);
      this.scrollToTop();
    },

    convertTo: function(date) {
      return moment
        .utc(date)
        .local()
        .format("hh:mm");
    },

    scrollToTop: function() {
      $("#chat_text_container")
        .stop()
        .animate({ scrollTop: 0 }, 1);
    }
  }
};
</script>
