<template>
    <form id="role-form" @submit.prevent="sendForm">
        <div class="row">
            <div class="col-12 mb-3 mb-lg-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <form-input v-model="form.name" type="text" label="Name" placeholder="Type name" class="mb-3" :errors="errors.name" />
                        <form-input v-model.trim="form.slug" type="text" label="Slug" placeholder="Type slug" class="mb-3" :errors="errors.slug" />
                        <form-multiselect v-model="form.permissions" :options="permissions" label="Permissions" type="taggable" :searchable="true" :errors="errors.permissions" :disabled="!$can('permissions:read')" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import FormImage from "../form/FormImage";
import FormInput from "../form/FormInput";
import FormTextArea from "../form/FormTextArea";
import FormSelect from "../form/FormSelect";
import FormMultiselect from "../form/FormMultiselect";
import sendFormMixin from "@vue/mixins/send-form.mixin";

export default {
    props: {
        data: {
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
            form: {
                name: this.data?.name ?? '',
                slug: this.data?.slug ?? '',
                permissions: this.data?.permissions ?? []
            },
            permissions: [],
        }
    },
    mounted() {
        this.getPermissions()
    },
    methods: {
        getPermissions() {
            axios.get('/api/permissions').then((response) => {
                this.permissions = response.data.data.map((permission) => {
                    return { value: permission, name: permission }
                })
            })
        }
    },
    mixins: [sendFormMixin],
    components: { FormImage, FormInput, FormTextArea, FormSelect, FormMultiselect},

}
</script>
