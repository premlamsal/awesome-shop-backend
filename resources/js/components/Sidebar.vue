<template>
    <div
        class="sidebar"
        data-color="dark"
        data-active-color="dark"
        v-if="user != null"
    >
        <div class="logo">
            <a href="#" class="simple-text logo-mini">
                <div class="logo-image-small"></div>
            </a>
            <a href="/" class="simple-text logo-normal">
                BookBecha
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li>
                    <router-link to="/dashboard" aria-expanded="false">
                        <i class="nc-icon nc-bank"></i>
                        <span>Dashboard</span>
                        <sup></sup>
                    </router-link>
                </li>
                <li>
                    <router-link to="/customers" aria-expanded="false">
                        <i class="nc-icon nc-badge"></i>
                        <span>Customers</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/books" aria-expanded="false">
                        <i class="nc-icon nc-bag-16"></i>
                        <span>Books</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/transactions" aria-expanded="false">
                        <i class="nc-icon nc-paper"></i>
                        <span>Transactions</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/sliders" aria-expanded="false">
                        <i class="nc-icon nc-image"></i>
                        <span>Sliders</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/categories" aria-expanded="false">
                        <i class="nc-icon nc-bullet-list-67"></i>
                        <span>Categories</span>
                    </router-link>
                </li>

                <li>
                    <router-link to="/units" aria-expanded="false">
                        <i class="nc-icon nc-ruler-pencil"></i>
                        <span>Units</span>
                    </router-link>
                </li>

                <li>
                    <router-link to="/settings" aria-expanded="false">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <span>Settings</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    name: "SideBar",
    data() {
        return {
            user: ""
        };
    },
    watch: {
        $route: function() {
            this.getUser();
        }
    },
    created() {
        //this block will execute when component created
        this.getUser();
    },
    methods: {
        getUser() {
            this.user = JSON.parse(localStorage.getItem("admin_user"));
        }

        //end of methods block
    }
};
</script>
