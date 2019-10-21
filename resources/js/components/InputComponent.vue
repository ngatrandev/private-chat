<template>
    <div class="w-full flex bg-grey-light font-serif py-2">
        <div class="w-1/4"></div>
        <file-upload
            :post-action="'send/'+sessionId"
            v-model="image"
            @input-filter="inputFilter"
            :headers="{'X-CSRF-TOKEN': token}"
            ref='upload'
            @input-file="$refs.upload.active = true"
        >
        <svg class="w-8 fill-current text-blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 3H7a7 7 0 1 0 0 14h8v-2H7A5 5 0 0 1 7 5h8a3 3 0 0 1 0 6H7a1 1 0 0 1 0-2h8V7H7a3 3 0 1 0 0 6h8a5 5 0 0 0 0-10z"/></svg>
        </file-upload>
        <form class="flex justify-end px-4 w-3/4" @submit.prevent="send" @keydown="type">
            <input 
            v-model="text"
            class="text-base shadow appearance-none border rounded w-full py-1 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Enter your message">
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            text:'',
            image: [],
            token:document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
    props: ['sessionId'],
    
    methods: {
        send() {
            this.$emit('input', this.text);
            this.text = '';
        },
        type() {
            this.$emit('typing');
        },
       inputFilter(newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                //check nếu không phải file ảnh sẽ không post
                //syntax trong func này là mặc định theo bên thứ 3
            if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
            alert('Select image file, please!')
            return prevent()
            }
        }
       }

       
        
       

   
    }
}
//dùng submit.prevent để không refresh lại page
// :post-action="'send/'+sessionId" do có bind sessionId bên dưới nên phải
// viết :post-action, tương tự :headers cũng vậy
//do VueUploadComponent là bên thứ 3, nên các props, methods... đặc trưng riêng của nó

</script>