<template>
    <modal name="add-dialog" classes="p-5 bg-white rounded-lg shadow-lg" height="auto" >
            <div class="font-normal mb-5 text-center text-xl">Choose your friends to add in '{{group.name}}'</div>
            <div 
            v-for="(name, id) in friends"
            class="ml-2 py-1" 
            :class="checkedcss(id)? 'text-black' : 'text-grey'"
            >
                <input
                @click="checkedcss(id)" 
                type="checkbox" 
                :value="id" 
                v-model="form.users">
                <label>{{name}}</label>
            </div>
            
            <div class="flex justify-end  py-1 border-t border-grey-light">
                <button 
                @click.prevent="$modal.hide('add-dialog')"
                class="bg-white border border-blue hover:text-blue-dark text-blue text-sm font-bold py-1 px-2 rounded-full mr-2">
                Cancel</button>
                <button v-show="showButton"
                @click.prevent="send"
                class="bg-blue hover:bg-blue-dark text-white text-xs font-bold py-1 px-2 rounded-full">
                Add
                </button>
                <button v-show="!showButton"
                class="bg-blue text-white text-xs font-bold py-1 px-2 rounded-full opacity-50 cursor-not-allowed">
                Add
                </button>
                
                
            </div>
       
    </modal>
</template>

<script>

export default {
    props: ['group', 'friends'],
     data() {
            return { 
                    form: {
                        
                        users: []
                    },
                    showButton: false,
            }
        },
    methods: {
         
         

         checkedcss(id) {
               this.checkButton();
               return this.form.users.includes(id);
               //để thay đổi css khi checked
               //class ngoài bind được với data, còn có thể bind được cả function (return về boolean)
           },

           checkButton () {
               if(this.form.users.length > 0) {
                   this.showButton = true;
               } else {
                   this.showButton = false;
               }
           },

           async send(e) {
               
             await axios.post(`group/${this.group.id}/add`, this.form)
              //this.form.users = request('users') bên controller nếu chỉ viết this.users dễ gây error
               
                    
            this.form.users=[];
            this.$modal.hide('add-dialog')
           },

         
    },
    
}
//ưu điểm khi dùng modal là có thể đặt component này ở vị trí bất kì
//không bị ràng buộc trong parent-child component
</script>