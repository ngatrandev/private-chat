<template>
    <div class="mx-auto flex container shadow-md" >
        <div
        class="bg-blue border border-blue w-1/20">
            <div @click.prevent="chatClick" 
            :class="{'bg-blue-dark':buttonId==1}"
            class="flex relative justify-center px-1 py-3 hover:bg-blue-light">
               <svg class="h-6 w-6 fill-current text-white" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    width="30.743px" height="30.744px" viewBox="0 0 30.743 30.744" style="enable-background:new 0 0 30.743 30.744;"
                    xml:space="preserve">
                    <g>
                        <path d="M28.585,9.67h-0.842v9.255c0,1.441-0.839,2.744-2.521,2.744H8.743v0.44c0,1.274,1.449,2.56,2.937,2.56h12.599l4.82,2.834
                            L28.4,24.669h0.185c1.487,0,2.158-1.283,2.158-2.56V11.867C30.743,10.593,30.072,9.67,28.585,9.67z"/>
                        <path d="M22.762,3.24H3.622C1.938,3.24,0,4.736,0,6.178v11.6c0,1.328,1.642,2.287,3.217,2.435l-1.025,3.891L8.76,20.24h14.002
                            c1.684,0,3.238-1.021,3.238-2.462V8.393V6.178C26,4.736,24.445,3.24,22.762,3.24z M6.542,13.032c-0.955,0-1.729-0.774-1.729-1.729
                            s0.774-1.729,1.729-1.729c0.954,0,1.729,0.774,1.729,1.729S7.496,13.032,6.542,13.032z M13,13.032
                            c-0.955,0-1.729-0.774-1.729-1.729S12.045,9.574,13,9.574s1.729,0.774,1.729,1.729S13.955,13.032,13,13.032z M19.459,13.032
                            c-0.955,0-1.73-0.774-1.73-1.729s0.775-1.729,1.73-1.729c0.953,0,1.729,0.774,1.729,1.729S20.412,13.032,19.459,13.032z"/>
                    </g>
                </svg>

                <div 
                    v-show="btn1Alert"
                    class=" flex items-center feather feather-circle absolute z-10 pin-b pin-r mr-1 mb-1">
                    <svg class="h-4 w-4 fill-current text-red" 
                        version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
                            <path style="fill:#E50027;" d="M501.449,368.914L320.566,66.207C306.751,43.384,282.728,29.569,256,29.569
                                s-50.752,13.815-64.567,36.638L10.55,368.914c-13.812,23.725-14.113,51.954-0.599,75.678c13.513,23.723,37.836,37.838,65.165,37.838
                                h361.766c27.329,0,51.653-14.115,65.165-37.838C515.563,420.868,515.262,392.639,501.449,368.914z"/>
                            <path style="fill:#C1001F;" d="M502.049,444.592c-13.513,23.723-37.836,37.838-65.165,37.838H256V29.57
                                c26.727,0,50.752,13.815,64.567,36.638L501.45,368.915C515.262,392.639,515.563,420.868,502.049,444.592z"/>
                            <path style="fill:#FD003A;" d="M75.109,452.4c-16.628,0-30.851-8.27-39.063-22.669c-8.211-14.414-8.065-31.087,0.469-45.72
                                L217.23,81.549c8.27-13.666,22.816-21.951,38.769-21.951s30.5,8.284,38.887,22.157l180.745,302.49
                                c8.388,14.4,8.534,31.072,0.322,45.485c-8.211,14.4-22.435,22.669-39.063,22.669H75.109V452.4z"/>
                            <path style="fill:#E50027;" d="M436.891,452.4c16.628,0,30.851-8.27,39.063-22.669c8.211-14.414,8.065-31.087-0.322-45.485
                                L294.886,81.754c-8.388-13.871-22.933-22.157-38.887-22.157V452.4H436.891z"/>
                            <path style="fill:#E1E4FB;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03s-30.031-13.514-30.031-30.03V152.095
                                c0-16.517,13.514-30.031,30.031-30.031S286.03,135.578,286.03,152.095z"/>
                            <path style="fill:#C5C9F7;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03V122.064
                                C272.516,122.064,286.03,135.578,286.03,152.095z"/>
                            <path style="fill:#E1E4FB;" d="M256,332.278c-24.926,0-45.046,20.119-45.046,45.046c0,24.924,20.119,45.046,45.046,45.046
                                s45.046-20.121,45.046-45.046C301.046,352.398,280.925,332.278,256,332.278z"/>
                            <path style="fill:#C5C9F7;" d="M301.046,377.323c0,24.924-20.119,45.046-45.046,45.046v-90.091
                                C280.925,332.278,301.046,352.398,301.046,377.323z"/>
                    </svg>
                </div>
            </div>
            <div @click.prevent="contactClick"
            :class="{'bg-blue-dark':buttonId==2}"
            class="flex justify-center relative px-1 py-3 items-center hover:bg-blue-light">
                    <svg class="h-6 w-6 fill-current text-white" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="442px" height="442px" viewBox="0 0 442 442" style="enable-background:new 0 0 442 442;" xml:space="preserve">
                        <g>
                            <path d="M105.4,221c0,9.391-7.609,17-17,17h-34c-9.391,0-17-7.609-17-17l0,0c0-9.391,7.609-17,17-17h34
                                C97.792,204,105.4,211.609,105.4,221L105.4,221z M105.4,112.2c0-9.391-7.609-17-17-17h-34c-9.391,0-17,7.609-17,17l0,0
                                c0,9.391,7.609,17,17,17h34C97.792,129.2,105.4,121.591,105.4,112.2L105.4,112.2z M105.4,329.801c0-9.393-7.609-17-17-17h-34
                                c-9.391,0-17,7.607-17,17l0,0c0,9.391,7.609,17,17,17h34C97.792,346.801,105.4,339.191,105.4,329.801L105.4,329.801z M404.6,54.4
                                v333.2c0,30.043-24.357,54.4-54.398,54.4h-238c-30.042,0-54.4-24.357-54.4-54.4V360.4h30.6c16.871,0,30.6-13.73,30.6-30.6
                                c0-16.871-13.729-30.602-30.6-30.602H57.8v-47.6h30.6c16.871,0,30.6-13.729,30.6-30.6s-13.729-30.6-30.6-30.6H57.8v-47.6h30.6
                                c16.871,0,30.6-13.729,30.6-30.6c0-16.871-13.729-30.6-30.6-30.6H57.8V54.4c0-30.042,24.358-54.4,54.4-54.4h238
                                C380.242,0,404.6,24.357,404.6,54.4z M188.945,161.255c0,28.968,23.487,52.455,52.455,52.455c28.969,0,52.455-23.487,52.455-52.455
                                c0-28.968-23.486-52.456-52.455-52.456C212.433,108.8,188.945,132.287,188.945,161.255z M323,289.482
                                c0-32.184-26.098-58.283-58.283-58.283H218.09c-32.191,0-58.29,26.1-58.29,58.283v23.318H323V289.482z"/>
                        </g>
                    </svg>

                    <div 
                    v-show="btn2Alert"
                    class=" flex items-center feather feather-circle absolute z-10 pin-b pin-r mr-1 mb-1">
                        <svg class="h-4 w-4 fill-current text-red" 
                            version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
                                <path style="fill:#E50027;" d="M501.449,368.914L320.566,66.207C306.751,43.384,282.728,29.569,256,29.569
                                    s-50.752,13.815-64.567,36.638L10.55,368.914c-13.812,23.725-14.113,51.954-0.599,75.678c13.513,23.723,37.836,37.838,65.165,37.838
                                    h361.766c27.329,0,51.653-14.115,65.165-37.838C515.563,420.868,515.262,392.639,501.449,368.914z"/>
                                <path style="fill:#C1001F;" d="M502.049,444.592c-13.513,23.723-37.836,37.838-65.165,37.838H256V29.57
                                    c26.727,0,50.752,13.815,64.567,36.638L501.45,368.915C515.262,392.639,515.563,420.868,502.049,444.592z"/>
                                <path style="fill:#FD003A;" d="M75.109,452.4c-16.628,0-30.851-8.27-39.063-22.669c-8.211-14.414-8.065-31.087,0.469-45.72
                                    L217.23,81.549c8.27-13.666,22.816-21.951,38.769-21.951s30.5,8.284,38.887,22.157l180.745,302.49
                                    c8.388,14.4,8.534,31.072,0.322,45.485c-8.211,14.4-22.435,22.669-39.063,22.669H75.109V452.4z"/>
                                <path style="fill:#E50027;" d="M436.891,452.4c16.628,0,30.851-8.27,39.063-22.669c8.211-14.414,8.065-31.087-0.322-45.485
                                    L294.886,81.754c-8.388-13.871-22.933-22.157-38.887-22.157V452.4H436.891z"/>
                                <path style="fill:#E1E4FB;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03s-30.031-13.514-30.031-30.03V152.095
                                    c0-16.517,13.514-30.031,30.031-30.031S286.03,135.578,286.03,152.095z"/>
                                <path style="fill:#C5C9F7;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03V122.064
                                    C272.516,122.064,286.03,135.578,286.03,152.095z"/>
                                <path style="fill:#E1E4FB;" d="M256,332.278c-24.926,0-45.046,20.119-45.046,45.046c0,24.924,20.119,45.046,45.046,45.046
                                    s45.046-20.121,45.046-45.046C301.046,352.398,280.925,332.278,256,332.278z"/>
                                <path style="fill:#C5C9F7;" d="M301.046,377.323c0,24.924-20.119,45.046-45.046,45.046v-90.091
                                    C280.925,332.278,301.046,352.398,301.046,377.323z"/>
                        </svg>
                    </div>

            </div>
            <div  @click.prevent="teamClick"
            :class="{'bg-blue-dark':buttonId==3}"
            class="flex relative justify-center px-1 py-3 items-center hover:bg-blue-light">
                <svg class="h-6 w-6 fill-current text-white"  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    width="80.13px" height="80.13px" viewBox="0 0 80.13 80.13" style="enable-background:new 0 0 80.13 80.13;" xml:space="preserve"
                    >
                        <g>
                            <path d="M48.355,17.922c3.705,2.323,6.303,6.254,6.776,10.817c1.511,0.706,3.188,1.112,4.966,1.112
                                c6.491,0,11.752-5.261,11.752-11.751c0-6.491-5.261-11.752-11.752-11.752C53.668,6.35,48.453,11.517,48.355,17.922z M40.656,41.984
                                c6.491,0,11.752-5.262,11.752-11.752s-5.262-11.751-11.752-11.751c-6.49,0-11.754,5.262-11.754,11.752S34.166,41.984,40.656,41.984
                                z M45.641,42.785h-9.972c-8.297,0-15.047,6.751-15.047,15.048v12.195l0.031,0.191l0.84,0.263
                                c7.918,2.474,14.797,3.299,20.459,3.299c11.059,0,17.469-3.153,17.864-3.354l0.785-0.397h0.084V57.833
                                C60.688,49.536,53.938,42.785,45.641,42.785z M65.084,30.653h-9.895c-0.107,3.959-1.797,7.524-4.47,10.088
                                c7.375,2.193,12.771,9.032,12.771,17.11v3.758c9.77-0.358,15.4-3.127,15.771-3.313l0.785-0.398h0.084V45.699
                                C80.13,37.403,73.38,30.653,65.084,30.653z M20.035,29.853c2.299,0,4.438-0.671,6.25-1.814c0.576-3.757,2.59-7.04,5.467-9.276
                                c0.012-0.22,0.033-0.438,0.033-0.66c0-6.491-5.262-11.752-11.75-11.752c-6.492,0-11.752,5.261-11.752,11.752
                                C8.283,24.591,13.543,29.853,20.035,29.853z M30.589,40.741c-2.66-2.551-4.344-6.097-4.467-10.032
                                c-0.367-0.027-0.73-0.056-1.104-0.056h-9.971C6.75,30.653,0,37.403,0,45.699v12.197l0.031,0.188l0.84,0.265
                                c6.352,1.983,12.021,2.897,16.945,3.185v-3.683C17.818,49.773,23.212,42.936,30.589,40.741z"/>
                        </g>
                </svg>
                <div 
                    v-show="btn3Alert"
                    class=" flex items-center feather feather-circle absolute z-10 pin-b pin-r mr-1 mb-1">
                        <svg class="h-4 w-4 fill-current text-red" 
                            version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
                                <path style="fill:#E50027;" d="M501.449,368.914L320.566,66.207C306.751,43.384,282.728,29.569,256,29.569
                                    s-50.752,13.815-64.567,36.638L10.55,368.914c-13.812,23.725-14.113,51.954-0.599,75.678c13.513,23.723,37.836,37.838,65.165,37.838
                                    h361.766c27.329,0,51.653-14.115,65.165-37.838C515.563,420.868,515.262,392.639,501.449,368.914z"/>
                                <path style="fill:#C1001F;" d="M502.049,444.592c-13.513,23.723-37.836,37.838-65.165,37.838H256V29.57
                                    c26.727,0,50.752,13.815,64.567,36.638L501.45,368.915C515.262,392.639,515.563,420.868,502.049,444.592z"/>
                                <path style="fill:#FD003A;" d="M75.109,452.4c-16.628,0-30.851-8.27-39.063-22.669c-8.211-14.414-8.065-31.087,0.469-45.72
                                    L217.23,81.549c8.27-13.666,22.816-21.951,38.769-21.951s30.5,8.284,38.887,22.157l180.745,302.49
                                    c8.388,14.4,8.534,31.072,0.322,45.485c-8.211,14.4-22.435,22.669-39.063,22.669H75.109V452.4z"/>
                                <path style="fill:#E50027;" d="M436.891,452.4c16.628,0,30.851-8.27,39.063-22.669c8.211-14.414,8.065-31.087-0.322-45.485
                                    L294.886,81.754c-8.388-13.871-22.933-22.157-38.887-22.157V452.4H436.891z"/>
                                <path style="fill:#E1E4FB;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03s-30.031-13.514-30.031-30.03V152.095
                                    c0-16.517,13.514-30.031,30.031-30.031S286.03,135.578,286.03,152.095z"/>
                                <path style="fill:#C5C9F7;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03V122.064
                                    C272.516,122.064,286.03,135.578,286.03,152.095z"/>
                                <path style="fill:#E1E4FB;" d="M256,332.278c-24.926,0-45.046,20.119-45.046,45.046c0,24.924,20.119,45.046,45.046,45.046
                                    s45.046-20.121,45.046-45.046C301.046,352.398,280.925,332.278,256,332.278z"/>
                                <path style="fill:#C5C9F7;" d="M301.046,377.323c0,24.924-20.119,45.046-45.046,45.046v-90.091
                                    C280.925,332.278,301.046,352.398,301.046,377.323z"/>
                        </svg>
                    </div>
                
            </div>
            <div 
            @click.prevent="notifyClick"
            :class="{'bg-blue-dark':buttonId==4}"
            class="flex relative justify-center px-1 py-3 items-center hover:bg-blue-light">
                <svg class="h-6 w-6 fill-current text-white" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 456.727 456.727" style="enable-background:new 0 0 456.727 456.727;" xml:space="preserve">
                        <g>
                            <path d="M415.863,315.864l-30-30v-80.366c0-76.725-54.865-140.625-127.5-154.634v-20c0-16.542-13.458-30-30-30s-30,13.458-30,30v20
                                c-72.635,14.01-127.5,77.909-127.5,154.634l0,80.366l-30,30v40h-30v30h30h375h30v-30h-30V315.864z"/>
                            <path d="M228.363,455.863c27.922,0,52.019-16.353,63.255-40H165.109C176.344,439.51,200.441,455.863,228.363,455.863z"/>
                            <path d="M427.262,167.464l29.465-5.638c-6.407-33.488-20.473-65.803-40.674-93.451c-20.075-27.474-46.39-50.603-76.099-66.884
                                L325.536,27.8C378.784,56.981,415.861,107.887,427.262,167.464z"/>
                            <path d="M131.19,27.8L116.772,1.491c-29.709,16.282-56.023,39.41-76.099,66.884C20.473,96.024,6.407,128.338,0,161.827
                                l29.465,5.638C40.865,107.887,77.942,56.981,131.19,27.8z"/>
                        </g>
                </svg>
                <div 
                v-show="notifyCount > 0"
                class=" flex items-center feather feather-circle absolute z-10 text-xs text-red font-bold font-sans"
                >{{notifyCount}}</div>
                 <div 
                    v-show="notifyCount > 0"
                    class=" flex items-center feather feather-circle absolute z-10 pin-b pin-r mr-1 mb-1">
                        <svg class="h-4 w-4 fill-current text-red" 
                            version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
                                <path style="fill:#E50027;" d="M501.449,368.914L320.566,66.207C306.751,43.384,282.728,29.569,256,29.569
                                    s-50.752,13.815-64.567,36.638L10.55,368.914c-13.812,23.725-14.113,51.954-0.599,75.678c13.513,23.723,37.836,37.838,65.165,37.838
                                    h361.766c27.329,0,51.653-14.115,65.165-37.838C515.563,420.868,515.262,392.639,501.449,368.914z"/>
                                <path style="fill:#C1001F;" d="M502.049,444.592c-13.513,23.723-37.836,37.838-65.165,37.838H256V29.57
                                    c26.727,0,50.752,13.815,64.567,36.638L501.45,368.915C515.262,392.639,515.563,420.868,502.049,444.592z"/>
                                <path style="fill:#FD003A;" d="M75.109,452.4c-16.628,0-30.851-8.27-39.063-22.669c-8.211-14.414-8.065-31.087,0.469-45.72
                                    L217.23,81.549c8.27-13.666,22.816-21.951,38.769-21.951s30.5,8.284,38.887,22.157l180.745,302.49
                                    c8.388,14.4,8.534,31.072,0.322,45.485c-8.211,14.4-22.435,22.669-39.063,22.669H75.109V452.4z"/>
                                <path style="fill:#E50027;" d="M436.891,452.4c16.628,0,30.851-8.27,39.063-22.669c8.211-14.414,8.065-31.087-0.322-45.485
                                    L294.886,81.754c-8.388-13.871-22.933-22.157-38.887-22.157V452.4H436.891z"/>
                                <path style="fill:#E1E4FB;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03s-30.031-13.514-30.031-30.03V152.095
                                    c0-16.517,13.514-30.031,30.031-30.031S286.03,135.578,286.03,152.095z"/>
                                <path style="fill:#C5C9F7;" d="M286.03,152.095v120.122c0,16.517-13.514,30.03-30.03,30.03V122.064
                                    C272.516,122.064,286.03,135.578,286.03,152.095z"/>
                                <path style="fill:#E1E4FB;" d="M256,332.278c-24.926,0-45.046,20.119-45.046,45.046c0,24.924,20.119,45.046,45.046,45.046
                                    s45.046-20.121,45.046-45.046C301.046,352.398,280.925,332.278,256,332.278z"/>
                                <path style="fill:#C5C9F7;" d="M301.046,377.323c0,24.924-20.119,45.046-45.046,45.046v-90.091
                                    C280.925,332.278,301.046,352.398,301.046,377.323z"/>
                        </svg>
                </div>
            </div>
            
        </div>
        <chat-component
        v-show="buttonId == 1"
        :click="chatClickCount"
        :id="id"
        ></chat-component>

        <contact-component
        v-show="buttonId == 2"
        :id="id"
        :invites="inviteForm"
        ></contact-component>

        <team-component
        v-show="buttonId == 3"
        :id="id"
        :click="teamClickCount"
        :active="buttonId==3"
        ></team-component>

        <notify-component
        v-show="buttonId == 4"
        :notifications="notifications"
         ></notify-component>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data () {
        return {
            buttonId: 1,
            chatClickCount:0,
            teamClickCount:0,
            notifyCount:0,
            notifications: '',
            inviteForm: '',
            btn1Alert: false,
            btn2Alert: false,
            btn3Alert: false,
            
        }
    },
    methods: {
        chatClick() {
            this.buttonId = 1;
            this.chatClickCount++;
            this.btn1Alert = false;
           
        },

        contactClick() {
            this.buttonId = 2;
            this.getInvites();
            this.btn2Alert = false;
           
        },

        teamClick() {
            this.buttonId = 3;
            this.teamClickCount++;
            this.btn3Alert = false;
           
        },

        notifyClick() {
            this.buttonId = 4;
            this.notifyCount=0;
            this.getNotification();
            
        },

        async getInvites() {
              this.inviteForm =(await axios.get('/getinvites')).data.data;
                
        },

        async getNotifyCount() {
            this.notifyCount = (await axios.post(`user/${this.id}/count`)).data;
         },

        async getNotification() {
            this.notifications = (await axios.post(`user/${this.id}/notifications`)).data.data;
            await axios.post(`user/${this.id}/update`);
         }
    },

    created() {
        this.getNotifyCount();
        Echo.private('invite.'+this.id)
           .listen('InviteEvent', ()=>{
            this.btn2Alert = true;   
            //this.id không đổi cả quá trình nên có thể viết listen tại đây   
           });

        Echo.private('accept.'+this.id)
           .listen('AcceptEvent', ()=>{
               this.btn1Alert = true;   
               
           });

        Echo.private('notification')
           .listen('GroupCreateEvent', (e)=>{
               
               if (this.id == e.id) {
                   this.btn1Alert = true;  
                   this.btn3Alert = true;  
               }
           })
           .listen('NotificationEvent', (e)=>{
               
               if (this.id == e.id) {
                   this.notifyCount++;
               }
           });
    }

}
</script>