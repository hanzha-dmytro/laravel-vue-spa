<template>
    <div>
        <label :for="'file-upload-'+uid" class="form-label" v-if="label">{{ label}}</label>
        <input type="file" :id="'file-upload-'+uid" :class="['form-control', {'is-invalid': errors.length}]" :disabled="disabled" @change="$emit('change', $event.target.files)">
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
            label: {
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
        computed: {
            uid: function () {
                return this._uid;
            }
        }
    }
</script>

