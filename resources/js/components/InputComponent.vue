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
            class=" text-blue hover:text-red"
        >
        <svg class=" px-1 h-4 mt-2 fill-current " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 3H7a7 7 0 1 0 0 14h8v-2H7A5 5 0 0 1 7 5h8a3 3 0 0 1 0 6H7a1 1 0 0 1 0-2h8V7H7a3 3 0 1 0 0 6h8a5 5 0 0 0 0-10z"/></svg>
        </file-upload>
        <div @click.prevent="emotion" class="emotion cursor-pointer text-green hover:text-red">
            <svg class=" px-1 mt-2  h-4 fill-current " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM6.5 9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm7 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM7 13h6a1 1 0 0 1 0 2H7a1 1 0 0 1 0-2z"/></svg>
        </div>
        <form class="flex justify-end px-4 w-3/4" @submit.prevent="send" @keydown="type">
            <input 
            v-model="text"
            class=" emotion text-base shadow appearance-none border rounded w-full py-1 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Enter your message">
        </form>
        <picker class="emotion" v-if="emoStatus" set="emojione"  @select="addEmotion" emoji="point_up"  title="Pick your emoji..." :style="{ position: 'absolute', bottom: '15px', left: '15px' }" :i18n="{ search: 'Recherche', categories: { search: 'Résultats de recherche', recent: 'Récents' } }" />
    </div>
</template>

<script>

import { Picker} from 'emoji-mart-vue'
//không dùng được emoiji-mart-vue-fast (nhanh hơn) - nghiên cứu thêm

export default {
    
    data() {
       
        return {
            text:'',
            image: [],
            token:document.head.querySelector('meta[name="csrf-token"]').content,
            emoStatus: false,
            
        }
    },
    props: ['sessionId'],
    components: {Picker},
    watch: {
            emoStatus(emoStatus) {
                if (emoStatus) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
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

        
       },

       emotion() {
            this.emoStatus = !this.emoStatus;
        },

        addEmotion(e) {
            if(!e) {
                return false;
            } this.text = this.text + e.native;

            //e.native để add emoji icon vào theo syntax bên thứ 3
        },
        closeIfClickedOutside(event) {
                if (! event.target.closest('.emotion')) {
                    this.emoStatus = false;
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
                //method này cùng với phần watch bên trên để xác định những vị trí nào
                //khi click vào emoStatus sẽ chuyển sang false (đóng cửa sổ emotion)
                //class emotion không có nghĩa css
                //những thẻ nào có class emotion khi click vào cửa sổ emotion sẽ không đóng
                //các vị trí còn lại khi click vào cửa sổ emotion sẽ đóng
                //lưu ý cách viết event.target.closest('.emotion')
            },

       
        
       

   
    }
}
//dùng submit.prevent để không refresh lại page
// :post-action="'send/'+sessionId" do có bind sessionId bên dưới nên phải
// viết :post-action, tương tự :headers cũng vậy
//do VueUploadComponent là bên thứ 3, nên các props, methods... đặc trưng riêng của nó

</script>