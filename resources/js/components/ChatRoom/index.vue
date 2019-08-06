<template>
    <div>
        <MessageComponent 
          :auth="auth" 
          @onPopup="popup"
          :socket="socket"
          :messages="messages" 
          :isMessages="isMessages">
        </MessageComponent>      
        <input type="hidden" id="popupStatus"/>
    </div>
</template>

<script>

import MessageComponent from './MessageComponent.vue'

export default {
  components: {
    MessageComponent,
  }, 
  props: {
    auth: [Object, Number]
  },
  data() {
    return {
      visibleFormCrud: false,
      socket: null,
      messages:[],
      isMessages: false,
    }
  },

  mounted() {    
    var socket = io(process.env.MIX_SOCKET_SERVER, { query: "id= " + this.auth.id });
    this.socket = socket;
    var self = this;

    socket.on("connect", () => {
      socket.emit("getMessages");
    });
    socket.on("getMessagesResponse", data => {
      this.getMessagesResponse(data);
    });

    socket.on("addMessageResponse", data => {
      this.addChatMessage(data);
    });   
  },  

   methods: {
    getMessagesResponse: function(data) {
      if (data != null) {
        this.messages = data.result;
        this.isMessages = true;
      }
    },
    addChatMessage: function(data) {
      this.messages.unshift(data);
      this.scrollToTop();
    },

    scrollToTop: function() {
      $("#chat_text_container")
        .stop()
        .animate({ scrollTop: 0 }, 1);
    },
    popup: function() {
      this.visibleFormCrud = true;
      document.getElementById("popupStatus").value = 1

    },

    popupClose: function() {
      this.visibleFormCrud = false;
      document.getElementById("popupStatus").value = 0
    }
   }
}
</script>
