<template>
        <div v-show="isOpen"  class="w-3/4 border border-grey-light ">
            <div class="flex bg-grey-light font-serif justify-between w-full py-2">
                <h4>{{friend.name}}</h4>
                <dropdown @blocked="blocked1" @unblocked="unblocked1" align=right width="200px"></dropdown>
            </div>
            <ul v-chat-scroll class="list-reset overflow-y-scroll" style="height:500px">
                <li class="py-2 px-2  " v-for="chat in chats"
                :class="chat.type == 0? 'text-right': ''"
                >
                <span
                v-text="chat.message"
                class="px-2 py-1 rounded shadow-lg text-sm"
                :class="chat.type == 0? 'bg-blue-lighter': 'bg-pink-lighter'"
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
           }
    },

    created() {
        Echo.private('message.'+this.friend.sessionId)
           .listen('MessageEvent', (e)=>{
               if(this.id == e.userId) {
                   this.val = 0;
               } else {
                   this.val = 1;
                   //val dùng để xác định mess được push vào là send hay recieve
               }
              this.chats.push({
                  message: e.message,
                  type: this.val
              })
              //khi send hoặc recieve mess mới không pull lại data từ data base
              // mà qua listen event để thêm mess mới vào data của Vue
              // làm cho mess được show nhanh hơn
           });

        
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