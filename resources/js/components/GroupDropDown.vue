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
             class="dropdown-menu absolute z-10 rounded shadow mt-3 bg-white"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             :style="{ width }"
        >
            
            <input v-model="form.name" 
            class="appearance-none bg-transparent border-b  border-grey w-full text-grey-darker mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Your group name"
            >
            
            <div 
            v-for="friend in friends" 
            v-text="friend.name" 
            @click.prevent="addUser(friend.id)"
            :class="form.users.includes(friend.id) ? 'bg-green' : ''"  
            class="hover:bg-grey-light cursor-pointer border-b  border-grey block text-default no-underline text-sm leading-loose px-4 w-full text-left"
            ></div>
            <div class="flex justify-center">
                <svg @click="send" class=" cursor-pointer mt-1 mb-1 h-5 w-5 fill-current text-blue hover:text-green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 0l20 10L0 20V0zm0 8v4l10-2L0 8z"/></svg>
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
                    }
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

            
            addUser(id) {
                this.form.users.push(id);
            },

             async send(e) {
               
             await axios.post('/creategroup', this.form);
              //this.form.email = request('email') bên controller nếu chỉ viết this.email dễ gây error
                this.isOpen = false;
                    this.form.name='';
                    this.form.users=[];
              
           },

        
        }
    }
    // lưu ý cách dùng event.target.closest('.dropdown')
</script>