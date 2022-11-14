<script>
import {defineComponent} from 'vue';
import axios from 'axios'
import {  Link } from '@inertiajs/inertia-vue3';
export default defineComponent({
    data(){
        return{
            search: '',
            results: []
        }
    },
    components: {
        Link
    },
    methods: {
        async searchUser(){
            console.log(this.search)
            var res = await axios.get(route('search.user'),{params:{search: this.search}})
            this.results = res.data
            console.log(this.results)
        }
    }
})
</script>

<template>
    <div class="relative">
        <div class="flex items-center absolute inset-y-0 left-0 z-50 w-full">
            <div class="pl-3 absolute pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input v-model="search" @change="searchUser" type="search" id="default-search" class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Users" required>
            <button type="submit" class="text-white absolute right-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
        </div>
        <div id="searchResults" class="flex absolute top-40 left-0 items-center w-full rounded-sm">
            <ul class="w-full rounded-sm" >
                <li v-for="res in results" class="flex items-center border-b-2 bg-gray-200 border-gray-300 w-full flex py-1 w-full rounded-sm cursor-pointer transition hover:bg-gray-100 duration-200">
                    <Link :href="route('guest.profile',{user:res.id})" class="flex items-center w-full ">
                        
                        <div class="imgContainer overflow-hidden rounded-full ml-3 mr-2">
                            <img  :src="res.profile_photo_path ? '/storage/'+res.profile_photo_path : res.profile_photo_url"/>
                        </div>
                        <b>{{res.name}}</b>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>
<style scoped>

    #searchResults.top-40{
        top: 2rem!important;
    }
    #searchResults .imgContainer{
        width:40px;
        height:40px;
    }
    #searchResults img{
        width: 40px;
        
    }
    #searchResults ul{
        /*margin-top: 10rem;*/
    }
</style>