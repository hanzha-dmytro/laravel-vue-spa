<template>
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-sm-0 mb-2">
                        <div class="row g-3">
                            <div class="col-auto">
                                <label class="col-form-label">Search</label>
                            </div>
                            <div class="col">
                                <form-input v-model="filter.search" type="text" placeholder="Type name, description, content" :errors="errors.search" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 ms-sm-auto">
                        <div class="row g-3">
                            <div class="col-auto">
                                <label class="col-form-label">Category</label>
                            </div>
                            <div class="col">
                                <form-multiselect v-model.number="filter.category_id" :options="categories" placeholder="Select a role" :errors="errors.category_id" :disabled="!$can('categories:read')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import FormMultiselect from "@vue/components/backend/form/FormMultiselect.vue";
import FormInput from "@vue/components/backend/form/FormInput"
import toSafeInt from "@vue/helpers/to-safe-int";

export default {
    props: {
        values: {
            type: Object,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
    },
    data() {
        return {
            categories: [],
            filter: {
                category_id: toSafeInt(this.values?.category_id),
                search: this.values?.search,
            },
            timeout: null,
        }
    },
    mounted() {
        this.getCategories()
    },
    methods: {
        getCategories() {
            axios.get('/api/categories/all').then((response) => {
                this.categories = response.data.data.map((role) => {
                    return { value: role.id, name: role.name }
                })
            })
        },
    },
    watch: {
        filter: {
            handler() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.$emit('filterData', this.params)
                }, 500);
            },
            deep: true,
        },
    },
    computed: {
        params: function () {
            let result = {}
            for (let key in this.filter) {
                result[key] = !!this.filter[key] ? this.filter[key] : undefined;
            }
            return result;
        },
    },
    components: { FormMultiselect, FormInput }
}
</script>
