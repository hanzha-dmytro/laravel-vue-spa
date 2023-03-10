<template>
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="filter-item col-12 col-sm-12 mb-sm-0 mb-2">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="search" class="col-form-label">Search</label>
                            </div>
                            <div class="col">
                                <form-input v-model.trim="filter.search" type="text" placeholder="Type name" :errors="errors.search" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import FormInput from "@vue/components/backend/form/FormInput"

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
    data () {
        return {
            filter: {
                search: this.values?.search,
            },
            timeout: null,
        }
    },
    watch: {
        filter: {
            handler() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.$emit('filterData', this.params)
                }, 500);
            },
            deep: true
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
    components: { FormInput }
}
</script>
