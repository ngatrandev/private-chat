<template>
    <div class="dropdown relative">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click.prevent="isOpen = !isOpen"
        >
            <button  
                    class="items-center text-default no-underline text-sm focus:outline-none hover:text-red" 
                    v-pre>
                   <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z"/></svg>
            </button>
        </div>

        <div v-show="isOpen"
             class="dropdown-menu absolute z-10 rounded shadow mt-3 bg-white border border-grey-dark"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             :style="{ width }"
        >
            
            <input 
            @input="checkButton"
            v-model="form.name" 
            class="appearance-none bg-transparent border-b  border-grey w-full text-grey-darker mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Your group name"
            >
        
            <div 
            v-for="friend in friends"
            class="ml-2 py-1" 
            :class="checkedcss(friend.id)? 'text-black' : 'text-grey'"
            >
                <input
                @click="checkedcss(friend.id)" 
                type="checkbox" 
                :value="friend.id" 
                v-model="form.users">
                <label>{{friend.name}}</label>
            </div>
            <div class="flex justify-center py-1 border-t border-grey-light">
                <button v-show="showButton"
                @click="send"
                class="bg-blue hover:bg-blue-dark text-white text-xs font-bold py-1 px-2 rounded-full">
                Create
                </button>
                <button v-show="!showButton"
                class="bg-blue text-white text-xs font-bold py-1 px-2 rounded-full opacity-50 cursor-not-allowed">
                Create
                </button>
            </div>
            
           
            
        </div>
    </div>
</template>

<script>
    export default {
        props: ['friends', 'align', 'width'],
        data() {
            return { isOpen: false,
                    form: {
                        name: '',
                        users: []
                    },
                    showButton: false,
            }
        },
        watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if (! event.target.closest('.dropdown')) {
                    this.isOpen = false;
                    this.form.name='';
                    this.form.users=[];
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            },

             async send(e) {
               
             await axios.post('/creategroup', this.form);
              //this.form.email = request('email') bên controller nếu chỉ viết this.email dễ gây error
                this.isOpen = false;
                    this.form.name='';
                    this.form.users=[];
              
           },

           checkedcss(id) {
               this.checkButton();
               return this.form.users.includes(id);
               //để thay đổi css khi checked
               //class ngoài bind được với data, còn có thể bind được cả function (return về boolean)
           },

           checkButton () {
               if(this.form.name.trim().length > 0 && this.form.users.length > 0) {
                   this.showButton = true;
               } else {
                   this.showButton = false;
               }
           }



        
        }
    }
    // lưu ý cách dùng event.target.closest('.dropdown')
    // dùng value kết hợp v-model để tương tác với các data trong check box khi check và uncheck
    // showButton để validate trước khi submit lên server
    // hiện dùng 2 button cùng vị trí 1 button disable và 1 button có submit.
</script>