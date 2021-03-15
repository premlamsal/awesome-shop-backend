<template>
    <div>
        <p class="mb-4">
            <b-button
                id="show-btn"
                @click="showAddModal"
                class="btn btn-success"
                style="margin-top: 8px;"
            >
                <span class="fa fa-plus-circle"></span> Add Slider</b-button
            >
        </p>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3>Sliders</h3>
            </div>

            <!-- add slider model start -->
            <b-modal id="bv-modal-add-slider" hide-footer>
                <template v-slot:modal-title>
                    {{ modalForName }}
                </template>
                <div class="d-block">
                    <div class="form-group">
                        <label for="Heading">Heading</label>
                        <input type="hidden" v-model="slider.id" />
                        <input
                            type="text"
                            :class="['form-control']"
                            v-model="slider.heading"
                        />
                        <span v-if="errors.heading" :class="['errorText']">{{
                            errors.heading[0]
                        }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Link">Link</label>
                        <input type="hidden" v-model="slider.link" />
                        <input
                            type="text"
                            :class="['form-control']"
                            v-model="slider.link"
                        />
                        <span v-if="errors.link" :class="['errorText']">{{
                            errors.link[0]
                        }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Link">Slider Image</label>
                        <input type="file" id="file" @change="onFileChange" />
                        <br />
                        <img
                            src="/img/upload_image.png"
                            class="img img-responsive"
                            width="80px"
                        />
                        <span v-if="errors.file" :class="['errorText']">{{
                            errors.file[0]
                        }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Description">Description</label>
                        <input type="hidden" v-model="slider.description" />
                        <textarea
                            type="text"
                            :class="['form-control']"
                            v-model="slider.description"
                        ></textarea>
                        <span
                            v-if="errors.description"
                            :class="['errorText']"
                            >{{ errors.description[0] }}</span
                        >
                    </div>
                </div>
                <b-button class="btn-primary mt-3" block @click="callFunc">{{
                    modalForName
                }}</b-button>
            </b-modal>
            <!-- add unit modal end-->
            <div class="card-body" v-if="sliders.length > 0">
                <div class="table">
                    <table
                        class="table table-striped table-bordered"
                        width="100%"
                        cellspacing="0"
                    >
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Heading</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="slider in sliders" :key="slider.id">
                                <td>
                                    <img
                                        :src="slider.image"
                                        class="img img-responsive"
                                        width="80px"
                                    />
                                </td>
                                <td>{{ slider.heading }}</td>
                                <td>{{ slider.description }}</td>
                                <td>{{ slider.link }}</td>
                                <td>
                                    {{ slider.user.firstname }}
                                    {{ slider.user.lastname }}
                                </td>
                                <td>
                                    <button
                                        class="btn btn-primary"
                                        style="margin-right:5px;"
                                        @click="editSlider(slider.id)"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="btn btn-danger"
                                        @click="deleteSlider(slider.id)"
                                    >
                                        Delete
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
            isLoading: "",
            errors: [],
            pagination: {},
            uploadedFile: null,
            modalForName: "",
            modalForCode: 0,
            errors: [],
            sliders: {},
            slider: {
                id: "",
                image: "",
                heading: "",
                description: "",
                link: "",
                thumb: "",
                user: {
                    id: "",
                    firstname: "",
                    lastname: ""
                }
            }
        };
    },
    created() {
        //this block will execute when component created

        this.getSliders();
    },

    methods: {
        onFileChange(event) {
            this.uploadedFile = event.target.files[0];
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
        clearSliderFileds() {
            this.slider.image = "";
            this.slider.heading = "";
            this.slider.description = "";
            this.slider.link = "";
            this.slider.thumb = "";
            this.slider.user = Array();
            this.uploadedFile = null;
        },
        showAddModal() {
            this.clearSliderFileds();
            this.modalForName = "Add Slider";
            this.modalForCode = 0; //0 for add

            this.errors = ""; //clearing errors
            this.$bvModal.show("bv-modal-add-slider");
        },
        callFunc() {
            if (this.modalForCode == 0) {
                this.addSlider();
            } else if (this.modalForCode == 1) {
                this.updateSlider();
            }
        },
        addSlider() {
            let formData = new FormData();
            formData.append("heading", this.slider.heading);
            formData.append("link", this.slider.link);
            formData.append("description", this.slider.description);
            formData.append("file", this.uploadedFile);

            this.$http
                .post("slider", formData)
                .then(response => {
                    this.getSliders();
                    this.$swal(
                        "Info",
                        response.data.message,
                        response.data.status
                    );
                    this.$bvModal.hide("bv-modal-add-slider");
                    this.clearSliderFileds();
                })
                .catch(error => {
                    console.log(error.response);
                });
        },
        deleteSlider(id) {
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
                        .delete("/slider/" + id)
                        .then(response => {
                            this.$swal(
                                "Info",
                                response.data.message,
                                response.data.status
                            );
                            this.getSliders();
                        })
                        .catch(error => {
                            console.log(error.response);
                        });
                }
            });
        },
        editSlider(id) {
            this.modalForName = "Edit Slider";
            this.modalForCode = 1; // 1 for Edit
            this.$bvModal.show("bv-modal-add-slider");

            this.$http
                .get("slider/" + id)
                .then(response => {
                    this.slider = response.data.data[0];
                })
                .catch(error => {
                    console.log(error.response);
                });
        },
        updateSlider() {
            let formData = new FormData();
            formData.append("heading", this.slider.heading);
            formData.append("link", this.slider.link);
            formData.append("description", this.slider.description);
            
            formData.append("id", this.slider.id);
            formData.append("_method", "PUT");
            if(this.uploadedFile!=null){
                formData.append("file", this.uploadedFile);
            }
            this.$http
                .post("slider", formData)
                .then(response => {
                    this.getSliders();
                    this.$swal(
                        "Info",
                        response.data.message,
                        response.data.status
                    );
                    this.$bvModal.hide("bv-modal-add-slider");
                    this.clearSliderFileds();
                })
                .catch(error => {
                    console.log(error.response);
                });
        },
        getSliders() {
            this.$http
                .get("sliders")
                .then(response => {
                    this.sliders = response.data.data;
                    if (this.sliders.length != null) {
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
