import Vue from "vue"
import VueRouter from "vue-router"

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [],
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})

export default router
