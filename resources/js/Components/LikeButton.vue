<script>

import { defineComponent } from 'vue';
import  axios  from "axios";

export default defineComponent({

    
    data(){
        return{
            like : this.$attrs.liked,
            activeAnimation : false,
            likesCount: this.$attrs.likesCount
            
        }
    },
    methods: {
        likeClicked(){     
            let userId = this.$attrs.user.id;
            let photoId = this.$attrs.photo;
            this.like = !this.like
            this.activeAnimation = true;
            setTimeout(()=>{
                this.activeAnimation = false
            },400)
            axios.post(`/${userId}/like/${photoId}`);
        }
    }
})
</script>


<template>

    <div class="flex">
        <img v-if="$page.props.user" :src="!like ? '/pictures/not-like.png' : '/pictures/like.png'" @click="()=>likeClicked()" :class="{active:activeAnimation}" />
        <b class="inline-block ml-3" v-if="likesCount > 0">{{likesCount}} liked this</b>
        
    </div>
</template>

<style scoped>
    img{
        width: 30px;
        cursor:pointer;
        animation: scale-down-center 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
    }
    img.active{
        
        animation: scale-up-center 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
    }
    @keyframes scale-up-center {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.3);
        }
    }
    @keyframes scale-down-center {
        0% {
            transform: scale(1.3);
        }
        100% {
            transform: scale(1);
        }
    }
</style>