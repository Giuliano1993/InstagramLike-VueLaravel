<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import UserSearch from '@/Components/UserSearch.vue'
import { ref } from 'vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
const showSearch = ref(false);
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex flex-col items-top justify-center min-h-screen bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed bottom-0 right-0 px-6 py-4 sm:block z-50">
            <template v-if="$page.props.user">
                <div class="mx-auto rounded flex justify-around px-3 py-5 menubox">
                    <a href="#" @click.prevent="()=> showSearch = !showSearch" class="mr-4 text-sm text-black bg-zinc-200 shadow-md rounded-full p-3">
                        <img src="/pictures/search.png"/>
                    </a>
                    <Link  :href="route('admin.photos')" class="flex-start mr-4 text-sm text-black bg-zinc-200 shadow-md rounded-full p-3">
                        <img src="/pictures/profile.png"/>
                    </Link>
                    <Link  :href="route('guest.photos')" class="text-sm text-black bg-zinc-200 shadow-md rounded-full p-3">
                        <img src="/pictures/home.png"/>
                    </Link>
                </div>
            </template>
            <template v-else>
                <Link :href="route('login')" class="text-sm text-black ">Log in</Link>
                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-black ">Register</Link>
            </template>
        </div>
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 z-10">
            <div class="mt-8 bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <slot title="content"></slot>
            </div>
        </div>
    </div>
    <div id="showSearchBox" v-show="showSearch" class="fixed inset-x-0 left-1/4 right-1/4 top-1/2 w-50">
        <UserSearch></UserSearch>
    </div>
</template>

<style scoped>
.menubox a img{
    width:30px
}
.menubox a{
    z-index: 99999999;
}
#showSearchBox{
    z-index: 99999999;
}
</style>
