<script>
import { defineComponent } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import LikeButton from '@/Components/LikeButton.vue';



export default defineComponent({
    components:{
        DialogModal,
        LikeButton
    },
    data() {
        return{
            currentPhoto: null,
            showModal: false
        }
    },
    props:{
        photos: Array,
        likes: Object
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
    <section class="photos grid grid-cols-1">
        <div v-for="p in photos" :key="p.id" class="card mx-3 p-6 rounded-md bg-white my-3 drop-shadow-md" >
            <span v-if="p.user" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                <img class="h-11 w-11 rounded-full object-cover" :src="p.user.profile_photo_url"> 
                <b class="text-black text-lg ml-4 self-center">{{p.user.name}}</b>
            </span>
            <img :src="p.path" @click="()=>openPicModal(p)"/>
            <LikeButton class="mt-3" :user="$page.props.user" :photo="p.id" :liked="likes.hasOwnProperty(p.id)"></LikeButton>
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

<style scoped>
    .photos img{
        cursor:pointer;
    }
</style>
