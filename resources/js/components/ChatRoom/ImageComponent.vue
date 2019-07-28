<template>
    <div v-if="status" class="component_image">
      <b-card no-body>
        <b-tabs v-model="tabIndex" card>
          <b-tab v-for="(imagesbycategory, key ) in images" :key ="`${key}`" :title="`${key}`" >
            <div class="">
              <img v-for="(image, index) in imagesbycategory" :key ="`image-${index}`" 
                :src="`${image.filepath}`" 
                :alt="`${image.charactor}`" 
                :title="`${image.charactor}`" @click="selImage(image.charactor)">
            </div>
          </b-tab>         
        </b-tabs>
      </b-card>      
    </div>
</template>

<script>
import * as apiService from "../../helper/serviceHelper";
import * as chatHelper from "../../helper/chatHelper";

export default {
  props: ["status"],
  data() {
    return {
      images: [],
      tabIndex: 0
    };
  },

  mounted() {
    this.getImages();
  },

  methods: {    
    getImages: async function() {
      try {
        let url = "/chat/get_externalimages";
        let totalImages = this.get_allImages(await apiService.getImages(url));
        if (totalImages.length > 0) this.tabIndex = Object.keys(totalImages)[0];
        this.images = totalImages;
      } catch (err) {
        return [];
      }
    },
    get_allImages: function(data) {
      return data;
    },
    selImage: function(image) {
      chatHelper.insertText(image);
      this.$emit("turnOffStatus");
    }
  }
};
</script>

<style lang="scss">
.component_image {
  position: absolute;
  bottom: 85px;
  border: solid 1px gray;
  padding: 4px;
  right: 6px;
  width: 256px;
  max-height: 500px;
  overflow-y: auto;
  background: white;
  .card {
    .tabs {
      .card-header {
        margin: 0;
        ul {
          margin: 2px 0;
          li a {
            padding: 3px !important;
            font-size: 12px;
            &.active {
              background: #2f6696;
              color: #fff;
            }
          }
        }
      }
    }
  }
  div {
    img {
      max-width: 75px;
      padding: 2px;
      cursor: pointer;
      &:hover {
        background: #e6e6e6;
      }
    }
  }
}
</style>

