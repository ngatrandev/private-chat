<template>
    <div class="mx-auto container relative">
        <div class="flex" >
            <div class="w-1/4 border border-grey-light">
                <div 
                style="height:40px"
                class="flex bg-grey-light font-serif justify-center py-2 border-r border-grey-lighter">
                    <div class="flex">
                        <h4>About us</h4>
                    </div>   
                </div>
                
                <div class="mt-1"
                    style="height:540px">
                      <div class="px-1 font-mono"
                    >At our company, we are constantly iterating, solving problems and working together to connect people all over the world through our apps and technologies.</div>
                     
                </div>
            </div>

            <div class="w-3/4 border border-grey-light ">
                <div 
                style="height:40px"
                class="flex bg-grey-light font-serif justify-center w-full py-2">
                    <h4>Notification</h4>
                    
                </div>
                <div class="relative">
                    <ul
                    style="height:540px"
                    class="list-reset overflow-y-scroll ">
                       
                        <li class="py-2 px-2 text-xs border-b border-grey-light"
                :class="notification.read? 'text-black':'text-red'" 
                v-for="notification in notifications"
                >{{notification.content}}
                    <span :class="notification.read? 'text-grey-dark':'text-red-light'">({{notification.time}})</span>
                </li>  
                        </li>
                    </ul>
                </div>
            
            </div>

        </div>
        
    </div>
</template>

<script>
  
    

    

    export default {
   
       props: ['notifications'],
     
    }
       

       

</script>
