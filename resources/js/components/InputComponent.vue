<template>
    <div class="w-full bg-grey-light font-serif py-2">
        <form class="flex justify-end px-4 " @submit.prevent="send">
            <input 
            v-model="text"
            class="text-base shadow appearance-none border rounded w-3/4 py-1 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Enter your message">
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            text:''
        }
    },

    methods: {
        send() {
            this.$emit('input', this.text);
            this.text = '';
        }
    }
}
//dùng submit.prevent để không refresh lại page
</script>