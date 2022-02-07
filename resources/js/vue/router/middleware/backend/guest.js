import store from '../../../store'

export default function guest ({ next }){
    if(store.getters['auth/isAuthenticated']){
        return next({
            name: 'admin.dashboard'
        })
    }
}
