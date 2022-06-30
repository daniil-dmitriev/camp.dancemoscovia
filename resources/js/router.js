import VueRouter from "vue-router";
import Vue from "vue";

Vue.use(VueRouter);

import App from "./views/App";
import Index from "./views/Index";
import Info from "./views/Info";
import Register from "./views/Register";
import Settings from "./views/Settings";
import Login from "./views/Login";
import Contacts from "./views/Contacts";


const routes = [
    { path: "/", name: "index", component: Index },
    { path: "/info", name: "info", component: Info },
    { path: "/register", name: "register", component: Register },
    { path: "/contacts", name: "contacts", component: Contacts },
    {
        path: "/settings",
        name: "settings",
        component: Settings,
        // beforeEnter: (to, from, next) => {
        //     axios
        //         .get("api/authenticated")
        //         .then(res => {
        //             if (res.data.status) {
        //                 next();
        //             } 
        //         })
        //         .catch(() => {
        //             return next({ name: "login" });
        //         });
        // }
    },
    { path: "/login", name: "login", component: Login }
];

export default new VueRouter({
    mode: "history",
    components: { App },
    routes
});
