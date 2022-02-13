<template>
    <div class="toast-container">
        <div :class="['toast show', toast.type]" role="alert" v-for="toast in toasts" :key="toast.id">
            <div class="toast-header">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <strong class="me-auto">{{ capitalize(toast.type) }}</strong>
                <small class="text-muted">{{ new Date(toast.time).toLocaleTimeString() }}</small>
                <button type="button" class="btn-close" aria-label="Close" @click="$store.dispatch('toast/remove', toast.id)"></button>
            </div>
            <div class="toast-body">
                {{ toast.message }}
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data () {
        return {
            toasts: []
        }
    },
    mounted() {
        this.toasts = this.$store.getters['toast/all']
    },
    methods:{
        capitalize(value) {
            return _.capitalize(value)
        }
    }
}
</script>
