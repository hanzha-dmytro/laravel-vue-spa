import store from "@vue/store";

export default {
    methods: {
        showToast(type, message, timeout) {
            store.dispatch('toast/add', {type, message, timeout})
        },
    }
}
