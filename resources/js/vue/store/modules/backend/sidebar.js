export default {
    namespaced: true,
    state: {
        collapsed: localStorage.collapsed !== 'false',
    },
    mutations: {
        toggle(state, status) {
            state.collapsed = status
            localStorage.collapsed = status
        },
    },
    actions: {
        toggle({commit, state}) {
            commit('toggle' , !state.collapsed)
        },
    },
    getters: {
        collapsed: state => state.collapsed,
    }
}
