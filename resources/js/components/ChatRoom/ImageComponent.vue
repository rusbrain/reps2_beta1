<template>
    <div v-if="status" class="component_image">
      <div class="">
        <img v-for="(image, index) in images" :key ="`image-${index}`" 
          :src="`${image.filename}`" 
          :alt="`${image.charactor}`" 
          :title="`${image.charactor}`" @click="selImage(image.charactor)">
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
          images: []
        }
    },
    mounted() {     
      this.getImages();
    },
    methods: {
      getImages: async function(){
        try {      
          let url = '/chat/get_externalimages';  
          let totalImages = this.get_allImages(await apiService.getImages(url));
          this.images = totalImages;
        } catch (err) {
          return [];
        }
      },
      get_allImages: function(data){
        var ImagesObject = [];
        var key;
        var result;      

         /**Get images */
        for (var i = 0; i < data.length; i++) {
            key = data[i]['charactor'];
            result = path + data[i]['filename'];
            ImagesObject.push({'charactor': key, 'filename': result});
        }         
        return ImagesObject;
      },
      selImage: function(image) {
        chatHelper.insertText(image);
        this.$emit("turnOffStatus");
      }  
    }
}
</script>

<style lang="scss">
.component_image{
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
          max-width: 100px;
            padding: 2px;
            cursor: pointer;
            &:hover {
            background: #e6e6e6;
            }
        }
    }
}
 
</style>

