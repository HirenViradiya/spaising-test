<template>
    <div class="container mt-5">
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">First Name</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Enter Your First Name"
                        v-model="empData.firstName"
                        v-validate="'required'"
                        v-bind:name="'empData.firstName'"
                        v-bind:ref="'empData.firstName'"
                        :class="{
                            'is-invalid': errors.has('empData.firstName'),
                        }"
                    />
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Last Name</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Enter Your Last name"
                        v-model="empData.lastName"
                        v-validate="'required'"
                        v-bind:name="'empData.lastName'"
                        v-bind:ref="'empData.lastName'"
                        :class="{
                            'is-invalid': errors.has('empData.lastName'),
                        }"
                    />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Enter Your Email Address"
                        v-model="empData.email"
                        v-validate="'required|email'"
                        v-bind:name="'empData.email'"
                        v-bind:ref="'empData.email'"
                        :class="{
                            'is-invalid': errors.has('empData.email'),
                        }"
                    />
                </div>
                <div class="form-group col-md-6">
                    <label>Mobile Number</label>
                    <input
                        type="number"
                        class="form-control"
                        placeholder="Enter Your Mobile Number"
                        v-model="empData.mobile"
                        v-validate="'required|numeric|max:10|min:10'"
                        v-bind:name="'empData.mobile'"
                        v-bind:ref="'empData.mobile'"
                        :class="{
                            'is-invalid': errors.has('empData.mobile'),
                        }"
                    />
                </div>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Enter Your Address"
                    v-model="empData.address"
                />
            </div>

            <div class="form-group">
                <label>Gender</label>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="gender"
                        id="male"
                        value="male"
                        v-model="empData.gender"
                        :checked="empData.gender == 'male'"
                    />
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="gender"
                        id="female"
                        v-model="empData.gender"
                        value="female"
                        :checked="empData.gender == 'female'"
                    />
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>

            <div class="form-group">
                <label>Department</label>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="department"
                        id="it"
                        v-model="empData.department"
                        value="it"
                        :checked="empData.department == 'it'"
                    />
                    <label class="form-check-label" for="it"
                        >IT Department</label
                    >
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="department"
                        id="sales"
                        v-model="empData.department"
                        value="sales"
                        :checked="empData.department == 'sales'"
                    />
                    <label class="form-check-label" for="sales"
                        >Sales Department</label
                    >
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="department"
                        id="hr"
                        v-model="empData.department"
                        :checked="empData.department == 'hr'"
                        value="hr"
                    />
                    <label class="form-check-label" for="hr"
                        >HR Department</label
                    >
                </div>
            </div>
            <div class="form-group">
                <label>Profile Image</label>
                <input
                    accept="image/png, image/gif, image/jpeg"
                    type="file"
                    class="form-control"
                    @change="onChangeFile"
                />
                <img
                    class="mt-2"
                    v-if="editImage"
                    :src="editImage"
                    width="150"
                />
            </div>
            <div>
                <button
                    type="button"
                    class="btn btn-primary btnRadius"
                    @click="saveData()"
                >
                    Save
                </button>
                <button
                    type="button"
                    class="btn btn-secondary btnRadius"
                    @click="backBtn()"
                >
                    Back
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    name: "Add",
    data() {
        return {
            empData: {
                firstName: "",
                lastName: "",
                email: "",
                mobile: "",
                address: "",
                profileImage: "",
                gender: "male",
                department: "it",
            },
            editImage: "",
            id: "",
        };
    },
    mounted() {
        this.id = this.$route.params.id;
        if (this.id) {
            this.editEmp(this.id);
        }
    },
    methods: {
        ...mapActions({
            editEmployee: "employee/editEmployee",
            saveEmployeeData: "employee/saveEmployeeData",
            updateEmployeeData: "employee/updateEmployeeData",
        }),

        onChangeFile: function (event) {
            this.empData.profileImage = event.target.files[0];
        },

        editEmp(id) {
            this.editEmployee(id).then((response) => {
                if (response) {
                    this.id = response.id;
                    this.empData.firstName = response.first_name;
                    this.empData.lastName = response.last_name;
                    this.empData.email = response.email;
                    this.empData.mobile = response.phone;
                    this.empData.address = response.address;
                    this.empData.gender = response.gender;
                    this.empData.department = response.department;
                    this.empData.profileImage = response.image;
                    this.editImage = response.image;
                }
            });
        },
        backBtn() {
            this.$router.push({ name: "list" });
        },
        async saveData() {
            let result = await this.$validator.validateAll();
            if (result) {
                if (this.id) {
                    this.update();
                } else {
                    this.save();
                }
            } else {
                const firstField = Object.keys(this.errors.collect())[0];
                this.$refs[`${firstField}`].scrollIntoView({
                    behavior: "smooth",
                    block: "end",
                    inline: "nearest",
                });
            }
        },
        save() {
            this.saveEmployeeData(this.empData).then((response) => {
                if (response.status == true) {
                    this.$toastr.s(`${response.message}`);
                    this.$router.push({ name: "list" });
                    this.clear();
                } else {
                    this.$toastr.e(`${response.error}`);
                }
            });
        },
        update() {
            console.log("this.empData", this.empData);
            let data = {
                id: this.id,
                empData: this.empData,
            };
            this.updateEmployeeData(data).then((response) => {
                if (response.status == true) {
                    this.$toastr.s(`${response.message}`);
                    this.$router.push({ name: "list" });
                    this.clear();
                } else {
                    this.$toastr.e(`${response.message}`);
                }
            });
        },
        clear() {
            this.id = "";
            this.empData.firstName = "";
            this.empData.lastName = "";
            this.empData.email = "";
            this.empData.mobile = "";
            this.empData.address = "";
            this.empData.profileImage = "";
            this.empData.department = "it";
            this.empData.gender = "male";
        },
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
.btnRadius {
    border-radius: 10px !important;
    border-radius: 0.25rem !important;
    box-shadow: 2px 2px 5px rgb(0 0 0 / 50%);
}
</style>
