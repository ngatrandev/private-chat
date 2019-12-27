<template>
    <div class="mx-auto container relative">
        <div class="flex" >
            <div class="w-1/4 border border-grey-light">
                <div 
                style="height:40px"
                class="flex bg-grey-light font-serif justify-center py-2 border-r border-grey-lighter">
                    <div class="flex">
                        <h4>Your Groups</h4>
                    </div>   
                </div>
                
                <ul
                style="height:540px"
                class="list-reset overflow-y-scroll relative mt-1" >
                    <li v-for="group in groups"
                    class="flex justify-between border-b border-grey-lighter font-serif px-2 py-2">
                     {{group.name}} ({{group.memberCount}})</li>
                </ul>
            </div>

            <div class="w-3/4 border border-grey-light ">
                <div 
                style="height:40px"
                class="flex bg-grey-light font-serif justify-center w-full py-2">
                    <h4>Create new group</h4>
                    
                </div>
                <div class="relative overflow-y-scroll" style="height:540px">
                    <div
                        class="rounded shadow mt-1 bg-white border-b border-grey-dark">
                        
                        <input 
                        @input="checkButton"
                        @click.prevent="getFriends"
                        v-model="form.name" 
                        class="appearance-none bg-transparent border-b  border-teal w-full text-black mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Your group name"
                        >
                    
                        <div 
                        v-show="showList"
                        v-for="friend in friends"
                        class="ml-2 py-1" 
                        :class="checkedcss(friend.id)? 'text-black' : 'text-grey'"
                        >
                            <input
                            @click="checkedcss(friend.id)" 
                            type="checkbox" 
                            :value="friend.id" 
                            v-model="form.users">
                            <label>{{friend.name}}</label>
                        </div>
                        <div class="flex justify-center py-1 border-t border-grey-light">
                            <button v-show="showButton"
                            @click="send"
                            class="bg-blue hover:bg-blue-dark text-white text-xs font-bold py-1 px-2 rounded-full">
                            Create
                            </button>
                            <button v-show="!showButton"
                            class="bg-blue text-white text-xs font-bold py-1 px-2 rounded-full opacity-50 cursor-not-allowed">
                            Create
                            </button>
                        </div>
                    </div>
                   
                </div>
            
            </div>

        </div>
        
    </div>
</template>

<script>
  
    

    

    export default {
   
       props: ['id','click', 'active'],
       data() {
           return {
            groups: [],
            friends: [],
            form: {
                        name: '',
                        users: []
                    },
            showButton: false,
            showList: false
        }
       },

       watch: {
            click() {
                
                //mỗi lần click vào chat button, giá trị click sẽ thêm 1 đơn vị
                //do trong watch khi click thay đổi sẽ chạy code bên trong để fetch data chính xác về group
               
                this.getGroups();
          
            },
            active(active) {
                if(!active) {
                    this.showList=false;
                }
            },
        },
       
       methods: {
           
           async getGroups() {
              this.groups =(await axios.get('/getgroups')).data.data;
           },
           async getFriends() {
              this.friends =(await axios.get('/getfriends')).data.data;
              this.showList=true;
           },
           async send(e) {
               
             await axios.post('/creategroup', this.form);
                    this.form.name='';
                    this.form.users=[]; 
           },

           checkedcss(id) {
               this.checkButton();
               return this.form.users.includes(id);
               //để thay đổi css khi checked
               //class ngoài bind được với data, còn có thể bind được cả function (return về boolean)
           },

           checkButton () {
               if(this.form.name.trim().length > 0 && this.form.users.length > 0) {
                   this.showButton = true;
               } else {
                   this.showButton = false;
               }
           }
          


       },
    }
       

       

</script>
