<template>
    <div class="mx-auto container relative">
        <div class="flex" >
            <div class="w-1/4 border border-grey-light">
                <div 
                style="height:40px"
                class="flex bg-grey-light font-serif justify-center py-2 border-r border-grey-lighter">
                    <div class="flex">
                        <h4>Add friend</h4>
                       
                    </div>
                    
                    
                    
                    
                </div>
                
                <div class="mt-1"
                    style="height:540px">
                        <div :class="{'border-red': invalid}"
                            class="flex border-b border-grey py-1 w-full text-xs">
                                <svg class="h-3 w-3 fill-current text-blue ml-1 mr-1 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M18 2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h16zm-4.37 9.1L20 16v-2l-5.12-3.9L20 6V4l-10 8L0 4v2l5.12 4.1L0 14v2l6.37-4.9L10 14l3.63-2.9z"/></svg>
                                <input
                                    type="email"
                                    placeholder="Email address"
                                    class="p-1 :focus outline-none w-full " 
                                    @input="testEmail($event.target.value)"
                                    @click="getValidEmail"
                                    v-model="form.email"
                                    >
                                <span v-if="valid">
                                    <svg class="h-3 w-3 fill-current text-blue mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                                </span> 
                                <span v-if="invalid" >
                                    <svg class="h-3 w-3 fill-current text-red mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM11.4 10l2.83-2.83-1.41-1.41L10 8.59 7.17 5.76 5.76 7.17 8.59 10l-2.83 2.83 1.41 1.41L10 11.41l2.83 2.83 1.41-1.41L11.41 10z"/></svg>
                                </span> 
                        </div>
                            
                        <div class="flex justify-end  py-1">
                            <button 
                            @click.prevent="reset()"
                            class="bg-white border border-blue hover:text-blue-dark text-blue text-xs font-bold py-1 px-2 rounded-full mr-2">
                            Clear</button>
                            <button v-show="valid"
                            @click.prevent="submit"
                            class="bg-blue border border-blue hover:bg-blue-dark text-white text-xs font-bold py-1 px-2 rounded-full mr-1">
                            Invite
                            </button>
                            <button v-show="!valid"
                            class="bg-blue border border-blue text-white text-xs font-bold py-1 px-2 rounded-full opacity-50 cursor-not-allowed mr-1">
                            Invite
                            </button>
                        </div>   
                </div>
            </div>

            <div class="w-3/4 border border-grey-light ">
                <div 
                style="height:40px"
                class="flex bg-grey-light font-serif justify-center w-full py-2">
                    <h4>Your Invitation</h4>
                    
                </div>
                <div class="relative">
                    <ul v-chat-scroll 
                    style="height:540px"
                    class="list-reset overflow-y-scroll ">
                         <li v-for="invite in invites" 
                            class="flex justify-between border-b border-grey-lighter font-serif px-2 py-2">{{invite.user1_name}}'s invitation
                            <div>
                                    <button @click.prevent="accept(invite.id, invite)" class="bg-blue hover:bg-blue-dark text-xs text-white text-font-bold py-1 px-1 rounded-full">
                                    Accept
                                    </button>
                                    <button @click.prevent="decline(invite.id, invite)" class="bg-red hover:bg-red-dark text-xs text-white text-font-bold py-1 px-1 rounded-full">
                                    Decline
                                    </button>
                            </div>
                            
                        </li>
                    </ul>
                </div>
            
            </div>

        </div>
        
    </div>
</template>

<script>
  
    

    

    export default {
   
       props: ['id', 'invites'],
       data() {
           return {
            
            validEmails: [],
            invalid: false,
            valid: false,
            form: {
                email: ''
                },
              

        }
       },
       
       methods: {
           
           testEmail(code) {
             
                if (this.validEmails.includes(code) ) {
                   
                    this.valid = true;
                    this.invalid = false;
                    
                } else {
                    this.invalid = true;
                    this.valid = false;
                }
                
            },

             async submit() {
                await axios.post('/user/'+this.id+ '/storesession', this.form);
                this.reset();
            },

            reset() {
                this.invalid=false;
                this.valid = false;
                this.form.email = '';
            },

            async getValidEmail() {
            //mỗi khi click vào input sẽ fetch dữ liệu        
                  
                        const result = (await axios.get(`/getemails`)).data;
                        //result trả về là object, dùng Object.values() để chuyển các value thành array
                        this.validEmails = Object.values(result);
                    
                  
                
            },
            //Không để getValidEmail() trong created vì chỉ fetch dữ liệu 1 lần khi vào trang
            //trong khoảng tg đó data có thể thay đổi, làm data trong Vue sai lệch database
           
            async accept(key, invite) {
            this.invites.splice(this.invites.indexOf(invite),1);//cách dùng splice để xóa data trong array
            await axios.patch('/sessions/'+key+'/update');
                
            },

            async decline(key, invite) {
            this.invites.splice(this.invites.indexOf(invite),1);//cách dùng splice để xóa data trong array
            await axios.post('/sessions/'+key+'/decline');
                
            },
          


       },
    }
       

       

</script>
