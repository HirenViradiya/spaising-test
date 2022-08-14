import Vue from "vue";
import VueRouter from "vue-router";
import List from "../Components/List";
import Add from "../Components/Add";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "list",
        component: List,
    },
    {
        path: "/add",
        name: "add",
        component: Add,
    },
    {
        path: "/edit/:id",
        name: "edit",
        component: Add,
    },
];
const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;
