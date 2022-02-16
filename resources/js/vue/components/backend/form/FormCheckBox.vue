<template>
    <div class="form-check">
        <input :checked="value" type="checkbox" :id="'check-'+uid" :class="['form-check-input', {'is-invalid': errors.length}]" :multiple="multiple" :disabled="disabled" @input="$emit('input', $event.target.checked)">
        <label class="form-check-label" :for="'check-'+uid">{{ label }}</label>
        <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: Boolean,
                default: false,
            },
            label: {
                type: String,
                default: true,
            },
            multiple: {
                type: Boolean,
                default: false,
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
        computed: {
            uid: function () {
                return this._uid;
            }
        }
    }
</script>
