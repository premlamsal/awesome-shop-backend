<template>
    <div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i
                                        class="nc-icon nc-badge text-warning"
                                    ></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Customers</p>
                                    <p class="card-title">
                                        {{ dashboard_info.customers }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr />
                        <div class="stats">
                            <i class="fa fa-refresh" @click="getDashInfo()"></i>
                            <span @click="push('Customers')">See all</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i
                                        class="nc-icon nc-bag-16 text-success"
                                    ></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Books</p>
                                    <p class="card-title">
                                        {{ dashboard_info.books }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr />
                        <div class="stats">
                            <i class="fa fa-refresh" @click="getDashInfo()"></i>
                            <span @click="push('Books')">See all</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-primary">
                                    <i
                                        class="nc-icon nc-paper text-primary"
                                    ></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Transactions</p>
                                    <p class="card-title">
                                        {{ dashboard_info.transactions }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr />
                        <div class="stats">
                            <i class="fa fa-refresh" @click="getDashInfo()"></i>
                            <span @click="push('Transactions')">See all</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-globe text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Balance</p>
                                    <p class="card-title">
                                        Rs. {{ dashboard_info.balance }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr />
                        <div class="stats">
                            <i class="fa fa-refresh" @click="getDashInfo()"></i>
                            <span @click="push('balance')">See all</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.stats {
    cursor: pointer;
}
</style>
<script>
export default {
    data() {
        return {
            dashboard_info: {
                customers: 0,
                books: 0,
                balance: 0,
                transactions: 0
            }
        };
    },
    created() {
        this.getDashInfo();
    },
    methods: {
        push(task) {
            this.$router.push({ name: task });
        },
        getDashInfo() {
            this.$http
                .get("/dashboard/info")
                .then(response => {
                    this.dashboard_info = response.data;
                })
                .catch(error => {
                    console.log(response.data);
                });
        }
    }
};
</script>
