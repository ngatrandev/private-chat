<template>
    <div class="mx-auto container shadow-md" >
        <div class="flex">
            <div class="w-1/4 border border-grey-light">
            <div class="flex bg-grey-light font-serif justify-center py-2 border-r border-grey-lighter">
                <h4>Your friends</h4>
            </div>
            <ul class="list-reset overflow-y-scroll relative" style="height:500px">
                <li 
                :class="{'text-red line-through':block}"
                class="border-b border-grey-lighter px-2 py-2">hfjdf</li>
            </ul>
        </div>
        <message-component
        @block_toggle="session_block"
        @unblock_toggle="session_unblock"
        :chats="chats"
        ></message-component>
        </div>
        
        <input-component
        @input="submit"
        ></input-component>
        
        
    </div>
</template>

<script>
    import MessageComponent from './MessageComponent';
    import InputComponent from './InputComponent';
    export default {
       components: {MessageComponent, InputComponent},
       data() {
           return {
               chats: [{message: 'Hello'}, {message: 'How are u'} ],
               block: false
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


       }
       
    }
    //message-component là chat area
    //input-component là thẻ input
    //<dropdown> trong <message-componet> trong <chat-component>
    //dùng $emit để phát event kết nối func từ trong ra ngoài
    //:class="{'text-red line-through':block}" cách bind class
</script>
