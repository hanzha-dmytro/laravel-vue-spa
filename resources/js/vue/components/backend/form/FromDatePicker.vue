<template>
    <div>
        <label class="form-label" v-if="label">{{ label }}</label>
        <input :value="value" ref="picker" :class="['form-control', {'is-invalid': errors.length}]" readonly :disabled="disabled" />
        <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
        <div class="calendar-wrapper"></div>
    </div>
</template>

<script>
import AirDatepicker from 'air-datepicker'
import locale from 'air-datepicker/locale/en'

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
        format: {
            type: String,
            default: 'yyyy-MM-dd',
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
        new AirDatepicker(this.$refs.picker, {
            locale: locale,
            dateFormat: this.format,
            container: '.calendar-wrapper',
            onSelect: this.onSelectDate
        });
    },
    methods: {
        onSelectDate({ formattedDate }) {
            this.$emit('input', formattedDate)
        }
    }
}
</script>

<style lang="scss" scoped>
    @import 'air-datepicker/air-datepicker.css';
</style>
