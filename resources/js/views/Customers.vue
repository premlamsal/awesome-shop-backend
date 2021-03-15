<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3>Customers</h3>
            </div>
            <div class="card-body" v-if="customers.length > 0">
                <div class="table">
                    <table
                        class="table table-striped table-bordered"
                        width="100%"
                        cellspacing="0"
                    >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Balance</th>
                                <th>WithDrawRequest?</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="customer in customers"
                                :key="customer.id"
                            >
                                <td>
                                    {{ customer.firstname }}
                                    {{ customer.lastname }}
                                </td>
                                <td>{{ customer.email }}</td>
                                <td>{{ customer.user_type }}</td>
                                <td>Rs. {{ customer.balance }}</td>
                                <td v-if="customer.withDrawRequest != 0">
                                    Yes
                                </td>
                                <td v-else>No</td>
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
            customers: {},
            errors: [],
            pagination: {},

            isLoading: ""
        };
    },
    created() {
        //this block will execute when component created

        this.getCustomers();
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
        getCustomers() {
            this.$http
                .get("users")
                .then(response => {
                    this.customers = response.data.data;
                    if (this.customers.length != null) {
                        this.makePagination(
                            response.data.meta,
                            response.data.links
                        );
                    }
                    this.isLoading = "";
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }

        //end of methods block
    }
};
</script>
