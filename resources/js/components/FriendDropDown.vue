<template>
    <div class="dropdown relative">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click.prevent="getValidEmail"
        >
            <button  
                    class="flex items-center no-underline text-sm focus:outline-none hover:text-red" 
                    >
                   <svg class="h-5 w-5 fill-current"
                   :class="isOpen? 'text-red': 'text-default'"  
                   xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2 6H0v2h2v2h2V8h2V6H4V4H2v2zm7 0a3 3 0 0 1 6 0v2a3 3 0 0 1-6 0V6zm11 9.14A15.93 15.93 0 0 0 12 13c-2.91 0-5.65.78-8 2.14V18h16v-2.86z"/></svg>
            </button>
        </div>

        <div v-show="isOpen"
             class="dropdown-menu absolute z-10 rounded shadow mt-3 bg-white"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             :style="{ width }"
        >
            <div>
                
                <div :class="{'border-red': invalid}"
                    class="flex mb-1 border border-grey p-1 text-xs rounded w-full">
                        <svg class="h-4 w-4 fill-current text-blue mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M18 2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h16zm-4.37 9.1L20 16v-2l-5.12-3.9L20 6V4l-10 8L0 4v2l5.12 4.1L0 14v2l6.37-4.9L10 14l3.63-2.9z"/></svg>
                        <input
                            type="email"
                            placeholder="Email address"
                            class="p-1 :focus outline-none w-full" 
                            @input="testEmail($event.target.value)"
                            v-model="form.email"
                            >
                        <span v-if="valid">
                            <svg class="h-3 w-3 fill-current text-blue mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                        </span> 
                        <span v-if="invalid" >
                            <svg class="h-4 w-4 fill-current text-red mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM11.4 10l2.83-2.83-1.41-1.41L10 8.59 7.17 5.76 5.76 7.17 8.59 10l-2.83 2.83 1.41 1.41L10 11.41l2.83 2.83 1.41-1.41L11.41 10z"/></svg>
                        </span> 
                </div>
                
            <div class="flex justify-end  py-1">
                <button 
                @click.prevent="reset()"
                class="bg-white border border-blue hover:text-blue-dark text-blue text-xs font-bold py-1 px-2 rounded-full mr-2">
                Cancel</button>
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
    </div>
</template>

<script>
    export default {
        props: ['align', 'width', 'id']
        ,
        data() {
            return { isOpen: false,
                    validEmails: [],
                    invalid: false,
                    valid: false,
                    form: {
                        email: ''
                     },
            }
        },
        watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if (! event.target.closest('.dropdown')) {
                    this.isOpen = false;
                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            },

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
                this.isOpen = false;
            },

            async getValidEmail() {
                    //to add friend
                    if (this.isOpen == false) {
                        this.isOpen = true;
                        const result = (await axios.get(`/getemails`)).data;
                        //result trả về là object, dùng Object.values() để chuyển các value thành array
                        this.validEmails = Object.values(result);
                    }
                    //viết trong if để chỉ fetch data từ server 1 lần
                    //tránh trường hợp click liên tục vào icon sẽ send req liên tục lên server
                
            },
            //Không để getValidEmail() trong created vì chỉ fetch dữ liệu 1 lần khi vào trang
            //trong khoảng tg đó data có thể thay đổi, làm data trong Vue sai lệch database
            //phải để function này trong button, mỗi khi click vào button sẽ fetch dữ liệu

        
        }
    }
    // lưu ý cách dùng event.target.closest('.dropdown')
</script>