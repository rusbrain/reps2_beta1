<template>
    <div>
        <MessageComponent :auth="auth" @onPopup="popup" ></MessageComponent>
        <ChatPopup :auth="auth" :visibleFormCrud="visibleFormCrud" @onPopupClose="popupClose"></ChatPopup>
    </div>
</template>

<script>

import MessageComponent from './MessageComponent.vue'
import ChatPopup from './ChatPopup.vue'

export default {
  components: {
    MessageComponent,
    ChatPopup
  }, 
  props: {
    auth: [Object, Number]
  },
  data() {
    return {
      visibleFormCrud: false
    }
  },

   methods: {
    popup: function() {
      this.visibleFormCrud = true;
    },

    popupClose: function() {
      this.visibleFormCrud = false;
    }
   }
}
</script>
