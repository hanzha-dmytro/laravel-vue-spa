//Middleware
import user from '../../middleware/backend/user'
import auth from '../../middleware/backend/auth'

const routes = {
    path: '/admin',
    meta: { middleware: [user, auth] },
    component: () => import('../../../layouts/backend/MainLayout'),
    children: [
        {
            path: '/',
            name: 'admin.dashboard',
            component: () => import('../../../views/backend/Dashboard'),
        },
        {
            path: '*',
            name: 'admin.error.404',
            component: () => import('../../../views/backend/error/Error404')
        },
    ],
}

export default routes
