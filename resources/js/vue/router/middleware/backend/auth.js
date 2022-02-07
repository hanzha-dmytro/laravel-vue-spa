import store from '../../../store'

export default function auth ({ next }) {
    if(!store.getters['auth/isAuthenticated']){
        return next({
            name: 'admin.auth.login'
        })
    }
}
