<template>
    <div>
        <label class="form-label" v-if="label">{{ label }}</label>
        <select :class="['form-select', {'is-invalid': errors.length}]" :disabled="disabled" @input="$emit('input', $event.target.value)">
            <option value="0" v-if="placeholder.length">{{ placeholder }}</option>
            <option v-for="(option, index) in options" :key="index" :value="option.value" :selected="option.value === value">{{ option.name }}</option>>
        </select>
        <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: [Number, String],
                default: null,
            },
            options: {
                type: Array,
                required: true,
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
        }
    }
</script>
