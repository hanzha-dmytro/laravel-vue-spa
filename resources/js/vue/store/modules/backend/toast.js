export  default {
    namespaced: true,
    state: {
        toasts: [],
        counter: 0
    },
    mutations: {
        add(state, message) {
            state.toasts.push(message)
        },
        remove(state, id) {
            const index = state.toasts.findIndex(toast => toast.id === id)
            state.toasts.splice(index, 1)
        }
    },
    actions: {
        add({commit, state}, message) {
            const id = state.counter++
            commit('add', {
                id: id,
                time: new Date().getTime(),
                ...message,
            })
        },
        remove({commit}, id) {
            commit('remove', id)
        },
    },
    getters: {
        all: state => state.toasts
    }
}
