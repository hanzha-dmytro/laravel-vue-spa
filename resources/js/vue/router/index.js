import Vue from "vue"
import VueRouter from "vue-router"
import backendAuth from "./routes/backend/auth";
import backendMain from "./routes/backend/main";
import frontendMain from "./routes/frontend/main"
import store from "../store";

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        backendAuth,
        backendMain,
        frontendMain
    ],
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})

router.beforeResolve( async (to, from, next) => {
    const routes = [].concat(to.matched)

    const middlewares = routes.reduce((middlewares, route) => {
        return route.meta?.middleware ? middlewares.concat(route.meta.middleware) : middlewares;
    }, []);

    if(middlewares.length) {
        for(const middleware of middlewares) {
            await middleware({ to, from, next })
        }
    }

    // All required data loaded
    await store.dispatch('loaded')

    return next()
})

export default router
