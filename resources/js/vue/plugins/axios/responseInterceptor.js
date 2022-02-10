import store from "@vue/store";
import router from "@vue/router";

const onFulfilled = response => response
const onRejected = error => {
    if (error.response.status === 401) {
        store.commit("auth/forgetUser")
        router.push({name: "admin.auth.login"})
    }
    return Promise.reject(error)
}

export { onFulfilled, onRejected }
