<template>
    <div v-if="status" class="component_smiles">
      <div class="">
        <img v-for="(smile, index) in smiles" :key ="`smile-${index}`" 
          :src="`/images/${smile.filename}`" 
          :alt="`${smile.charactor}`" 
          :title="`${smile.charactor}`" @click="selSmile(smile.charactor)">
      </div>
    </div>
</template>

<script>

import * as apiService from '../../helper/serviceHelper';
import * as chatHelper from '../../helper/chatHelper';

export default {
    props: ['status'],
    data() {
        return {
          smiles: []
        }
    },
    mounted() {     
      this.getSmiles();
    },
    methods: {
      getSmiles: async function(){
        try {      
          let url = '/chat/get_externalsmiles';  
          const extraSmiles = await apiService.getSmiles(url);          
          let totalSmiles = this.get_allSmiles(extraSmiles);
          this.smiles = totalSmiles;
        } catch (err) {
          return [];
        }
      },
      get_allSmiles: function(extra_smiles){

        var path = 'emoticons/smiles/';
        var smile = 's';
        var extension = '.gif';
        var qty = 63;
        var smilesObject = [];
        var key;
        var result;

        for (var i = 0; i <= qty; i++) {
            key = ':'+ smile + i+':';
            result = path + smile + i + extension;
            smilesObject.push({'charactor': key, 'filename': result});
        } 

         /**Get extra smiles */
        for (var i = 0; i < extra_smiles.length; i++) {
            key = extra_smiles[i]['charactor'];
            result = path + extra_smiles[i]['filename'];
            smilesObject.push({'charactor': key, 'filename': result});
        }         
        return smilesObject;
      },
      selSmile: function(smile) {
        chatHelper.insertText(smile);
        this.$emit("turnOffStatus");
      }  
    }
}
</script>

<style lang="scss">
.component_smiles{
    position: absolute;
    bottom: 85px;
    border: solid 1px gray;
    padding: 4px;
    right: 6px;
    width: 205px;
    height: auto;
    background: white;
    div {
      img {
        padding: 2px;
        cursor: pointer;
        &:hover {
          background: #e6e6e6;
        }
      }
    }
}
 
</style>

