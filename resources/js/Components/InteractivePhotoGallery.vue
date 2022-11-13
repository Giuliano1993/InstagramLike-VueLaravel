<script>
import { defineComponent, ref } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import LikeButton from '@/Components/LikeButton.vue';
import { Link } from '@inertiajs/inertia-vue3';


export default defineComponent({
    components:{
        DialogModal,
        LikeButton,
        Link
    },
    data() {
        
        return{
            currentPhoto: null,
            showModal: false,
            allPhotos : this.photos.data,
            initialUrl: this.$page.url
        }
    },
    props:{
        likes: Object,
        photos: Object
    },
    methods:{
        openPicModal(photo){
            this.currentPhoto = photo;
            this.showModal= true
        },
        loadMorePhotos(){
            if(this.photos.next_page_url === null) return;
            this.$inertia.get(this.photos.next_page_url,{},{
                preserveScroll: true,
                preserveState: true,
                only: ['photos'],
                onSuccess: ()=>{
                    console.log('called')
                    this.allPhotos = [...this.allPhotos,...this.photos.data]
                    window.history.replaceState({}, this.$page.title, this.initialUrl) 

                }
            })
        }
    },
    mounted(){

        const observer = new IntersectionObserver( entries => entries.forEach(entry => entry.isIntersecting && this.loadMorePhotos(), {
            rootMargin: "0px 0px 0px 0px",
            threshold: 0.01
        }))

        observer.observe(this.$refs.loadMoreIntersect)
    }
})

</script>

<template>
    <section class="photos grid grid-cols-1">
        <div v-for="p in allPhotos" :key="p.id" class="card mx-3 p-6 rounded-md bg-white my-3 drop-shadow-md" >
            <Link :href="route('guest.profile',{user : p.user_id})" v-if="p.user_name" class="flex mb-2 text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                <img class="h-11 w-11 rounded-full object-cover" :src="'/storage/'+p.profile_photo_path"> 
                <b class="text-black text-lg ml-4 self-center">{{p.user_name}}</b>
            </Link>
            <img class="mx-auto" :src="p.path" @click="()=>openPicModal(p)"/>
            <LikeButton class="mt-3" :user="$page.props.user" :photo="p.id" :liked="likes.hasOwnProperty(p.id)"></LikeButton>
        </div>
        <span class="mb-4" ref="loadMoreIntersect"></span> 
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
