<template>
    <div></div>
</template>
<script>
export default {
    data() {
        return {};
    },
    created() {
        this.logout();
    },
    watch: {
        $route: function() {
            this.logout();
        }
    },
    methods: {
        logout() {
            // this.$http.post('logout',localStorage.getItem('admin_user'))
            // .then((response)=>{
            //    if(response.status===200){
            //     localStorage.removeItem("admin_token");
            //     localStorage.removeItem("admin_user");
            //     delete this.$http.defaults.headers.common["Authorization"];
            //     this.$router.push({ name: 'Login'})
            //    }
            // })
            // .catch((error)=>{
            //     console.log(error.response);
            //       localStorage.removeItem("admin_token");
            //     localStorage.removeItem("admin_user");
            //     delete this.$http.defaults.headers.common["Authorization"];
            //     this.$router.push({ name: 'Login'})
            // });

            localStorage.removeItem("admin_token");
            localStorage.removeItem("admin_user");
            delete this.$http.defaults.headers.common["Authorization"];
            this.$router.push({ name: "Login" });
        }
    }
};
</script>
