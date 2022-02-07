import store from '../../../store'
import {isEmpty} from "lodash";

export default async function auth ({ next }) {
    if(store.getters["auth/isAuthenticated"] && isEmpty(store.getters["auth/user"])) {
        await store.dispatch('auth/getUserData')
        await store.dispatch('loaded')
    }
}
