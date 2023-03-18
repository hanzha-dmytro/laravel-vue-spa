<template>
    <div>
        <label class="form-label" v-if="label">{{ label }}</label>
        <textarea :value="value" ref="ckeditor" :class="['form-control', {'is-invalid': errors.length}]" :disabled="disabled" />
        <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
    </div>
</template>

<script>

import ClassicEditor from 'ckeditor5-advanced-build'

export default {
    name: 'form-html-editor',
    props: {
        value: {
            type: String,
            default: null,
        },
        label: {
            type: String,
            default: null,
        },
        config: {
            type: Object,
            default: () => {},
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        errors: {
            type: Array,
            default: () => [],
        },
    },
    mounted() {
        ClassicEditor.create(this.$refs.ckeditor)
            .then((editor) => {
                editor.model.document.on('change:data', () => {
                    this.$emit('input', editor.getData())
                });
            } );
    },
}
</script>

<style lang="scss">
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>
