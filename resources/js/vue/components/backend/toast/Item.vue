<template>
    <div ref="toast" :class="['toast', toast.type]" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <strong class="me-auto">{{ capitalize(toast.type) }}</strong>
            <small class="text-muted">{{ new Date(toast.time).toLocaleTimeString() }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ toast.message }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        toast: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        new bootstrap.Toast(this.$refs.toast, { autohide: true, delay: this.toast.timeout ?? 5000 }).show()
        this.$refs.toast.addEventListener('hidden.bs.toast', () => this.$store.dispatch('toast/remove', this.toast.id))
    },
    methods: {
        capitalize(value) {
            return _.capitalize(value)
        }
    }
}
</script>
