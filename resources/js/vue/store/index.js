import Vue from 'vue'
import Vuex from 'vuex'
import auth from "./modules/backend/auth";
import sidebar from "./modules/backend/sidebar";

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        loaded: false,
    },
    mutations: {
        loaded(state, status) {
            state.loaded = status
        },
    },
    actions: {
        loaded({commit}) {
            commit('loaded', true)
        },
    },
    getters: {
        loaded: state => state.loaded,
    },
    modules: { auth, sidebar }
})
