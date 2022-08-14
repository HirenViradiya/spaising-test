require("./bootstrap");
import Vue from "vue";
window.Vue = require("vue").default;
import VueToastr from "vue-toastr";
import VueRouter from "vue-router";
import router from "./Router/routes";
import App from "./Components/App.vue";
import store from "./Store/index";
import BootstrapVue from "bootstrap-vue";
import VeeValidate from "vee-validate";

// window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(VueToastr);
Vue.use(VeeValidate);

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

//Vue.component("app", require("./Components/App.vue").default);

const app = new Vue({
    el: "#app",
    // components :{
    //     info : App
    // },
    router,
    store,
    render: (h) => h(App),
});
