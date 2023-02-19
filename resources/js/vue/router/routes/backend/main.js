//Middleware
import user from '../../middleware/backend/user'
import auth from '../../middleware/backend/auth'
import hasPermissions from '../../middleware/backend/hasPermissions'

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
            path: 'profile',
            name: 'admin.profile',
            meta: { middleware: auth },
            component: () => import('../../../views/backend/Profile'),
        },
        {
            path: 'users',
            name: 'admin.users.index',
            props: (route) => ({
                page: route.query.page,
                role_id: route.query.role_id,
                search: route.query.search,
            }),
            meta: {
                middleware: hasPermissions,
                permissions: ['users:read'],
            },
            component: () => import('../../../views/backend/user/List'),
        },
        {
            path: 'users/create',
            name: 'admin.users.create',
            meta: {
                middleware: hasPermissions,
                permissions: ['users:read', 'users:create'],
            },
            component: () => import('../../../views/backend/user/Create'),
        },
        {
            path: 'users/edit/:id',
            name: 'admin.users.edit',
            props: true,
            meta: {
                middleware: hasPermissions,
                permissions: ['users:read', 'users:update'],
            },
            component: () => import('../../../views/backend/user/Update'),
        },
        {
            path: '*',
            name: 'admin.error.404',
            component: () => import('../../../views/backend/error/Error404')
        },
    ],
}

export default routes
