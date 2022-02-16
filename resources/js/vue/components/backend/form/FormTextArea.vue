<template>
    <div>
        <label class="form-label" v-if="label">{{ label }}</label>
        <textarea :value="value" :rows="rows" :placeholder="placeholder" :class="['form-control', {'is-invalid': errors.length}]" :disabled="disabled" @input="$emit('input', $event.target.value)"></textarea>
        <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                default: null,
            },
            rows: {
                type: Number,
                default: 5,
            },
            label: {
                type: String,
                default: null,
            },
            placeholder: {
                type: String,
                default: null,
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
    }
</script>
