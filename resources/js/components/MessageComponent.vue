<template>
        <div class="w-3/4 border border-grey-light ">
            <div class="flex bg-grey-light font-serif justify-between w-full py-2">
                <h4>Chats</h4>
                <dropdown @blocked="blocked1" @unblocked="unblocked1" align=right width="200px"></dropdown>
            </div>
            <ul v-chat-scroll class="list-reset overflow-y-scroll" style="height:500px">
                <li class="py-2" v-for="chat in chats">{{chat.message}}</li>
            </ul>
        </div>
        
</template>
<script>
import DropDown from './DropDown'
export default {
    props: ['chats'],
    components: {DropDown},

    methods: {
        blocked1() {
            this.$emit('block_toggle');
        },

        unblocked1() {
            this.$emit('unblock_toggle');
        }
    }
    
}
// dùng height và overflow-scroll để xuất hiện scroll bar
// dùng v-chat-scroll để chế độ scroll phù hợp với kiểu chat
</script>