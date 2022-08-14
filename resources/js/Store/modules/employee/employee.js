import { getBaseUrl, unauthorizedHandler } from "../../../plugins/Auth";
import axios from "axios";

const state = {
    employeeList: [],
};

const mutations = {
    /* Review Listing */
    SET_EMPLOYEE_LIST(state, employeeList) {
        state.employeeList = employeeList;
    },
};

// getters
const getters = {
    getEmployeeList(state) {
        return state.employeeList;
    },
};

// actions
const actions = {
    /**
     * Get Employees List
     *
     * @param state
     */
    async getAllEmployeeList({ commit, state }, data) {
        let url = getBaseUrl() + `show`;
        const apiResponse = await axios
            .get(url)
            .then((response) => {
                const apiData = response.data;
                if (apiData.status_code == 200) {
                    return apiData.data;
                }
            })
            .catch(({ response }) => {
                unauthorizedHandler(response.data);
                return response.data;
            });
        return apiResponse;
    },

    /**
     * Edit Single Employee
     *
     * @param state
     */
    async editEmployee({ commit, state }, data) {
        let url = getBaseUrl() + `edit/${data}`;
        const apiResponse = await axios
            .get(url)
            .then((response) => {
                const apiData = response.data;
                if (apiData.status_code == 200) {
                    return apiData.data;
                }
            })
            .catch(({ response }) => {
                unauthorizedHandler(response.data);
                return response.data;
            });
        return apiResponse;
    },

    /**
     * Delete Single Employee
     *
     * @param state
     */
    async deleteEmployee({ commit, state }, data) {
        let url = getBaseUrl() + `delete/${data}`;
        const apiResponse = await axios
            .post(url)
            .then((response) => {
                const apiData = response.data;
                if (apiData.status_code == 200) {
                    return apiData;
                }
            })
            .catch(({ response }) => {
                unauthorizedHandler(response.data);
                return response.data;
            });
        return apiResponse;
    },

    /**
     * Save Employees Details
     *
     * @param state
     */
    async saveEmployeeData({ commit, state }, data) {
        let formData = new FormData();
        formData.append("first_name", data.firstName);
        formData.append("last_name", data.lastName);
        formData.append("email", data.email);
        formData.append("phone", data.mobile);
        formData.append("address", data.address);
        formData.append("gender", data.gender);
        formData.append("department", data.department);
        if (data.profileImage !== null) {
            formData.append("image", data.profileImage);
        }
        let url = getBaseUrl() + `create`;
        const apiResponse = await axios
            .post(url, formData)
            .then((response) => {
                const apiData = response.data;
                return apiData;
            })
            .catch(({ response }) => {
                unauthorizedHandler(response.data);
                return response.data;
            });
        return apiResponse;
    },
    /**
     * Update Employees Details
     *
     * @param state
     */
    async updateEmployeeData({ commit, state }, data) {
        let empData = data.empData;
        let formData = new FormData();
        formData.append("id", data.id);
        formData.append("first_name", empData.firstName);
        formData.append("last_name", empData.lastName);
        formData.append("email", empData.email);
        formData.append("phone", empData.mobile);
        formData.append("address", empData.address);
        formData.append("gender", empData.gender);
        formData.append("department", empData.department);
        if (data.profileImage !== null) {
            formData.append("image", empData.profileImage);
        }
        let url = getBaseUrl() + `update`;
        const apiResponse = await axios
            .post(url, formData)
            .then((response) => {
                const apiData = response.data;
                if (apiData.status_code == 200) {
                    return apiData;
                }
            })
            .catch(({ response }) => {
                unauthorizedHandler(response.data);
                return response.data;
            });
        return apiResponse;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
