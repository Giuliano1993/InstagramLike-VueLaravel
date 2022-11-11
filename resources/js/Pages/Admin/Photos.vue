<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import {ref} from 'vue';
import axios from 'axios';
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array
});
const photoLoop = ref(props.photos)

async function deletePhoto(id){
    var res = await axios.delete(`/admin/photos/${id}/delete`)
    if(res.data == 'ok'){
    var ind = photoLoop.value.findIndex( photo => photo.id === id)
    photoLoop.value.splice(ind,1);
    
    }
}
</script>
<template>
    <AppLayout title="Photos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Photos
            </h2>
            
            <Link :href="route('admin.photos.create')" class="hover:bg-blue-700 bg-gradient-to-r from-sky-600 to-blue-900 text-white font-bold py-2 px-4 rounded-full">New Photo</Link>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table-auto border border-slate-500">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Preview</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="photo in photoLoop" :key="photo.id">
                                <td>{{photo.id}}</td>
                                <td>{{photo.description.length > 100 ? photo.description.slice(0,100)+'...' : photo.description}}</td>
                                <td>
                                    <img :src="photo.path" />
                                </td>
                                <td>
                                    <div class="flex justify-around">
                                        <Link :href="route('admin.photos.edit',{id: photo.id})">Modifica</Link>
                                        <a href="#" @click.prevent="()=>{deletePhoto(photo.id)}" > Delete </a>
                                    </div>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
</style>