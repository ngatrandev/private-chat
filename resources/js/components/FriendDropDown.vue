<template>
    <div class="dropdown relative">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click.prevent="isOpen = !isOpen"
        >
            <button  
                    class="flex items-center text-default no-underline text-sm focus:outline-none" 
                    v-pre>
                   <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2 6H0v2h2v2h2V8h2V6H4V4H2v2zm7 0a3 3 0 0 1 6 0v2a3 3 0 0 1-6 0V6zm11 9.14A15.93 15.93 0 0 0 12 13c-2.91 0-5.65.78-8 2.14V18h16v-2.86z"/></svg>
            </button>
        </div>

        <div v-show="isOpen"
             class="dropdown-menu absolute z-10 rounded shadow mt-3"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             :style="{ width }"
        >
            <div class="w-full font-serif border border-grey bg-white py-1 px-1">
                <form  @submit.prevent="send">
                    <input 
                    v-model="email"
                    class="shadow text-sm appearance-none border rounded w-full py-1 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Add your friend email">
                </form>
            </div>
             <div  class="hover:bg-grey-light bg-white border-b border-l border-r border-grey block text-default no-underline text-sm leading-loose px-4 w-full text-left">Clear chat</div>
             <div  class="hover:bg-grey-light bg-white border-b border-l border-r border-grey block text-default no-underline text-sm leading-loose px-4 w-full text-left">Clear chat</div>
             <div  class="hover:bg-grey-light bg-white border-b border-l border-r border-grey block text-default no-underline text-sm leading-loose px-4 w-full text-left">Clear chat</div>
            
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            width: { default: 'auto' },
            align: { default: 'left' }
        },
        data() {
            return { isOpen: false,
                    email: ''
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
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            },

            send() {
                this.isOpen = false;
                this.$emit('send1', this.email);
            }

        
        }
    }
    // lưu ý cách dùng event.target.closest('.dropdown')
</script>