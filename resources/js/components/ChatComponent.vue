<template>
    <div class="mx-auto container relative">
        <div class="flex" >
            <div class="w-1/4 border border-grey-light">
                <div 
                style="height:40px"
                class="flex bg-grey-light font-serif justify-center py-2 border-r border-grey-lighter">
                    <div class="flex">
                        <h4>Chats</h4>
                    </div>
                    
                </div>
                
                <ul
                style="height:540px"
                class="list-reset overflow-y-scroll relative " >
                    <li v-for="friend in friendForm" 
                    @click.prevent="showChat(friend.sessionId, friend.id)"
                    :class="activeSessionId==friend.sessionId ? 'bg-pink text-black': 'text-blue'"
                    class="flex hover:bg-teal hover:text-black justify-between border-b border-grey-lighter font-serif px-2 py-2">
                    <div>
                         <span>{{friend.name}}</span>
                          <span v-if="friend.unreadCount >0" class="text-red ml-1">{{friend.unreadCount}}</span>
                          <span v-show="friend.msgTyping">
                            <svg  width="15" height="5" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15"
                                            begin="0s" dur="0.8s"
                                            values="15;9;15" calcMode="linear"
                                            repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="1" to="1"
                                            begin="0s" dur="0.8s"
                                            values="1;.5;1" calcMode="linear"
                                            repeatCount="indefinite" />
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9"
                                            begin="0s" dur="0.8s"
                                            values="9;15;9" calcMode="linear"
                                            repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                            begin="0s" dur="0.8s"
                                            values=".5;1;.5" calcMode="linear"
                                            repeatCount="indefinite" />
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15"
                                            begin="0s" dur="0.8s"
                                            values="15;9;15" calcMode="linear"
                                            repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="1" to="1"
                                            begin="0s" dur="0.8s"
                                            values="1;.5;1" calcMode="linear"
                                            repeatCount="indefinite" />
                                </circle>
                            </svg>
                          </span>
                    </div>
                    <svg 
                    class="h-3 w-3 fill-current text-green feather feather-circle mt-1"
                    v-show="friend.online"
                    xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle></svg>
                    </li>
                   
                     <li v-for="group in groups" 
                     @click="showGroup(group.id)"
                     :class="activeGroupId==group.id ? 'bg-pink text-black': 'text-blue'"
                    class="flex hover:bg-teal hover:text-black  border-b border-grey-lighter font-serif px-2 py-2"
                    ><svg class="mr-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z"/></svg>
                    {{group.name}} ({{group.memberCount}})
                    <span v-if="group.unreadCount >0" class="text-red ml-1">{{group.unreadCount}}</span>
                          <span class="ml-1" v-show="group.msgTyping">
                            <svg  width="15" height="5" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15"
                                            begin="0s" dur="0.8s"
                                            values="15;9;15" calcMode="linear"
                                            repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="1" to="1"
                                            begin="0s" dur="0.8s"
                                            values="1;.5;1" calcMode="linear"
                                            repeatCount="indefinite" />
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9"
                                            begin="0s" dur="0.8s"
                                            values="9;15;9" calcMode="linear"
                                            repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                            begin="0s" dur="0.8s"
                                            values=".5;1;.5" calcMode="linear"
                                            repeatCount="indefinite" />
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15"
                                            begin="0s" dur="0.8s"
                                            values="15;9;15" calcMode="linear"
                                            repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" from="1" to="1"
                                            begin="0s" dur="0.8s"
                                            values="1;.5;1" calcMode="linear"
                                            repeatCount="indefinite" />
                                </circle>
                            </svg>
                          </span>
                    </li>
                </ul>
            </div>
            <message-component
            v-for="friend in friendForm"
            :key="friend.id+1000"
            :friend="friend"
            :isOpen="activeSessionId==friend.sessionId"
            :id="id"
            :route="route"
            ></message-component>
            <group-component
            v-for="group in groups"
            :key="group.id"
            :group="group"
            :users="users"
            :isOpen="activeGroupId==group.id"
            :id="id"
            :route="route"
            ></group-component>
        </div>
        
    </div>
</template>

<script>
  
    import _ from 'lodash';
    import { async } from 'q';
    

    

    export default {
   
       props: ['id', 'click'],
       data() {
           return {
            
               activeSessionId: '',
               activeFriendId: '',
               activeGroupId: '',
               form: {email: ''},
               friendForm : [],
               users: [],
               groups: [],
               route: '',
               notification: 0,
               validEmails: [],
              

           }
       },
       watch: {
         async   click() {
                
                //mỗi lần click vào chat button, giá trị click sẽ thêm 1 đơn vị
                //do trong watch khi click thay đổi sẽ chạy code bên trong để fetch data chính xác về friend và group
               
                this.getGroups();
                await this.getFriends();//phải await getFriends trước khi checkOnline
                this.checkOnline();
          
            }
        },
       
       methods: {
           
          
           

           showChat(val1, val2) {
               this.activeGroupId='';
               this.activeSessionId = val1;
               this.activeFriendId = val2;
               this.friendForm.forEach(friend=>{
                   if(friend.sessionId == val1) {
                       friend.unreadCount = 0;
                   }
               })
               this.read();
                this.routeCheck();
           },
           showGroup(id) {
               this.activeSessionId='';
               this.activeGroupId = id;
               this.groups.forEach(group=>{
                   if(group.id == id) {
                       group.unreadCount = 0;
                   }
               })
               this.groupread();
               this.routeCheck();
           },
           
           

            
            async getGroups() {
              this.groups =(await axios.get('/getgroups')).data.data;
              this.groups.forEach(group => {
                  Echo.private(`group.${group.id}`)
                  .listen('GroupMsgEvent', (e) => {
                      if (group.id != this.activeGroupId) {
                          group.unreadCount++;
                          //group đang active thì không count unread message
                      } else {
                          if(e.userId != this.id) {
                              this.groupread();
                              //khi đang trò chuyện lúc nhận tin nhắn
                              //thì read_at trong chats cũng được update từ NULL sang Carbon::now
                              //nhờ function read().
                          }
                      }
                      })
                    .listen('GroupNotifyMsgEvent', (e) => {
                      if (group.id != this.activeGroupId) {
                          group.unreadCount++;
                          //group đang active thì không count unread message
                      } else {
                          
                              this.groupread();
                              //khi đang trò chuyện lúc nhận tin nhắn
                              //thì read_at trong chats cũng được update từ NULL sang Carbon::now
                              //nhờ function read().
                          
                      }
                      })
                    .listenForWhisper('grouptyping', e=> {
                        group.msgTyping = true;
                        setTimeout(()=> {
                            group.msgTyping=false
                        }, 3000);
                        //để hiển thị animated dot khi có người đang soạn mess định gửi cho bạn
                    });
                
                // có thể viết listen event trong từng object từ data của Vue.
                // khi listen event các prop trong object này sẽ thay đổi
              });


                
            },

            async getFriends() {
              this.friendForm =(await axios.get('/getfriends')).data.data;
              this.friendForm.forEach(friend => {
                  Echo.private(`message.${friend.sessionId}`)
                  .listen('MessageEvent', (e) => {
                      if (friend.sessionId != this.activeSessionId) {
                          friend.unreadCount++;
                          //session đang active thì không count unread message
                      } else {
                          if(e.userId != this.id) {
                              this.read();
                              //khi đang trò chuyện lúc nhận tin nhắn
                              //thì read_at trong chats cũng được update từ NULL sang Carbon::now
                              //nhờ function read().
                          }
                      }
                      })
                    .listenForWhisper('typing', e=> {
                        friend.msgTyping = true;
                        setTimeout(()=> {
                            friend.msgTyping=false
                        }, 3000);
                        //để hiển thị animated dot khi có người đang soạn mess định gửi cho bạn
                    });
                
                // có thể viết listen event trong từng object từ data của Vue.
                // khi listen event các prop trong object này sẽ thay đổi
              });
                
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


           },

          async read() {
              await axios.post(`/session/${this.activeSessionId}/read`);
            // để chuyển các unread mess thành read mess.
          },
          async groupread() {
              await axios.post(`/group/${this.activeGroupId}/read`);
            // để chuyển các unread mess thành read mess.
          },

          routeCheck() {
            if (this.activeSessionId > 0) {
            this.route = `send/${this.activeSessionId}`;
            } else {
            this.route = `groupsend/${this.activeGroupId}`;
            }

             
          }

          

          


       


         



           


           
                    

         


       },
       

       

       created() {
          this.getFriends();
          this.getGroups();
          
          
          
          
         
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
           

           

           

           

           // Không viết Echo.private('message.session_id)...ở đây
           // vì mỗi lần auth chỉ có thể kèm theo 1 giá trị id nhất định và không thể thay đổi
           // nhưng session_id thì có nhiều giá trị theo friend list
           // phải viết bên created của MessageComponent mỗi <message-component> ứng với 1 session_id nên phù hợp

           

         

           

           
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

    //Thông thường sau khi thay đổi database sẽ phát Event (trong file controller)
    //Để listen event đều phải qua created() để khi đăng nhập vào trang
    //thì phần code listen đã được chạy sẵn, khi có event được phát
    //thì trang sẽ lập tức bắt được
    //sau khi bắt event có thể dùng để fetch data từ database
    //hoặc dùng để thay đổi các data trong Vue (1 số data chỉ là tạm thời để show đến user
    //sẽ bị mất sau khi refresh)
    //khi phát event có thể kèm theo data, để khi listen event sử dụng data này
    //làm thay đổi các data trong Vue
    //nếu viết listen event trong create thì dùng để tương tác với toàn bộ data của Vue
    //nếu viết listen event trong 1 object của data thì dùng để tương tác với props bên trong object này.
    //1 event được phát ra có thể được listen ở nhiều vị trí khác nhau với mục đích khác nhau

    // Kĩ thuật tương tác với database, Vue thông qua broadcast event:
    // Khi có 1 thao tác từ front-end làm thay đổi database và phải trả kết quả lại front-end
    // qua axios, controller ta send request đến server để làm thay đổi database
    // sau đó phát ra event, từ Vue ta listen event và tương tác với data của Vue
    // để trả kết quả về front-end (mà không cần fetch data từ database)
    // cách này nhanh chóng show kết quả lên front-end
    // hạn chế việc liên tục fetch dữ liệu từ database
    // nhưng vẫn đảm bảo sau khi refresh trang (fetch từ database) vần cho kết quả giống nhau
    // hay kết quả từ data của Vue show đến user vẫn đúng với database

    //viết  :key="friend.id+1000" ở <message-component> để tránh trùng với :key ở <group-component>
    // nếu không viết :key hoặc key trùng đều xuất hiện warning - nghiên cứu thêm
    //<message-component> và group-component> tương đồng nhau nhưng khác nhau ở 1-1 chat và group chat
    //nếu viết 2 component input <input-component> và <group-input-component> 
    //khi attachment <file-upload> đến 2 route khác nhau - sẽ gây lỗi
    //nên dùng routeCheck() để bind prop 'route' qua input component


</script>
