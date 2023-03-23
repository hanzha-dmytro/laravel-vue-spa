<template>
    <form class="form-template" id="comment-form" @submit.prevent="sendForm">
        <h5 class="text-truncate">{{ formTitle }}</h5>
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form-input v-model="form.name" type="text" label="Author name" placeholder="Type name" class="mb-3" :errors="errors.name" />
                        <form-text-area v-model="form.content" label="Content" placeholder="Type content" class="mb-3" :errors="errors.content" />
                        <form-multiselect v-model.number="form.post_id" :options="posts" label="Related post" placeholder="Select a post" class="mb-3" :errors="errors.post_id" :disabled="!$can('posts:read')" />
                        <from-date-picker v-model="form.published_at" label="Published" class="mb-3" :errors="errors.published_at" />
                        <form-check-box v-model="form.is_visible" label="Visible" class="form-switch" :errors="errors.is_visible" />
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
import FormCheckBox from "@vue/components/backend/form/FormCheckBox.vue";
import FormTextArea from "@vue/components/backend/form/FormTextArea.vue";
import FormInput from "@vue/components/backend/form/FormInput.vue";
import FormMultiselect from "@vue/components/backend/form/FormMultiselect.vue";
import FromDatePicker from "@vue/components/backend/form/FromDatePicker.vue";

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
                post_id: this.data.post?.id ?? '',
                name: this.data.name ?? '',
                content: this.data.content ?? '',
                published_at: this.data.published_at ?? '',
                is_visible: !!(this.data.is_visible ?? 1),
            },
            posts: [],
        }
    },
    mounted() {
        this.getPosts()
    },
    methods: {
        getPosts() {
            axios.get('/api/posts/all').then((response) => {
                this.posts = response.data.data.map((post) => {
                    return { value: post.id, name: post.name }
                })
            })
        },
    },
    computed: {
        formTitle() {
            return this.data?.id ? `Edit comment: ${this.form.name}` : `Create new comment`;
        },
    },
    mixins: [SendFormMixin],
    components: { FormInput, FormTextArea, FormMultiselect, FormCheckBox, FromDatePicker },
}
</script>
