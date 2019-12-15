<template>
    <div class="dropdown relative">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click.prevent="read"
        >
            <button  
                    class="flex items-center no-underline text-sm focus:outline-none border hover:border-blue"
                    >
                   <svg 
                   class="h-5 w-5 fill-current"
                   :class="count>0? 'text-red': 'text-default'" 
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 8a6 6 0 0 1 4.03-5.67 2 2 0 1 1 3.95 0A6 6 0 0 1 16 8v6l3 2v1H1v-1l3-2V8zm8 10a2 2 0 1 1-4 0h4z"/></svg>
                    <span v-show="count > 0" class="text-red text-sm">{{count}}</span>
           </button>
            
        </div>

        
            <ul 
            v-show="isOpen"
             class="dropdown-menu absolute z-10 rounded shadow mt-3 list-reset overflow-y-scroll bg-white border border-grey-light"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             style="height:150px; width:250px"
            >
                <li class="py-2 px-2 text-xs border-b border-grey-light"
                :class="notification.read? 'text-black':'text-red'" 
                v-for="notification in notifications"
                >{{notification.content}}
                    <span :class="notification.read? 'text-grey-dark':'text-red-light'">({{notification.time}})</span>
                </li>
            </ul>
           
            
        
    </div>
</template>

<script>
    export default {
        props: ['align', 'id']
        ,
        data() {
            return { isOpen: false,
                    notifications: '',
                    count: 0
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
                    this.count = 0;
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            },

            async read() {
               this.notifications = (await axios.post(`user/${this.id}/notifications`)).data.data;
               this.isOpen = true; 
               await axios.post(`user/${this.id}/update`);

            },

            async getNotification() {
             this.count = (await axios.post(`user/${this.id}/count`)).data;
         }

        
        },

        created () {
            this.getNotification();
            Echo.private('notification')
           .listen('NotificationEvent', (e)=>{
               
               if (this.id == e.id) {
                   this.count++;
               }
           }) 
        }
    }
    // lưu ý cách dùng event.target.closest('.dropdown')
</script>