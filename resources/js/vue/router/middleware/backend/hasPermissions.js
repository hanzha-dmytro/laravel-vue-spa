import can from '../../../helpers/can'

export default function hasPermissions ({ from, to, next }){
    if(!can(to.meta.permissions)) {
        return next({
            name: from.name ?? 'admin.dashboard'
        })
    }

    return next()
}
