const routes = {
    path: '/',
    component: () => import('../../../layouts/frontend/MainLayout'),
    children: [
        {
            path: '/',
            name: 'frontend.index',
            component: () => import('../../../views/frontend/Index'),
        },
        {
            path: '*',
            name: 'frontend.error.404',
            component: () => import('../../../views/frontend/error/Error404')
        },
    ]
}

export default routes
