<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import InteractivePhotoGallery from '@/Components/InteractivePhotoGallery.vue';
import FrontendLayout from '@/Layouts/FrontendLayout.vue'
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array
});
</script>

<template>
    <FrontendLayout :canLogin="canLogin" :canRegister="canRegister">
        <InteractivePhotoGallery :photos="photos"></InteractivePhotoGallery>
    </FrontendLayout>
</template>
