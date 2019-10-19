<template>
        <div v-show="isOpen"  class="w-3/4 border border-grey-light ">
            <div class="flex bg-grey-light font-serif justify-between w-full py-2">
                <h4>{{friend.name}}</h4>
                <dropdown @blocked="blocked1" @unblocked="unblocked1" align=right width="200px"></dropdown>
            </div>
            <ul v-chat-scroll class="list-reset overflow-y-scroll" style="height:500px">
                <li class="py-2 px-2  " v-for="chat in chats"
                :class="{'text-right':chat.type == 0,
                'text-red': chat.readAt == null}">
                <span
                v-text="chat.message"
                class="px-2 py-1 rounded shadow-lg text-sm"
                :class="{
                'bg-blue-lighter':chat.type == 0,
                'bg-pink-lighter':chat.type == 1
                }"
                ></span>
                <br>
                 <span
                v-text="chat.send_at"
                class=" py-1 text-2xs text-grey"
                ></span>
                </li>
            </ul>
        </div>
        
</template>
<script>
import DropDown from './DropDown'
export default {
    props: ['friend', 'isOpen', 'id'],
    components: {DropDown},
    data() {
        return {
            chats: [],
            val: ''
        }
    },

    methods: {
        blocked1() {
            this.$emit('block_toggle');
        },

        unblocked1() {
            this.$emit('unblock_toggle');
        },

        async getMessages() {
               this.chats = (await axios.post(`/session/${this.friend.sessionId}/chats`)).data.data;
           },

           
    },

    created() {
        Echo.private('message.'+this.friend.sessionId)
           .listen('MessageEvent', (e)=>{
               if(this.id == e.userId) {
                        this.chats.push({
                        id: e.chatId,
                        message: e.message,
                        type: 0,
                        readAt: null,
                        send_at: 'just now'
                    });
               } else {
                   this.chats.push({
                        message: e.message,
                        type: 1,
                        readAt: '',
                        send_at: 'just now'
                    });
                   //if else để xác định mess được push vào là send hay recieve
                   //just now chỉ mang nghĩa tương đối vì được push qua Event-không pull trực tiếp từ database
               }
              
              //khi send hoặc recieve mess mới không pull lại data từ data base
              // mà qua listen event để thêm mess mới vào data của Vue
              // làm cho mess được show nhanh hơn
           });

         Echo.private('message.'+this.friend.sessionId)
           .listen('MsgReadEvent', (e)=>{
               this.chats.forEach(chat=>{
                   chat.id == e.chat.id? chat.readAt = e.chat.readAt : '';
               })
           });//mes được gửi có text-red nếu tin nhắn được xem sẽ đối sang text-default nhờ listen event này
        //hai event khác nhau là MessageEvent, MsgReadEvent nhưng có thể cùng tên private channel message.sessionId
        

          

        
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