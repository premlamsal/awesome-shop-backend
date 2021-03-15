<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3>Books</h3>
            </div>
            <div class="card-body" v-if="books.length > 0">
                <div class="table">
                    <table
                        class="table table-striped table-bordered"
                        width="100%"
                        cellspacing="0"
                    >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="book in books" :key="book.id">
                                <td>{{ book.name }}</td>
                                <td>{{ book.category.name }}</td>
                                <td>{{ book.unit.short_name }}</td>
                                <td>Rs. {{ book.price }}</td>
                                <td>{{ book.quantity }}</td>
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
            books: {},
            errors: [],
            pagination: {}
        };
    },
    created() {
        //this block will execute when component created

        this.getBooks();
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
        getBooks() {
            this.$http
                .get("books")
                .then(response => {
                    this.books = response.data.data;
                    if (this.books.length != null) {
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
