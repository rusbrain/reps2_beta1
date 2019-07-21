<template>
    <div class="chat_container">
        <div class="chat_header">
            <span>{{ user_email }}</span>            
            <a v-if="isMobile()" href="#" class="chat_button" data-tip="Chatroom" onclick="chatroom_toggle(event, $(this))"></a>
            <p v-if="!isMobile()" class="popup" @click="popupChat"></p>
        </div>
        <vue-custom-scrollbar class="chat_text_container" id="chat_text_container">
            <div v-if="ignored_users.length > 0" class="ignoredUsers" v-for="(user,key) in ignored_users" :key="key">
                <p >{{user.user_name}} #{{user.user_id}} {{user.timestamp}} IGNORED <span class="show" @click="showUser(user.user_id)">Show</span></p>
            </div>
            <div v-if="isMessages">               
                <div v-for="(message,index) in messages" :key="`message-${index}`" v-if="!checkIgnore(message.user_id)" class="user_msg" :class="'user-' + message.user_id" >
                  <p class="user_info">                    
                      <span :class="'flag-icon flag-icon-' + message.country_code"></span>
                      <img class="margin-left-5" :src="'/images/emoticons/smiles/'+message.race" alt="">                  
                      <span class="username">{{message.user_name}}</span>
                      <span class="user_id"><a :href="'/user/' + message.user_id" >#{{message.user_id}}</a></span>
                      <span class="ignore_user" v-if="userId!=message.user_id" @click="ignoreUser(message)">Ignore</span>
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
           
        </vue-custom-scrollbar>
        <div class="chat_footer" v-if="userLoggedin">           
            <div class="send">
              <div class="extra">
                <p class="bold" @click="bold()"></p>
                <p class="italic" @click="italic()"></p>
                <p class="underline" @click="underline()"></p>

                <p class="font_size" @click="fontSize()"></p>
                <p class="font_color" @click="fontColor()"></p>

                <p class="pic" @click="selectImage()"></p>
                <p class="smile" @click="selectSmile()"></p>               
                <p class="at" @click="atmark()"></p>
              </div>
              <div class="input-group">
                <textarea-autosize
                  v-model="message"   
                  @keyup.enter.exact.native="sendMessage($event)"
                  @keydown.enter.ctrl.exact.native="newline"
                  @keydown.enter.shift.exact.native="newline"
                  placeholder="Введите сообщение и нажмите Enter"                       
                  :min-height="49"
                  :max-height="350"
                  class="form-control"
                  id="editor"
                  ref="input"
                ></textarea-autosize>                
              </div>
            </div>
        </div>
        <div class="chat_footer" v-if="!userLoggedin">    
          <p class='guests_message'> Please login to chat!</p> 
        </div>        
    </div>    
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import vueCustomScrollbar from 'vue-custom-scrollbar';
import * as chatHelper from '../../helper/chatHelper';
export default {
  components: {
    vueCustomScrollbar,    
  },
  props: {
    auth: [Object, Number],
    
  },
  data() {
    return {
      settings: {
        maxScrollbarLength: 60
      },
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
      user: this.auth,
      ignored_userIDs: [],
      ignored_users: [],
      instance: null
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

    userId: function() {
      if (this.auth != 0) {
        return this.auth.id;
      } else {
        return 0;
      }
    }

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
        let messagePacket = this.createMsgObj(chatHelper.wrapperTxt(this.message));
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

    urlify: chatHelper.urlify,
    convertTo: chatHelper.convertTo,
    isMobile: chatHelper.isMobile,
   
    addChatMessage: function(data) {
      this.messages.unshift(data);
      this.scrollToTop();
    },

    ignoreUser: function(userMsg) {      
      this.ignored_userIDs.push(userMsg.user_id);    
      let ignoreUser = {'user_id': userMsg.user_id, 'user_name': userMsg.user_name, 'timestamp': chatHelper.convertTo(new Date)}  
      this.ignored_users.push(ignoreUser);    
    },

    checkIgnore: function(user_id) {    
      return this.ignored_userIDs.indexOf(user_id) == -1 ? false : true
    },  

    showUser: function(user_id) {     
      this.ignored_userIDs.splice(this.ignored_userIDs.indexOf(user_id), 1);

      let index = this.ignored_users.findIndex(
        element => element.user_id === user_id
      );
      this.ignored_users.splice(index, 1);    
    },
    
    scrollToTop: function() {
      $("#chat_text_container")
        .stop()
        .animate({ scrollTop: 0 }, 1);
    },

    popupChat: function() {     
      this.$emit("onPopup", {
        visibleFormCrud: true
      });
    },
    
    getSelection: function() {
      var txtarea = document.getElementById("editor");
      var start = txtarea.selectionStart;
      var finish = txtarea.selectionEnd;
      var sel = txtarea.value.substring(start, finish);
      return sel;
    },
    bold: function () {
      let sel = this.getSelection();
      if (sel.length > 0) {
        let newValue = document.getElementById("editor").value.replace(sel, '[b]'+sel+'[/b]');
        document.getElementById("editor").value = newValue;
      }
    },
    italic: function() {
      let sel = this.getSelection();
      if (sel.length > 0) {
        let newValue = document.getElementById("editor").value.replace(sel, '[i]'+sel+'[/i]');
        document.getElementById("editor").value = newValue;
      }
    },
    underline: function() {
      let sel = this.getSelection();
      if (sel.length > 0) {
        let newValue = document.getElementById("editor").value.replace(sel, '[u]'+sel+'[/u]');
        document.getElementById("editor").value = newValue;
      }
    },
    atmark: function() {
      
    },
    selectSmile: function() {

    },
    selectImage: function() {

    },
    fontColor: function() {

    },
    fontSize: function(){
      
    }
  }
};
</script>
