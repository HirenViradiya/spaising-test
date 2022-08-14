<template>
    <div class="container mt-5">
        <button class="btn btn-primary empBtn btnRadius" @click="addNew">
            Add New Employee
        </button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody v-if="empList?.length">
                <tr v-for="employee in empList" v-bind:key="employee.id">
                    <th scope="row">{{ `${employee.id}` }}</th>
                    <td>{{ `${employee.first_name}` }}</td>
                    <td>{{ `${employee.last_name}` }}</td>
                    <td>{{ `${employee.email}` }}</td>
                    <td>{{ `${employee.phone}` }}</td>
                    <td>
                        <img
                            v-if="employee.image"
                            :src="employee.image"
                            alt="employee Profile"
                            width="150"
                        />
                    </td>
                    <td>
                        <button
                            @click="editEmp(employee.id)"
                            class="edit btn btn-primary btn-sm btnRadius"
                        >
                            Edit
                        </button>
                        <button
                            @click="deleteEmp(employee.id)"
                            class="delete btn btn-danger btn-sm btnRadius"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7" class="justify-content-center txtAlign">
                        No Data Found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    name: "App",
    data() {
        return {
            addShow: false,
            empList: [],
        };
    },
    methods: {
        ...mapActions({
            employeeList: "employee/getAllEmployeeList",
            deleteEmployee: "employee/deleteEmployee",
        }),
        employeeListing() {
            this.employeeList().then((response) => {
                this.empList = response;
            });
        },
        deleteEmp(id) {
            this.deleteEmployee(id).then((response) => {
                if (response.status) {
                    this.$toastr.s(`${response.message}`);
                    this.employeeListing();
                } else {
                    this.$toastr.e(`${response.message}`);
                }
            });
        },
        editEmp(id) {
            this.$router.push({ name: "edit", params: { id } });
        },

        addNew() {
            this.$router.push({ name: "add" });
        },
    },
    mounted() {
        this.employeeListing();
    },
};
</script>
<style scopper>
.is-invalid {
    background-image: none !important;
    border-color: #dc3545 !important;
}
.form-control.is-invalid,
.was-validated .form-control:invalid {
    border-color: #dc3545 !important;
}
.empBtn {
    float: right;
    margin: 15px;
}
.btnRadius {
    border-radius: 10px !important;
    border-radius: 0.25rem !important;
    box-shadow: 2px 2px 5px rgb(0 0 0 / 50%);
}
.txtAlign {
    text-align: center;
}
</style>
