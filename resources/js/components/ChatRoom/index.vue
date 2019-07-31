<template>
    <div>
        <MessageComponent 
          :auth="auth" @onPopup="popup" 
          :visibleFormCrud="visibleFormCrud" 
          @onPopupClose="popupClose">
        </MessageComponent>
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
