import store from "@vue/store";
import router from "@vue/router";

const onFulfilled = response => response
const onRejected = error => {
    if (error.response.status === 401) {
        store.commit("auth/forgetUser")
        router.push({name: "admin.auth.login"})
    } else if (error.response.status === 403) {
        store.dispatch('toast/add', {
            type: 'warning',
            message: error.response.data?.message,
        })
    } else if (error.response.status === 500) {
        store.dispatch('toast/add', {
            type: 'error',
            message: error.response.data?.message,
        })
    }
    return Promise.reject(error)
}

export { onFulfilled, onRejected }
