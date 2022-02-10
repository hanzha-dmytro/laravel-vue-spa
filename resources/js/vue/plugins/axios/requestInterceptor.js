import store from "@vue/store";

const requestInterceptor = (config) => {
    config.headers.common = {
        Authorization: `Bearer ${store.getters['auth/token']}`,
        "Content-Type": "application/json",
        Accept: "application/json"
    };
    return config;
}

export default requestInterceptor
