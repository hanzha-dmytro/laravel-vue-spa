<template>
    <form id="post-form" @submit.prevent="sendForm">
        <div class="row">
            <div class="col-sm-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Post settings</h6>
                    </div>
                    <div class="card-body">
                        <form-input v-model="form.name" type="text" label="Name" placeholder="Type name" class="mb-3" :errors="errors.name" />
                        <form-input v-model="form.slug" type="text" label="Slug" placeholder="Type slug" class="mb-3" :errors="errors.slug" />
                        <div class="row">
                            <form-multiselect v-model.number="form.category_id" :options="categories" label="Category" placeholder="Select a category" class="mb-3 col-md-6 col-sm-12" :errors="errors.category_id" :disabled="!$can('categories:read')" />
                            <from-date-picker v-model="form.published_at" label="Published" class="mb-3 col-md-6 col-sm-12" :errors="errors.published_at" />
                        </div>
                        <form-text-area v-model="form.description" label="Description" placeholder="Type description" class="mb-3" :errors="errors.description" />
                        <form-html-editor v-model="form.content" label="Content" :errors="errors.content" class="mb-3" />
                        <form-check-box v-model="form.is_pinned" label="Pinned" class="form-switch" :errors="errors.is_pinned" />
                        <form-check-box v-model="form.is_visible" label="Visible" class="form-switch" :errors="errors.is_visible" />
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Post image</h6>
                    </div>
                    <div class="card-body">
                        <form-image :value="data?.image ?? ''" :width="840" :height="560" file-type="image/jpeg" fill-color="#fff" :errors="errors.image" @change="avatar => form.image = avatar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import FormImage from "@vue/components/backend/form/FormImage.vue";
import FormMultiselect from "@vue/components/backend/form/FormMultiselect.vue";
import FormInput from "@vue/components/backend/form/FormInput.vue";
import FormTextArea from "@vue/components/backend/form/FormTextArea.vue";
import sendFormMixin from "@vue/mixins/send-form.mixin";
import FormHtmlEditor from "@vue/components/backend/form/FormHTMLEditor.vue";
import FromDatePicker from "@vue/components/backend/form/FromDatePicker.vue";
import FormCheckBox from "@vue/components/backend/form/FormCheckBox.vue";

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
    data () {
        return {
            form: {
                name: this.data.name ?? '',
                slug: this.data.slug ?? '',
                category_id: this.data.category?.id ?? 0,
                description: this.data.description ?? '',
                content: this.data.content ?? '',
                is_visible: !!(this.data?.is_visible ?? 1),
                is_pinned: !!(this.data?.is_pinned ?? 0),
                published_at: this.data.published_at ?? '',
            },
            categories: [],
        }
    },
    mounted() {
        this.getCategories()
    },
    methods: {
        getCategories() {
            axios.get('/api/categories/all').then((response) => {
                this.categories = response.data.data.map((category) => {
                    return { value: category.id, name: category.name }
                })
            })
        },
    },
    mixins: [sendFormMixin],
    components: { FromDatePicker, FormTextArea, FormInput, FormMultiselect, FormCheckBox, FormImage, FormHtmlEditor },
}
</script>
