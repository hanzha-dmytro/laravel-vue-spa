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
            path: 'roles',
            name: 'admin.roles.index',
            props: (route) => ({
                page: route.query.page,
                search: route.query.search,
            }),
            meta: {
                middleware: hasPermissions,
                permissions: ['roles:read'],
            },
            component: () => import('../../../views/backend/role/List'),
        },
        {
            path: 'roles/create',
            name: 'admin.roles.create',
            meta: {
                middleware: hasPermissions,
                permissions: ['roles:read', 'roles:create'],
            },
            component: () => import('../../../views/backend/role/Create'),
        },
        {
            path: 'roles/edit/:id',
            name: 'admin.roles.edit',
            props: true,
            meta: {
                middleware: hasPermissions,
                permissions: ['roles:read', 'roles:update'],
            },
            component: () => import('../../../views/backend/role/Update'),
        },
        {
            path: 'categories',
            name: 'admin.categories.index',
            props: (route) => ({
                page: route.query.page,
                search: route.query.search,
            }),
            meta: {
                middleware: hasPermissions,
                permissions: ['categories:read'],
            },
            component: () => import('../../../views/backend/category/List'),
        },
        {
            path: 'posts/',
            name: 'admin.posts.index',
            props: (route) => ({
                page: route.query.page,
                category_id: route.query.category_id,
                search: route.query.search,
            }),
            meta: {
                middleware: hasPermissions,
                permissions: ['posts:read'],
            },
            component: () => import('../../../views/backend/post/List'),
        },
        {
            path: 'posts/create',
            name: 'admin.posts.create',
            meta: {
                middleware: hasPermissions,
                permissions: ['posts:read', 'posts:create'],
            },
            component: () => import('../../../views/backend/post/Create'),
        },
        {
            path: 'posts/edit/:id',
            name: 'admin.posts.edit',
            props: true,
            meta: {
                middleware: hasPermissions,
                permissions: ['posts:read', 'posts:update'],
            },
            component: () => import('../../../views/backend/post/Update.vue'),
        },
        {
            path: 'comments/',
            name: 'admin.comments.index',
            props: (route) => ({
                page: route.query.page,
                search: route.query.search,
                visibility: route.query.visibility,
            }),
            meta: { middleware: auth},
            component: () => import('../../../views/backend/comment/List'),
        },
        {
            path: 'pages/',
            name: 'admin.pages.index',
            props: (route) => ({
                page: route.query.page,
                search: route.query.search,
                visibility: route.query.visibility,
            }),
            meta: {
                middleware: hasPermissions,
                permissions: ['pages:read'],
            },
            component: () => import('../../../views/backend/page/List'),
        },
        {
            path: 'pages/create',
            name: 'admin.pages.create',
            meta: {
                middleware: hasPermissions,
                permissions: ['pages:read', 'pages:create'],
            },
            component: () => import('../../../views/backend/page/Create'),
        },
        {
            path: 'pages/edit/:id',
            name: 'admin.pages.edit',
            props: true,
            meta: {
                middleware: hasPermissions,
                permissions: ['pages:read', 'pages:update'],
            },
            component: () => import('../../../views/backend/page/Update.vue'),
        },
        {
            path: '*',
            name: 'admin.error.404',
            component: () => import('../../../views/backend/error/Error404')
        },
    ],
}

export default routes
