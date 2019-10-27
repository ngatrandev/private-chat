<template>
        <div v-show="isOpen"  class="w-3/4 border border-grey-light relative">
            <div class="flex bg-grey-light font-serif justify-between w-full py-2">
                <h4>{{group.name}} <span v-for="user in group.members">{{user.name}}</span></h4>
                <dropdown @clear="clearChat"  align=right width="200px"></dropdown>
            </div>
            <ul v-chat-scroll class="list-reset overflow-y-scroll" style="height:500px">
                <li class="py-2 px-2  " v-for="chat in chats"
                :class="{'text-right':chat.type == 0,
                'text-red': chat.readAt == null}">
                <span
                v-show="chat.type == 1"
                v-text="chat.from"
                class="text-xs text-black py-1"
                ></span>
                <br>
                <span
                v-show="chat.content"
                v-text="chat.content"
                class="px-2 py-1 rounded shadow-lg text-sm"
                :class="{
                'bg-blue-lighter':chat.type == 0,
                'bg-pink-lighter':chat.type == 1
                }"
                ></span>
                <img class="h-24 rounded shadow-lg" v-show="chat.image" :src="chat.image"  alt="">
                <br>
                 <span
                v-text="chat.send_at"
                class=" py-1 text-2xs text-grey"
                ></span>
                </li>
            </ul>
            <div v-show="this.activePeer" class="text-blue text-xs font-bold absolute pin-b pin-l">
                 is typing...
            </div>
        </div>
        
</template>
<script>
import DropDown from './DropDown'
export default {
    props: ['group', 'isOpen', 'id'],
    components: {DropDown},
    data() {
        return {
            chats: [],
            val: '',
            
            activePeer: false
        }
    },

    methods: {
       

        async getMessages() {
            this.chats = (await axios.post(`/group/${this.group.id}/chats`)).data.data;
           },

        clearChat() {
            // this.chats = [];
            // axios.post(`/session/${this.friend.sessionId}/clear`);
        }

           
    },

    created() {
        Echo.private('group.'+this.group.id)
           .listen('GroupMsgEvent', (e)=>{
               if(this.id == e.userId) {
                        this.chats.push({
                        id: e.chatId,
                        content: e.message.content,
                        image: e.message.image,
                        type: 0,
                        readAt: null,
                        send_at:e.chatTime 
                    });
               } else {
                   this.chats.push({
                        content: e.message.content,
                        image: e.message.image,
                        type: 1,
                        readAt: '',
                        send_at:e.chatTime,
                        from: e.from 
                    });
               }
              
           })

          

        
    },

    watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    this.getMessages();
                } else {
                    this.chats = [];
                }
            }
            //dùng watch để theo dõi khi giá trị isOpen nếu có thay đổi sẽ chạy vào func bên trong
            //cách này đơn giản hơn emit event từ parent đến child component
            //bằng cách theo dõi prop từ parent để chạy func bên child component

            //Ban đầu đăng nhập toàn bộ dữ liệu về mess đều rỗng
            //khi click vào 1 bạn trong friend list do isOpen thay đổi
            //chỉ pull 1 bộ data về mess với bạn đó show trên màn hình
            //thay vì phải pull tất cả mess của toàn bộ friendlist
           
        },
    
}
// dùng height và overflow-scroll để xuất hiện scroll bar
// dùng v-chat-scroll để chế độ scroll phù hợp với kiểu chat
// chỉ tô nền cho text thì để text trong thẻ <span></span>
</script>