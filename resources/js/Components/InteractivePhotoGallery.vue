<script>
import { defineComponent } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';



export default defineComponent({
    components:{
        DialogModal
    },
    data() {
        return{
            currentPhoto: null,
            showModal: false
        }
    },
    props:{
        photos: Array
    },
    methods:{
        openPicModal(photo){
            this.currentPhoto = photo;
            this.showModal= true
        }
    }
})
</script>

<template>
    <section class="photos grid grid-cols-1 md:grid-cols-2">
        <div v-for="p in photos" :key="p.id" class="card mx-3 p-6" @click="()=>openPicModal(p)">
            <img :src="p.path"/>
        </div>
    </section>    
    <DialogModal :show="showModal" @close="showModal = false">
        <template #title>
            Immagine cliccata
        </template>
        <template #content>
            {{currentPhoto.description}}
            <img :src="currentPhoto.path" class="border-solid border-8 drop-shadow-lg"/>
        </template>
    </DialogModal>    
</template>

<style>
    img{
        cursor:pointer;
        animation: scale-down-center 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
    }
    img:hover{
        
        animation: scale-up-center 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
    }
    @keyframes scale-up-center {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.2);
        }
    }
    @keyframes scale-down-center {
        0% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
