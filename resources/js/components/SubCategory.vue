<template>
    <div class="container">
        <div class="row-custom">
            <div class="column-custom" v-for="child in childs" :key="child.id">
                <h3>
                    <i
                        class="fa fa-trash"
                        @click="deleteCategory(child.id)"
                    ></i>
                    {{ child.name }}
                </h3>
                <div class="more-child" v-if="child.childs.length > 0">
                    <div
                        class="more-child-items"
                        v-for="grandchild in child.childs"
                        :key="grandchild.id"
                    >
                        <a href="javascript:"
                            ><i
                                class="fa fa-trash"
                                @click="deleteCategory(grandchild.id)"
                            ></i>
                            {{ grandchild.name }}</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// import SubCategory from "../Category/SubCategory.vue"; //incase of infinite menu loop
export default {
    name: "SubCategory",
    props: {
        childs: Array
    },
    components: {
        // SubMenu
    },
    methods: {
        fromCatMenu(slug) {
            //will push
            this.$router.push({ name: "Category", params: { slug: slug } });
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
                            this.$router.push({ name: "Dashboard" });
                        })
                        .catch(error => {
                            console.log(error.response);
                        });
                }
            });
        }
    }
};
</script>
<style scoped>
.more-child a {
    color: #636b6f;
}
.more-child a:hover {
    color: #dc143c;
}
.more-child-items a {
    color: yellow;
}
.more-child-items a:hover {
    color: red;
}
</style>
