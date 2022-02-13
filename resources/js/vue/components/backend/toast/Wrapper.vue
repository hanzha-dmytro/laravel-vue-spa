<template>
    <div class="toast-container">
        <toast :toast="toast" v-for="toast in toasts" :key="toast.id" />
    </div>
</template>

<script>
import Toast from "./Item.vue";

export default {
    data() {
        return {
            toasts: []
        }
    },
    mounted() {
        this.toasts = this.$store.getters['toast/all']
    },
    components: { Toast },
}
</script>
