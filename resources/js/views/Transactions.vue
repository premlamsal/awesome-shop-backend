<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3>Transactions</h3>
            </div>
            <div class="card-body" v-if="transactions.length > 0">
                <div class="table">
                    <table
                        class="table table-striped table-bordered"
                        width="100%"
                        cellspacing="0"
                    >
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Amount</th>
                                <th>Ref ID</th>
                                <th>User</th>
                                <th>Transcation ID</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="transaction in transactions"
                                :key="transaction.id"
                            >
                                <td>{{ transaction.action }}</td>
                                <td>{{ transaction.amount }}</td>
                                <td>{{ transaction.ref_id }}</td>

                                <td>
                                    {{ transaction.user.firstname }}
                                    {{ transaction.user.lastname }}
                                </td>
                                <td>{{ transaction.custom_transaction_id }}</td>
                                <td>{{ transaction.method }}</td>
                                <td v-if="transaction.status != 'pending'">
                                    <span
                                        class="badge badge-success"
                                        style="padding:5px"
                                        >{{ transaction.status }}</span
                                    >
                                </td>
                                <td v-else>
                                    <span
                                        class="badge badge-danger"
                                        style="padding:5px"
                                        >{{ transaction.status }}</span
                                    >
                                </td>
                                <td>
                                    <button
                                        class="btn btn-warning"
                                        @click="
                                            transactionDetail(transaction.id)
                                        "
                                    >
                                        <i
                                            class="nc-icon nc-bullet-list-67"
                                        ></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <ul class="pagination">
                            <li
                                class="page-item"
                                v-bind:class="{
                                    disabled: !pagination.first_link
                                }"
                            >
                                <button
                                    @click="fetchUnits(pagination.first_link)"
                                    class="page-link"
                                >
                                    First
                                </button>
                            </li>
                            <li
                                class="page-item"
                                v-bind:class="{
                                    disabled: !pagination.prev_link
                                }"
                            >
                                <button
                                    @click="fetchUnits(pagination.prev_link)"
                                    class="page-link"
                                >
                                    Previous
                                </button>
                            </li>
                            <li
                                v-for="n in pagination.last_page"
                                v-bind:key="n"
                                class="page-item"
                                v-bind:class="{
                                    active: pagination.current_page == n
                                }"
                            >
                                <button
                                    @click="
                                        fetchUnits(pagination.path_page + n)
                                    "
                                    class="page-link"
                                >
                                    {{ n }}
                                </button>
                            </li>
                            <li
                                class="page-item"
                                v-bind:class="{
                                    disabled: !pagination.next_link
                                }"
                            >
                                <button
                                    @click="fetchUnits(pagination.next_link)"
                                    class="page-link"
                                >
                                    Next
                                </button>
                            </li>
                            <li
                                class="page-item"
                                v-bind:class="{
                                    disabled: !pagination.last_link
                                }"
                            >
                                <button
                                    @click="fetchUnits(pagination.last_link)"
                                    class="page-link"
                                >
                                    Last
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        Page: {{ pagination.current_page }}-{{
                            pagination.last_page
                        }}
                        Total Records: {{ pagination.total_pages }}
                    </div>
                </div>
            </div>

            <div class="errorDivEmptyData" v-else>
                No Data Found
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            transactions: {},
            errors: [],
            pagination: {},
            isLoading: ""
        };
    },
    created() {
        //this block will execute when component created

        this.getTransactions();
    },

    methods: {
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                from_page: meta.from,
                to_page: meta.to,
                total_pages: meta.total,
                path_page: meta.path + "?page=",
                first_link: links.first,
                last_link: links.last,
                prev_link: links.prev,
                next_link: links.next
            };
            this.pagination = pagination;
        },
        transactionDetail(id) {
            this.$router.push({
                name: "TransactionsDetail",
                params: { transaction_id: id }
            });
        },
        getTransactions() {
            this.$http
                .get("transactions")
                .then(response => {
                    this.transactions = response.data.data;
                    if (this.transactions.length != null) {
                        this.makePagination(
                            response.data.meta,
                            response.data.links
                        );
                    }
                    this.isLoading = "";
                })
                .catch(error => {
                    console.log(error);
                });
        }

        //end of methods block
    }
};
</script>
