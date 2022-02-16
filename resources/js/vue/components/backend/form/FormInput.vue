<template>
    <div>
        <label class="form-label" v-if="label">{{ label }}</label>
        <input :value="value" :type="type" :placeholder="placeholder" :class="['form-control', {'is-invalid': errors.length}]" :disabled="disabled" @input="$emit('input', $event.target.value)">
        <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: [String, Number],
                default: null,
            },
            type: {
                type: String,
                required: true,
                validator: (value) => ['email', 'number', 'password', 'text'].includes(value),
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
