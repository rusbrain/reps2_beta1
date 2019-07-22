<template>
  <vue-window-modal  
    :active="visibleFormCrud"  
    :title="user_email"  
    v-on:clickClose="visibleFormCrudUpdate(false)"
    :height="`642px`"
    :width="`400px`"
    :backgroundColor="`#222222`"
    >
      <div class="chat_container">        
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
                      @focus="true"
                    ></textarea-autosize>                
                  </div>
              </div>
          </div>
          <div class="chat_footer" v-if="!userLoggedin">    
            <p class='guests_message'> Please login to chat!</p> 
          </div>        
      </div>    
  </vue-window-modal>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import vueCustomScrollbar from 'vue-custom-scrollbar';
import  VueWindowModal  from  'vue-window-modal'

Vue.use(VueWindowModal)

export default {
  components: {
    vueCustomScrollbar,    
  },
  props: {
    auth: [Object, Number],
    visibleFormCrud: [Boolean]
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
            return '<a href="' + url + '" target="_blank">' + url + '</a>';
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
        .utc(date.date)
        .local()
        .format("hh:mm");
    },
    ignoreUser: function(userMsg) {      
      this.ignored_userIDs.push(userMsg.user_id);    
      let ignoreUser = {'user_id': userMsg.user_id, 'user_name': userMsg.user_name, 'timestamp': this.convertTo(new Date)}  
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

    visibleFormCrudUpdate: function() {
      this.$emit("onPopupClose", {
        visibleFormCrud: false
      });
    }
  }
};
</script>
