<template>
    <div v-if="status" class="component_users">
      <div class="">
        <p v-for="(user, index) in filtered_users" :key ="`user-${index}`" 
          @click="selUser(user)">{{user}}</p>
      </div>
    </div>
</template>

<script>

import * as apiService from '../../helper/serviceHelper';
import * as chatHelper from '../../helper/chatHelper';

export default {
    props: ['status','filter_user'],
    data() {
        return {
          users: [],
          filtered_users: []
        }
    },
    mounted() {     
      this.getusers();
    },
  
    methods: {
      getusers: async function(){
        try {      
          let url = '/chat/get_chatusers';  
          const chatusers = await apiService.getChatUsers(url);          
          this.users = chatusers;
        } catch (err) {
          return [];
        }
      },
     
      selUser: function(user) {
        chatHelper.insertText(user);
        this.$emit("turnOffStatus");
      }  
    }
}
</script>

<style lang="scss">
.component_users{
    position: absolute;
    bottom: 85px;
    border: solid 1px gray;
    padding: 4px;
    right: 6px;
    width: 205px;
    max-height: 400px;
    overflow-y: auto;
    height: auto;
    background: white;
    div {
      p{

      }
    }
}
 
</style>

