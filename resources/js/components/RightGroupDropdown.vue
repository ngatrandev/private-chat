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
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
            </button>
        </div>

        <div v-show="isOpen"
             class="dropdown-menu bg-white absolute py-2 rounded shadow mt-2"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             :style="{ width }"
        >
            <div @click.prevent="clear" class="hover:bg-grey-light cursor-pointer border-b border-t border-grey block text-default no-underline text-sm leading-loose px-4 w-full text-left">Clear chat</div>
            <div v-show="isAdmin" @click.prevent="$modal.show('delete-dialog')" class="hover:bg-grey-light cursor-pointer border-b  border-grey block text-default no-underline text-sm leading-loose px-4 w-full text-left">Delete group</div>
            <div v-show="!isAdmin" @click.prevent="$modal.show('leave-dialog')" class="hover:bg-grey-light cursor-pointer border-b border-grey block text-default no-underline text-sm leading-loose px-4 w-full text-left">Leave group</div>
        </div>
        <delete-dialog
        :name="this.name"
        @del="del"
        ></delete-dialog>
        <leave-dialog
        :name="this.name"
        @leave="leave"
        ></leave-dialog>
    </div>
</template>

<script>
    export default {
        props: ['isAdmin', 'align', 'width', 'name' ],
        data() {
            return { isOpen: false,
                    blocked: false }
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

            clear() {
                this.isOpen = false;
                this.$emit('clear');
               
            },

            del() {
                this.isOpen = false;
                this.$emit('del');
            },

            leave() {
                this.isOpen = false;
                this.$emit('leave');
            },

         
        }
    }
    // lưu ý cách dùng event.target.closest('.dropdown')
</script>