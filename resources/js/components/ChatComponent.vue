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
                    
                    <svg 
                    class="h-4 w-4 fill-current"
                    v-show="friend.online"
                    :class="activeSessionId==friend.sessionId ? 'text-black': 'text-red'" 
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM6.5 9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm7 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm2.16 3a6 6 0 0 1-11.32 0h11.32z"/></svg>
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
               friendForm : [],
               users: [],
              

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
              
                
            },

            async getFriendsAndCheckOnline() {
              this.friendForm =(await axios.get('/getfriends')).data.data;
              this.checkOnline();// check online lập tức sau khi await data pull vào friendForm
                
            },
            
          
          checkOnline() {
                this.friendForm.forEach(friend=> {
                            this.users.forEach(user=> {
                                if(user.id == friend.id) {
                                    friend.online = true;
                                }
                            })
                        })
            //muốn dùng forEach các giá trị ban đầu đặt [], không đặt ''
            // func này dùng để check user có đang online sau khi accept invite
            // do sau khi accept invite không refresh page mà chỉ listen AcceptEvent
            // nên presence-channel 'online' bên dưới không chạy phải dùng function này để check lập tức


           }
           
                    

         


       },
       

       

       created() {
          this.getFriends();
          this.getInvites();
          
         
            Echo.join('online')
                    .here((users)=> {
                        this.users = users;
                        this.friendForm.forEach(friend=> {
                            users.forEach(user=> {
                                if(user.id == friend.id) {
                                    friend.online = true;
                                }
                            })
                        })
                    })
                    .joining((user)=> {
                        this.users.push(user);
                        this.friendForm.forEach(friend =>{
                                if(user.id == friend.id) {
                                    friend.online = true;
                                }
                            })
                    })
                    .leaving((user)=> {
                        this.users.splice(this.users.indexOf(user),1);
                        this.friendForm.forEach(friend => {
                                if(user.id == friend.id) {
                                    friend.online = false;
                                }
                            })
                            //lưu ý cách viết splice
                    });
         
            //.here: các user đang online cùng thời điểm
            //.joining: user mới đăng nhập vào
            //.leaving: user mới logout
           

           Echo.private('invite.'+this.id)
           .listen('InviteEvent', ()=>{
               this.getInvites();
               
           });

           Echo.private('accept.'+this.id)
           .listen('AcceptEvent', ()=>{
               this.getInvites();
               this.getFriendsAndCheckOnline();
               
           });

           

         

           

           
       },

      
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
    //dùng kết hợp watch create và debounce để pull data mỗi giây sẽ nặng server không dùng cách này
    //dùng private-channel để make-listen event ngay thời điểm
    //có invite hoặc accept invite data sẽ được pull ngay mà không cần refresh page
</script>
