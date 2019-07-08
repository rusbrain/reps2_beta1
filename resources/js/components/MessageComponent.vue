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
                        <span class="user_id">#{{message.user_id}}</span>
                        <span class="msg_timestamp">{{convertTo(message.created_at)}}</span>
                    </p>
                    <p class="msg_text">
                       {{message.message}}
                    </p>
                </div>
            </div>
             <div v-if="!isMessages">
                 Empty messages
             </div>
           
        </div>
        <div class="chat_footer" v-if="userLoggedin">
            <div class="importing"></div>
            <div class="send">
               <div class="input-group">
                    <input name="message" v-model.trim="message" placeholder="Введите сообщение и нажмите Enter" class="form-control" 
                    type="text" v-on:keydown="sendMessage($event)">
                    <!-- <span class="input-group-btn">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i>
                            <input name="attachment" type="file" v-on:change="file($event)">
                        </div>
                    </span> -->
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
var moment = require("moment");
var socket = io(process.env.MIX_SOCKET_SERVER);

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
    }
  },
  mounted() {
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
    sendMessage(event) {
      if (event.keyCode === 13) {
        if (this.message.length > 0) {
          let messagePacket = this.createMsgObj(this.message);
          socket.emit("sendMessage", messagePacket);
          this.message = "";
        } else {
          alert("Please Enter Your Message.");
        }
      }
    },
    createMsgObj: function(message) {
      return {
        user_id: this.auth.id,
        user_name: this.auth.name,
        file_path: "",
        message: message,
        imo: ""
      };
    },

    addChatMessage: function(data) {
      this.messages.push(data);
      this.scrollToBottom();
    },

    convertTo: function(date) {
      return moment
        .utc(date)
        .local()
        .format("hh:mm");
    },

    scrollToBottom: function() {
      $("#chat_text_container")
        .stop()
        .animate({ scrollTop: $("#chat_text_container")[0].scrollHeight }, 1);
    }
  }
};
</script>
