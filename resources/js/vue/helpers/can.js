import store from '../store'

export default function can(permissions) {
    const user = store.getters['auth/user'];
    return [].concat(permissions).every(permission => [...user.permissions ?? [], ...(user.role?.permissions ?? [])].includes(permission))
}
