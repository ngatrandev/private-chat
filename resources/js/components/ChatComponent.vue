<template>
    <div class="mx-auto container shadow-md" >
        <div class="flex">
            <div class="w-1/4 border border-grey-light">
                <div class="flex bg-grey-light font-serif justify-between py-2 border-r border-grey-lighter">
                    <h4>Your friends</h4>
                    <friend-dropdown
                    align=right width="200px"
                    @send1='sendEmail'
                    ></friend-dropdown>
                </div>
                
                <ul   class="list-reset overflow-y-scroll relative" style="height:500px">
                    <li v-for="friend in friendForm" 
                    @click.prevent="showChat(friend.sessionId)"
                   
                    :class="activeSessionId==friend.sessionId ? 'bg-pink text-black': 'text-blue'"
                    class="flex hover:bg-teal hover:text-black justify-between border-b border-grey-lighter font-serif px-2 py-2">{{friend.name}}       
                    </li>
                    <li v-for="invite in inviteForm" 
                    class="flex justify-between border-b border-grey-lighter font-serif px-2 py-2">{{invite.user1_name}}'s invitations
                            <button @click.prevent="accept(invite.id)" class="bg-blue hover:bg-blue-dark text-xs text-white text-font-bold py-1 px-1 rounded-full">
                            Accept
                            </button>
                    </li>
                </ul>
            </div>
            <message-component
            v-for="friend in friendForm"
            :key="friend.sessionId"
            :friend="friend"
            :isOpen="activeSessionId==friend.sessionId"
            @block_toggle="session_block"
            @unblock_toggle="session_unblock"
            :chats="chats"
            ></message-component>
        </div>
        
        <input-component
        v-show="activeSessionId > 0"
        @input="submit"
        ></input-component>
    </div>
</template>

<script>
    import MessageComponent from './MessageComponent';
    import InputComponent from './InputComponent';
    import FriendDropDown from './FriendDropDown';
    import _ from 'lodash';
    import { async } from 'q';

    export default {
       components: {MessageComponent, InputComponent, FriendDropDown},
       props: ['id'],
       data() {
           return {
               chats: [{message: 'Hello'}, {message: 'How are u'} ],
               activeSessionId: '',
               block: false,
               form: {email: ''},
               inviteForm : '',
               friendForm : ''

           }
       },
       methods: {
           submit(value) {
               this.chats.push({message: value})
           },
           session_block() {
               this.block = true;
           },

           session_unblock() {
               this.block = false;
           },

           showChat(id) {
               this.activeSessionId = id;
           },

           async sendEmail(e) {
               this.form.email = e;
              await axios.post('/user/'+this.id+ '/storesession', this.form);
              //this.form.email = request('email') bên controller nếu chỉ viết this.email dễ gây error
           },
           
            async accept(key) {
               
            await axios.patch('/sessions/'+key+'/update');
                
            },

            async getInvites() {
              this.inviteForm =(await axios.get('/getinvites')).data.data;
                
            },

            async getFriends() {
              this.friendForm =(await axios.get('/getfriends')).data.data;
                
            }


       },

       created() {
           this.getFriends();
           this.getInvites();

           this.debouncedGetInvites = _.debounce(this.getInvites, 1000);
           this.debouncedGetFriends = _.debounce(this.getFriends, 1000);
           
       },

       watch: {
           inviteForm: function () {
               this.debouncedGetInvites();
               
           },

           friendForm: function () {
               this.debouncedGetFriends()
           }

       }
       
    }
    //message-component là chat area
    //input-component là thẻ input
    //<dropdown> trong <message-componet> trong <chat-component>
    //dùng $emit để phát event kết nối func từ trong ra ngoài
    //:class="{'text-red line-through':block}" cách bind class
    //tìm hiểu thêm về cách dùng :key thay vì dùng accept(invite.id)

    //để pull data liên tục từ database, để tránh refresh page khi submit
    //ta dùng axios để pull data chứ không bind data qua props 
    //không cần viết return hay location trong các method làm thay đổi data (tránh refresh)
    //dùng kết hợp watch create và debounce để pull data mỗi giây
</script>
