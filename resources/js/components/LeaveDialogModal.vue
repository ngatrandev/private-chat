<template>
    <modal name="leave-dialog" classes="p-5 bg-white rounded-lg shadow-lg" height="auto" >
            <div class="font-normal mb-5 text-center text-xl">Do you want to leave '{{name}}' ?</div>
            <div class="flex justify-end">
                <button 
                @click.prevent="$modal.hide('leave-dialog')"
                class="bg-white border border-blue hover:text-blue-dark text-blue text-sm font-bold py-1 px-2 rounded-full mr-2">
                Cancel</button>
                
                <button 
                @click="confirm"
                class="bg-blue hover:bg-blue-dark text-white text-sm font-bold py-1 px-2 rounded-full">
                Leave</button>
                
            </div>
       
    </modal>
</template>

<script>

export default {
    props: ['name'],
    methods: {
         confirm() {
             this.$emit('leave');
             this.$modal.hide('leave-dialog');
         }
         
    }
}

</script>