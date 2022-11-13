<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import {ref} from 'vue';
import axios from 'axios';
import DialogModal from '@/Components/DialogModal.vue';
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array,
    isLoggedInUser: Boolean,
    
});
const photoLoop = ref(props.photos)
const showModal = ref(false)
const selectedPhoto = ref(null)


async function deletePhoto(id){
    var res = await axios.delete(`/admin/photos/${id}/delete`)
    if(res.data == 'ok'){
        var ind = photoLoop.value.findIndex( photo => photo.id === id)
        photoLoop.value.splice(ind,1);
        showModal.value = false
    }
}

function selectPhoto(p){
    showModal.value = true;
    selectedPhoto.value = p;
}
function switchModalVisibilit(){
    showModal.value = !showModal.value
}
</script>
<template>
    <AppLayout title="Photos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                Profile
            </h2>
            
            <Link v-if="isLoggedInUser" :href="route('admin.photos.create')" class="hover:bg-blue-700 bg-gradient-to-r from-sky-600 to-blue-900 text-white font-bold py-2 px-4 rounded-full">+</Link>
        </template>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-3">
                        <div v-for="photo in photoLoop" :key="photo.id" class="galleryPhotoDiv p-1 w-30 h-30 overflow-hidden">
                            <img class="mx-auto" :src="photo.path" @click="()=>selectPhoto(photo)" />
                        </div>

                    </div>

                    <DialogModal :show="showModal" @close="switchModalVisibilit">
                        <template #title>
                            
                        </template>
                        <template #content>
                            <img :src="selectedPhoto.path" class="border-solid border-8 drop-shadow-lg mx-auto"/>
                            
                            <p class="mt-5">{{selectedPhoto.description}}</p>
                            
                        </template>
                        <template #footer>
                            <div  v-if="isLoggedInUser" class="flex justify-end my-3">
                                <Link class="px-2" :href="route('admin.photos.edit',{id: selectedPhoto.id})">
                                    <img class="actionBtn" src="/pictures/pencil.png"/>
                                </Link>
                                <a class="px-2" href="#" @click.prevent="()=>{deletePhoto(selectedPhoto.id)}" >
                                    <img class="actionBtn" src="/pictures/bin.png"/>
                                </a>
                            </div>
                        </template>
                    </DialogModal>    
                </div>
            </div>
        </div>
        
    </AppLayout>
    
</template>

<style scoped>
    table{
        width: 100%;
    }
    table td:nth-child(3),
    table th:nth-child(3){
        max-width: 150px;
    }
    table td:nth-child(4),
    table th:nth-child(4){
        min-width: 200px;
    }

    .galleryPhotoDiv{
        width: 30vW;
        height: 30vW;
        text-align: center;
        justify-content:space-around;
        
    }
    .galleryPhotoDiv img{
        cursor:pointer;
        width:100%;
    }
    .actionBtn{
        width: 25px
    }
</style>