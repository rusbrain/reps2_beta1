<template>
    <div v-if="status" class="component_color">
        <div class="">
            <span v-for="(color, index) in colors" :key ="`color-${index}`" @click="selColor(color)" :style="`color: ${color.color}`">
              {{color.key}}
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
            colors: [
              {'key': 'c1', 'color': '#FFFF77'},
              {'key': 'c2', 'color': '#FF77FF'},
              {'key': 'c3', 'color': '#77FFFF'},
              {'key': 'c4', 'color': '#FFAAAA'},
              {'key': 'c5', 'color': '#AAFFAA'},
              {'key': 'c6', 'color': '#AAAAFF'},
            ]
        }
    },
   
    methods: {      
        selColor: function(color) {
            let textareaObj = chatHelper.textareaObj();

            let sel = chatHelper.getSelection();
            if (sel.length > 0) {
            let newValue = textareaObj.value.replace(sel, '[' + color.key + ']' + sel +'[/' + color.key + ']');
                textareaObj.value = newValue;
            } else {
                chatHelper.insertText('[' + color.key + '][/' + color.key + ']')
            }
            
            this.$emit("turnOffStatus");
        }  
    }
}
</script>

<style lang="scss">
.component_color{
    position: absolute;
    bottom: 85px;
    border: solid 1px gray;
    padding: 4px 0;
    right: 6px;
    width: 200px;
    max-height: 197px;
    height: 30px;
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
            background: gray;
            &:hover {
                background: #1b1a1a;
            }
        }
    }
}
 
</style>

