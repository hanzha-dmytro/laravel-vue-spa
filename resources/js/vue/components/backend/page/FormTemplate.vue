<template>
    <form id="page-form" @submit.prevent="sendForm">
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Page settings</h6>
                    </div>
                    <div class="card-body">
                        <form-input v-model="form.name" type="text" label="Name" placeholder="Type name" class="mb-3" :errors="errors.name" />
                        <form-input v-model="form.slug" type="text" label="Slug" placeholder="Type slug" class="mb-3" :errors="errors.slug" />
                        <form-html-editor v-model="form.content" label="Content" class="mb-3" :errors="errors.content" />
                        <form-check-box v-model="form.is_visible" label="Visible" class="form-switch" :errors="errors.is_visible" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import FormInput from "@vue/components/backend/form/FormInput.vue";
import sendFormMixin from "@vue/mixins/send-form.mixin";
import FormHtmlEditor from "@vue/components/backend/form/FormHTMLEditor.vue";
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
                content: this.data.content ?? '',
                is_visible: !!(this.data?.is_visible ?? 1),
            },
        }
    },
    mixins: [sendFormMixin],
    components: { FormInput, FormCheckBox, FormHtmlEditor },
}
</script>
