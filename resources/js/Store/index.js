import Vue from "vue";
import Vuex from "vuex";

import employee from "../Store/modules/employee/employee";

Vue.use(Vuex);

let stores = {
    employee,
};

/**
 * @desc Inject module in store
 */
export default new Vuex.Store({
    modules: stores,
});
