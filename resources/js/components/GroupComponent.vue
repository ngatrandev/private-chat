<template>
        <div v-show="isOpen"  class="w-3/4 border border-grey-light relative">
            <div class="flex items-center bg-grey-light font-serif justify-between w-full py-1">
                <h4  class=" flex items-center">{{group.name}} 
                    <span 
                    class="relative"
                    v-for="user in group.members"
                    ><v-gravatar class="px-1 py-1 ml-1 rounded-full" :email="user.email" alt="Nobody" :size="20" default-img="mm" />
                    <svg 
                    class="h-2 w-2 fill-current text-green feather feather-circle pin-b pin-r absolute z-10"
                    v-show="user.online"
                    xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle></svg>
                    </span></h4>
                <right-group-dropdown @clear="clearChat"  align=right width="200px"></right-group-dropdown>
            </div>
            <ul v-chat-scroll class="list-reset overflow-y-scroll" style="height:500px">
                <li 
                class="py-2 px-2  " v-for="chat in chats"
                :class="{'text-right':chat.type == 0}">
                <span  v-show="chat.type == 1">
                    <v-gravatar class="-mb-2 rounded-full" :email="chat.from" alt="Nobody" :size="30" default-img="mm" />
                </span>
                <span
                    v-tooltip="{
                        content: getReadBy(),
                        html: true,
                        show: chat.id == tooltipId,
                        trigger: 'manual',
                        placement: 'left',
                        classes: 'text-black text-xs mr-2 px-1 py-1 border-b border-blue rounded shadow-lg'
                        }"
                    @mouseover="readBy(chat.id, chat.type)"
                    @mouseout="resetTooltipId"
                    v-show="chat.content"
                    v-text="chat.content"
                    class="px-2 py-1 rounded shadow-lg text-sm "
                    :class="{
                    'bg-blue-lighter cursor-pointer':chat.type == 0,
                    'bg-pink-lighter':chat.type == 1
                    }"
                ></span>
                <img @mouseover="readBy(chat.id, chat.type)" class="h-24 rounded shadow-lg" v-show="chat.image" :src="chat.image"  alt="">
                <br>
                 <span
                v-text="chat.send_at"
                class=" py-1 text-2xs text-grey"
                ></span>
                </li>
            </ul>
            <div v-show="this.activePeer" class="bg-grey-light rounded text-blue text-xs font-bold absolute z-10 pin-b pin-l">
               {{typingUser}}  is typing...
            </div>
        </div>
        
</template>
<script>
import DropDown from './DropDown';
import _ from 'lodash';
export default {
    props: ['group', 'isOpen', 'id'],
    components: {DropDown},
    data() {
        return {
            chats: [],
            val: '',
            activePeer: false,
            typingUser: '',
            readby: [],
            tooltipId: '',
        }
    },

    methods: {
       

        async getMessages() {
            this.chats = (await axios.post(`/group/${this.group.id}/chats`)).data.data;
           },

        clearChat() {
            this.chats = [];
            axios.post(`/group/${this.group.id}/clear`);
        },

        readBy: _.debounce (async function (id, type) {
        //sử dụng debounce kết hợp mouseover để tránh trường hợp mouse chạy qua hàng loạt đối tượng
        //và func bên dưới bị gọi liên tục
        //với debounce khi mouseover đối tượng cần thêm 1 khoảng tg xác định mới gọi func bên dưới 1 lần 
        // do dùng debounce nên phải viết classic function    
            if(type == 0) {
                console.log('okay');
                this.readby = (await axios.post(`/readBy/${id}`)).data;

                this.tooltipId = id;

                setTimeout(()=> {
                this.tooltipId = '';
               }, 3000);
            }
        }, 1000),

        getReadBy() {
            if(this.readby.length == 0) {
                return 'Unread';
            }
                let user = Object.values(this.readby);
                return `Read by: ${user}`;
        },

        resetTooltipId () {
            this.tooltipId = '';
            //khi mouseout lập tức đóng popup (v-tooltip)
            //không cần đến 3s như đã thiết lập
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
          
           .listenForWhisper('grouptyping', e=> {
               this.activePeer = true;
               this.typingUser = e.name
               setTimeout(()=> {
                   this.activePeer=false
                   this.typingUser=''
               }, 3000);
               //để hiển thị Someone is typing...
               //nhờ listen event 
           });


         Echo.join('online')
                    .here((users)=> {
                        this.group.members.forEach(member=> {
                            users.forEach(user=> {
                                if(user.id == member.id) {
                                    member.online = true;
                                }
                            })
                        })
                    })
                    .joining((user)=> {
                        this.group.members.forEach(member =>{
                                if(user.id == member.id) {
                                    member.online = true;
                                }
                            })
                    })
                    .leaving((user)=> {
                        this.group.members.forEach(member => {
                                if(user.id == member.id) {
                                    member.online = false;
                                }
                            })
                            
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

// Do không listen được event để xác định msg đã gửi có được xem chưa
// Nên dùng readBy function bên trên để fetch dữ liệu từ database
// Kết hợp với mouseover, debounce, v-tooltip để show thông tin về read at
// Lưu ý cách dùng v-tooltip để tiện lợi khi show các popup.
</script>