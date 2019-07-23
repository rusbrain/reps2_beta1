<template>
    <div v-if="status" class="component_size">
        <div class="">
            <span v-for="(size, index) in sizes" :key ="`size-${index}`" @click="selSize(size)" :style="`font-size: ${size.size}`">
              {{size.key}}
            </span>       
        </div>
    </div>
</template>

<script>

import * as chatHelper from '../../helper/chatHelper';

export default {
    props: ['status'],
    data() {
        return {
            sizes: [
              {'key': 'f1', 'size': '14px'},
              {'key': 'f2', 'size': '16px'},
              {'key': 'f3', 'size': '18px'},
            ]
        }
    },
   
    methods: {      
        selSize: function(size) {
            let textareaObj = chatHelper.textareaObj();

            let sel = chatHelper.getSelection();
            if (sel.length > 0) {
            let newValue = textareaObj.value.replace(sel, '[' + size.key + ']' + sel +'[/' + size.key + ']');
                textareaObj.value = newValue;
            } else {
                chatHelper.insertText('[' + size.key + '][/' + size.key + ']')
            }
            
            this.$emit("turnOffStatus");
        }  
    }
}
</script>

<style lang="scss">
.component_size{
    position: absolute;
    bottom: 85px;
    border: solid 1px gray;
    padding: 4px 0;
    right: 6px;
    width: 110px;
    max-height: 40px;
    height: 40px;
    margin: auto;
    overflow-y: hidden;
    background: white;
    div {
        margin: 4px;
        text-align: center;
        span {         
            padding: 5px;
            cursor: pointer;
            border: solid 1px #e0dddd;
            margin: 2px;
            &:hover {
                background: #e6e6e6;
            }
        }
    }
}
 
</style>

