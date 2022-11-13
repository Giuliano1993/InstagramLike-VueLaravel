<script setup>
import InteractivePhotoGallery from '@/Components/InteractivePhotoGallery.vue';
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Object,
    likes: Array
});
console.log(props.photos)
var mappedLikes = {}
props.likes.forEach(like => {
    if(like.likes) mappedLikes[like.photo_id] = like.likes
});
</script>

<template>
    <FrontendLayout :canLogin="canLogin" :canRegister="canRegister">
        <InteractivePhotoGallery :photos="photos" :likes="mappedLikes"></InteractivePhotoGallery>
    </FrontendLayout>
</template>
