<template>
    <form class="form-template" id="category-form" @submit.prevent="sendForm">
        <h5 class="text-truncate">{{ formTitle }}</h5>
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Settings</h6>
                    </div>
                    <div class="card-body">
                        <form-input v-model="form.name" type="text" label="Name" placeholder="Type name" class="mb-3" :errors="errors.name" />
                        <form-input v-model="form.slug" type="text" label="Slug" placeholder="Type slug" class="mb-3" :errors="errors.slug" />
                        <form-text-area v-model="form.description" label="Description" placeholder="Type description" class="mb-3" :errors="errors.description" />
                        <form-check-box v-model="form.is_visible" label="Visible" class="form-switch" :errors="errors.is_visible" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Image</h6>
                    </div>
                    <div class="card-body">
                        <form-image :value="data.image" :width="840" :height="560" file-type="image/jpeg" fill-color="#fff" :errors="errors.image" @change="avatar => form.image = avatar"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group float-end mb-4">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</template>

<script>

import SendFormMixin from "@vue/mixins/send-form.mixin";
import FormImage from "@vue/components/backend/form/FormImage.vue";
import FormCheckBox from "@vue/components/backend/form/FormCheckBox.vue";
import FormTextArea from "@vue/components/backend/form/FormTextArea.vue";
import FormInput from "@vue/components/backend/form/FormInput.vue";

export default {
    props: {
        data: {
            type: Object,
            default: () => {
                return {};
            },
        },
        errors: {
            type: Object,
            default: () => {
                return {};
            },
        },
    },
    data() {
        return {
            form: {
                name: this.data.name ?? '',
                slug: this.data.slug ?? '',
                description: this.data?.description ?? '',
                image: '',
                is_visible: !!(this.data?.is_visible ?? 1),
            },
        }
    },
    computed: {
        formTitle() {
            return this.data?.id ? `Edit category: ${this.form.name}` : `Create new category`;
        },
    },
    mixins: [SendFormMixin],
    components: { FormInput, FormTextArea, FormCheckBox, FormImage },
}
</script>
