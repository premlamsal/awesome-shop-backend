<template>
    <div>
        <p class="mb-4">
            <b-button
                id="show-btn"
                @click="showAddModal"
                class="btn btn-success"
                style="margin-top: 8px;"
            >
                <span class="fa fa-plus-circle"></span> Add Category</b-button
            >
        </p>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3>Categories</h3>
            </div>

            <!-- add category model start -->
            <b-modal id="bv-modal-add-category" hide-footer>
                <template v-slot:modal-title>
                    {{ modalForName }}
                </template>
                <div class="d-block">
                    <div class="form-group">
                        <label for="Category">Name</label>
                        <input type="hidden" v-model="category.id" />
                        <input
                            type="text"
                            :class="['form-control']"
                            v-model="category.name"
                        />
                        <span v-if="errors.name" :class="['errorText']">{{
                            errors.name[0]
                        }}</span>
                    </div>
                    <div class="form-group">
                        <label for="Category">Parent Category:</label>
                        <template>
                            <select
                                class="form-control"
                                v-model="category.parent_id"
                            >
                                <option selected="" value=""
                                    >Select the parent Category</option
                                >
                                <option
                                    v-for="category in categories"
                                    :value="category.id"
                                    >{{ category.name }}</option
                                >
                            </select>
                            <span
                                v-if="errors.parent_id"
                                :class="['errorText']"
                                >{{ errors.parent_id[0] }}</span
                            >
                        </template>
                    </div>
                </div>
                <b-button class="btn-primary mt-3" block @click="callFunc">{{
                    modalForName
                }}</b-button>
            </b-modal>
            <!-- add unit modal end-->

            <div class="card-body" v-if="categories.length > 0">
                <div class="table">
                    <Category v-bind:categories="categories" />
                </div>
            </div>
            <div class="errorDivEmptyData" v-else>
                No Data Found
            </div>
        </div>
    </div>
</template>

<script>
import Category from "../components/Category";

export default {
    components: {
        Category
    },
    data() {
        return {
            errors: [],
            pagination: {},
            isLoading: "",

            uploadedFile: null,
            modalForName: "",
            modalForCode: 0,
            errors: [],
            categories: [],
            category: {
                name: "",
                parent_id: ""
            }
        };
    },
    created() {
        //this block will execute when component created

        this.getCategories();
    },

    methods: {
        onFileChange(event) {
            this.uploadedFile = event.target.files[0];
        },
        clearCategoryFileds() {
            this.category.id = "";
            this.category.name = "";
            this.category.parent_id = "";
        },
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
        showAddModal() {
            this.clearCategoryFileds();
            this.modalForName = "Add Category";
            this.modalForCode = 0; //0 for add

            this.errors = ""; //clearing errors
            this.$bvModal.show("bv-modal-add-category");
        },
        callFunc() {
            if (this.modalForCode == 0) {
                this.addCategory();
            } else if (this.modalForCode == 1) {
                this.updateCategory();
            }
        },
        addCategory() {
            let formData = new FormData();
            formData.append("name", this.category.name);
            formData.append("parent_id", this.category.parent_id);

            this.$http
                .post("category", formData)
                .then(response => {
                    this.$swal(
                        "Info",
                        response.data.message,
                        response.data.status
                    );
                    this.$bvModal.hide("bv-modal-add-category");
                    this.getCategories();
                    this.clearCategoryFileds();
                })
                .catch(error => {
                    console.log(error.response);
                });
        },
        deleteCategory(id) {
            this.$swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.value) {
                    this.$http
                        .delete("/category/" + id)
                        .then(response => {
                            this.$swal(
                                "Info",
                                response.data.message,
                                response.data.status
                            );
                            this.getCategories();
                        })
                        .catch(error => {
                            console.log(error.response);
                        });
                }
            });
        },
        editCategory(id) {
            this.modalForName = "Edit Category";
            this.modalForCode = 1; // 1 for Edit
            this.$bvModal.show("bv-modal-add-category");

            this.$http
                .get("category/" + id)
                .then(response => {
                    this.category = response.data.data[0];
                })
                .catch(error => {
                    console.log(error.response);
                });
        },
        updateCategory() {
            let formData = new FormData();
            formData.append("heading", this.category.heading);
            formData.append("link", this.category.link);
            formData.append("description", this.category.description);
            formData.append("file", this.uploadedFile);
            formData.append("id", this.category.id);
            formData.append("_method", "PUT");

            this.$http
                .post("category", formData)
                .then(response => {
                    this.get();
                    this.$swal(
                        "Info",
                        response.data.message,
                        response.data.status
                    );
                    this.$bvModal.hide("bv-modal-add-category");
                    this.clearCategoryFileds();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getCategories() {
            this.$http
                .get("categories")
                .then(response => {
                    this.categories = response.data.data;
                    if (this.categories.length != null) {
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
