export default {
    namespaced: true,
    state: {
        user: {},
        token: localStorage.token ?? '',
    },
    mutations: {
        setToken(state, token) {
            state.token = token
            localStorage.token = token
        },
        setUserData(state, user) {
            state.user = user
        },
        forgetUser(state) {
            state.token = ''
            state.user = {}
            localStorage.token = ''
        }
    },
    actions: {
        login({commit, state}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/login', payload).then((response) => {
                    commit('setToken' , response.data.token)
                    commit('setUserData' , response.data.user)
                    resolve()
                }, (error) => reject(error))
            })
        },
        logout({commit}) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/logout').then(() => {
                    commit('forgetUser')
                    resolve()
                }, (error) => reject(error))
            })
        },
        getUserData({commit}) {
            return new Promise((resolve, reject) => {
                axios.get('/api/profile').then((response) => {
                    commit('setUserData' , response.data.data)
                    resolve()
                }, (error) => reject(error))
            })
        },
    },
    getters: {
        user: state => state.user,
        token: state => state.token,
        isAuthenticated: state => !!state.token
    }
}
