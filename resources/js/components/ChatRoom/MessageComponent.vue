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

    popupChat: function() {     
      this.$emit("onPopup", {
        visibleFormCrud: true
      });
    },
    isMobile: function() {
      var check = false;
      (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
      return check;
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
