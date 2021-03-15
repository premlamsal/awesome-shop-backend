<template>
    <div>
   <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3>Settings</h3>
            </div>

            <div class="card-body">
               <form style="width:25em">
                     <div class="form-group">
                        
                        <input type="hidden" v-model="settings.id" />
                        <label for="Heading">Application Name</label>
                        <input
                            type="text"
                            :class="['form-control']"
                            v-model="settings.app_name"
                        />
                        <span v-if="errors.app_name" :class="['errorText']">{{
                            errors.app_name[0]
                        }}</span>
                    </div>



                     <div class="form-group">
                        <label for="About">About</label>
                        <textarea
                            type="text"
                            :class="['form-control']"
                            v-model="settings.about"
                        ></textarea>
                        <span
                            v-if="errors.about"
                            :class="['errorText']"
                            >{{ errors.about[0] }}</span
                        >
                    </div>

                    
                     <div class="form-group">
                        <label for="Footer">Footer</label>
                        <textarea
                            type="text"
                            :class="['form-control']"
                            v-model="settings.footer"
                        ></textarea>
                        <span
                            v-if="errors.footer"
                            :class="['errorText']"
                            >{{ errors.footer[0] }}</span
                        >
                    </div>





            
                </form>

            
            
            
            </div>
    </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            pagination: {},
            settings:{
                id:'',
                app_name:'',
                about:'',
                footer:'',
            }
        };
    },
    created() {
        //this block will execute when component created
    },

    methods: {}
};
</script>
