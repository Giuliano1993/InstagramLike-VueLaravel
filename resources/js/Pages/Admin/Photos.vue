<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import InteractivePhotoGallery from '@/Components/InteractivePhotoGallery.vue'
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array
})
</script>

<template>
    <AppLayout title="Photos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Photos
            </h2>
            
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <InteractivePhotoGallery :photos="photos"></InteractivePhotoGallery>
                </div>
            </div>
        </div>
        
    </AppLayout>
    
</template>