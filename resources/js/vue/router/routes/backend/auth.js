//Middleware
import guest from '../../middleware/backend/guest'

const routes = {
    path: '/admin/auth',
    meta: { middleware: guest},
    component: () => import('../../../layouts/backend/AuthLayout'),
    children: [
        {
            path: 'login',
            name: 'admin.auth.login',
            component: () => import('../../../views/backend/auth/Login')
        },
        {
            path: 'password/restore',
            name: 'admin.auth.restore',
            component: () => import('../../../views/backend/auth/password/Restore')
        },
        {
            path: 'password/reset',
            name: 'admin.auth.reset',
            props: (route) => ({
                token: route.query.token ?? '',
            }),
            component: () => import('../../../views/backend/auth/password/Reset')
        }
    ],
}

export default routes
