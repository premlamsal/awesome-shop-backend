<template>
    <div>
        <div class="login-box">
            <div class="form-panel">
                <h4>Login</h4>
                <div>
                    <div class="login-form">
                        <label>Email:</label>
                        <b-form-input
                            v-model="email"
                            type="email"
                            placeholder="Enter your name"
                        ></b-form-input>

                        <label>Password:</label>
                        <b-form-input
                            v-model="password"
                            placeholder="Enter your password"
                            type="password"
                        ></b-form-input>
                        <p class="error-msg">{{ error_msg }}</p>
                        <button
                            class="mt-4 btn btn-danger"
                            style="width:100%"
                            @click="login()"
                        >
                            Login
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.form-panel {
    background: #fff;
    width: 20em;
    height: 20em;
    border-radius: 12px;
    box-shadow: 1px 2px 8px -2px;
}
.form-panel h4 {
    background: #e3342f;
    color: #fff;
    padding: 10px;
}
.login-form {
    padding: 10px;
}
.login-box {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 8em;
}
.error-msg {
    color: red;
}
</style>

<script>
export default {
    computed: {
        nameState() {}
    },
    data() {
        return {
            email: "",
            password: "",
            error_msg: ""
        };
    },
    methods: {
        login() {
            if(this.email !=="" && this.password !=""){
                  let formData = new FormData();
            formData.append("email", this.email);
            formData.append("password", this.password);
            this.$http
                .post("login", formData)
                .then(response => {
                    if (response.data.access_token != null) {
                        localStorage.setItem(
                            "admin_token",
                            response.data.access_token
                        );
                        localStorage.setItem(
                            "admin_user",
                            JSON.stringify(response.data.user)
                        );

                        this.$http.defaults.headers.common = {
                            Authorization: `Bearer ${localStorage.getItem(
                                "admin_token"
                            )}`
                        };
                        this.$router.push({ name: "Dashboard" });
                    }
                    this.error_msg = response.data.msg;
                })
                .catch(error => {
                    console.log(error.response);
                });
            }
          
        }
    }
};
</script>
