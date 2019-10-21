<template>
        <div v-show="isOpen"  class="w-3/4 border border-grey-light relative">
            <div class="flex bg-grey-light font-serif justify-between w-full py-2">
                <h4>{{friend.name}}</h4>
                <dropdown @clear="clearChat" @blocked="blocked1" @unblocked="unblocked1" align=right width="200px"></dropdown>
            </div>
            <ul v-chat-scroll class="list-reset overflow-y-scroll" style="height:500px">
                <li class="py-2 px-2  " v-for="chat in chats"
                :class="{'text-right':chat.type == 0,
                'text-red': chat.readAt == null}">
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
                {{friend.name}} is typing...
            </div>
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
            val: '',
            block: false,
            activePeer: false
        }
    },

    methods: {
        blocked1() {
            this.block = true;
        },

        unblocked1() {
           this.block = false;
        },

        async getMessages() {
               this.chats = (await axios.post(`/session/${this.friend.sessionId}/chats`)).data.data;
           },

        clearChat() {
            this.chats = [];
            axios.post(`/session/${this.friend.sessionId}/clear`);
        }

           
    },

    created() {
        Echo.private('message.'+this.friend.sessionId)
           .listen('MessageEvent', (e)=>{
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
                        send_at:e.chatTime 
                    });
                   //if else để xác định mess được push vào là send hay recieve
                   //e.chatTime đảm bảo thời gian dù không pull trực tiếp từ database
                   //nhưng vẫn chính xác vì giá trị này listen qua event
               }
              
              //khi send hoặc recieve mess mới không pull lại data từ data base
              // mà qua listen event để thêm mess mới vào data của Vue
              // làm cho mess được show nhanh hơn
           })
           .listenForWhisper('typing', e=> {
               this.activePeer = true;
               setTimeout(()=> {
                   this.activePeer=false
               }, 3000);
               //để hiển thị Someone is typing...
               //nhờ listen event typing
           });

         Echo.private('message.'+this.friend.sessionId)
           .listen('MsgReadEvent', (e)=>{
               this.chats.forEach(chat=>{
                   chat.id == e.chat.id? chat.readAt = e.chat.readAt : '';
               })
           });//mes được gửi có text-red nếu tin nhắn được xem sẽ đối sang text-default nhờ listen event này
        //các event khác nhau MessageEvent, MsgReadEvent có thể cùng private channel message.sessionId
        

          

        
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