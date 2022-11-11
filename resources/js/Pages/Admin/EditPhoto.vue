<script >
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'



export default{
    props:{
        photo:Object
    },
    setup(props){
        const form = useForm({
            _method:"PUT",
            path: null,
            description: props.photo.description
        })
        function submit(){
            form.post(`/admin/photos/${props.photo.id}/update`);
        }

        return {form, submit}
    },
    components: {
        AppLayout
    }
    
    
}

</script>
<template>
    <AppLayout title="New Photo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit photo
            </h2>
        </template>

        <div>
    <div class="md:grid md:grid-cols-3 md:gap-6">
      
      <div class="mt-5 md:col-span-3 md:mt-0">
        <form @submit.prevent="submit">
          <div class="shadow sm:overflow-hidden sm:rounded-md">
            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
              

              <div>
                <label for="about" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                  <textarea id="description" name="description" rows="3" v-model="form.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Your caption here" />
                </div>
              </div>

             
            <div class="grid grid-cols-2">
            <div>
                <img :src="photo.path"/>
            </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Image</label>
                <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                  <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                      <label for="path" class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>File</span>
                        <input id="path" name="path" type="file" class="sr-only" @input="form.path = $event.target.files[0]"/>
                      </label>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                  </div>
                </div>
              </div>
            </div>
        </div>
            <div class="text-red-500" v-if="form.errors.description">
                {{form.errors.description}}
            </div>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
              <button type="submit" :disabled="form.processing" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

    </AppLayout>
</template>