<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                <snap v-text="'id'" class="mx-auto w-1/6 text-gray-600"></snap>
                <snap v-text="'الرقم الاكاديمي'" class="mx-auto w-1/6 text-gray-600"></snap>
                <snap v-text="'الاسم'" class="mx-auto w-1/6 text-gray-600"></snap>
                <snap v-text="'النوع'" class="mx-auto w-2/6 text-gray-600"></snap>
                <snap v-text="'الصلاحيات'" class="mx-auto w-2/6 text-gray-600"></snap>
            </div>
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-gray-900 hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <snap v-text="'#' + item.id" class="mx-auto w-1/6 "></snap>
                    <snap v-text="item.acadimyId" class="mx-auto w-1/6 "></snap>
                    <snap v-text="item.name" class="mx-auto w-1/6 "></snap>
                    <snap class="mx-auto w-2/6 flex items-center justify-center">
                        <div class="px-2 mx-2 py-1 rounded-md text-sm bg-indigo-300 bg-opacity-25"
                            v-for="(type, i) in item.type" :key="i" v-text="type"></div>
                    </snap>
                    <snap class="mx-auto w-2/6 flex items-center justify-center">
                        <div class="flex items-center justify-center" v-for="(promission, i) in item.promissions"
                            :key="i">
                            <div class="rounded-md px-2 mx-2 py-1  text-sm bg-indigo-300 bg-opacity-25"
                                v-for="(item, i) in promission" :key="i" v-text="item"></div>
                        </div>
                    </snap>
                </div>
            </div>
        </div>

        <!-- add from -->
        <MyForm show-btn-classes="w-full" :show="showForm.add">
            <!-- show-button -->
            <template #show>
                <!-- for loop from classes -->

            </template>
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.name"> </h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الاسم" />

                        <JetInput v-model="addData.name" type="text" class="mt-1 block" placeholder="الاسم" />

                        <JetInputError :message="addDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الرقم الاكاديمي" />

                        <JetInput v-model="addData.acadimyId" type="number" class="mt-1 block"
                            placeholder="الرقم الاكاديمي" />

                        <JetInputError :message="addDataError.acadimyId[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الايميل" />

                        <JetInput v-model="addData.email" type="email" class="mt-1 block" placeholder="الايميل" />

                        <JetInputError :message="addDataError.email[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="كلمة المرور" />

                        <JetInput v-model="addData.password" type="password" class="mt-1 block"
                            placeholder="كلمة المرور" />

                        <JetInputError :message="addDataError.password[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <div class="w-full bg-white h-20 overflow-auto">
                            <JetLable class="mb-2 w-full flex items-center" v-for="(item, i) in roles" :key="i">
                                <div class="flex items-center">
                                    <input v-model="addData.roles[item.id]" type="checkbox"
                                        class="mx-1 block rounded-md " />
                                    <span>{{ item.name }}</span>
                                </div>
                            </JetLable>
                        </div>

                        <JetInputError :message="addDataError.roles[0]" class="mt-2" />
                    </div>


                </div>

            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <JetPrimaryButton @click="store">
                        حفظ
                    </JetPrimaryButton>
                    <JetSecondaryButton @click="$emit('closeModel')">
                        الغاء
                    </JetSecondaryButton>
                </div>
            </template>
        </MyForm>

        <!-- edit from -->
        <MyForm show-btn-classes="w-full" :show="showForm.update">
            <!-- show-button -->
            <template #show>
                <!-- for loop from classes -->

            </template>
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.name"> </h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الاسم" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block" placeholder="الاسم" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الرقم الاكاديمي" />

                        <JetInput v-model="editData.acadimyId" type="number" class="mt-1 block"
                            placeholder="الرقم الاكاديمي" />

                        <JetInputError :message="editDataError.acadimyId[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الايميل" />

                        <JetInput v-model="editData.email" type="text" class="mt-1 block" placeholder="الايميل" />

                        <JetInputError :message="editDataError.email[0]" class="mt-2" />
                    </div>
                    <!-- <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="كلمة المرور" />

                        <JetInput v-model="editData.password" type="password" class="mt-1 block"
                            placeholder="كلمة المرور" />

                        <JetInputError :message="editDataError.password[0]" class="mt-2" />
                    </div> -->
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <div class="w-full bg-white h-20 overflow-auto">
                            <JetLable class="mb-2 w-full flex items-center" v-for="(item, i) in roles" :key="i">
                                <div class="flex items-center">
                                    <input v-model="checkRole[item.id]" type="checkbox"
                                        class="mx-1 block rounded-md " />
                                    <span>{{ item.name }}</span>
                                </div>
                            </JetLable>
                        </div>

                        <JetInputError :message="editDataError.roles[0]" class="mt-2" />
                    </div>


                </div>
            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <div>
                        <JetPrimaryButton @click="update" class="mx-5">
                            حفظ
                        </JetPrimaryButton>
                        <JetDangButton v-if="editData.id != 1" @click="deleteFun" class="mx-5">
                            حذف
                        </JetDangButton>
                    </div>
                    <JetSecondaryButton @click="showForm.update = false">
                        الغاء
                    </JetSecondaryButton>
                </div>
            </template>
        </MyForm>
    </div>
</template>

<script>
import AppLayoutVue from '@/Layouts/AppLayout.vue'
import MyForm from '../../components/my_form.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetPrimaryButton from '@/Jetstream/PrimaryButton.vue'
import JetDangButton from '@/Jetstream/DangerButton.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetLable from '@/Jetstream/Label.vue'
import axios from 'axios'

export default {
    components: {
        AppLayoutVue,
        MyForm,
        JetInput,
        JetInputError,
        JetPrimaryButton,
        JetSecondaryButton,
        JetDangButton,
        JetLable,
    },
    props: {
        getData: {
            type: Array,
            default: [{
                id: 1,
                acadimyId: 12345,
                name: 'root',
                email: 'email@gmail.com',
                type: 'admin',
                promissions: [
                    'reed',
                    'write'
                ]
            }]
        },
        roles: [],
        addForm: false,
        updateForm: false,
    },
    data() {
        return {
            promissions: [],
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                acadimyId: [''],
                name: [''],
                email: [''],
                password: [''],
                roles: ['']
            },
            editData: {
                acadimyId: '',
                name: '',
                email: '',
                password: '',
                roles: []
            },
            addData: {
                acadimyId: '',
                name: '',
                email: '',
                password: '',
                roles: []
            },
            addDataError: {
                acadimyId: [''],
                name: [''],
                email: [''],
                password: [''],
                roles: ['']
            },
            showData: this.getData,
            checkRole: [],
        }
    },
    watch: {
        addForm: function (nv, ov) {
            this.showForm.add = nv
        },
        updateForm: function (nv, ov) {
            this.showForm.update = nv
        },
        getData: function (nv, ov) {
            this.showData = nv
        },
    },
    methods: {
        editForm(id) {
            this.editData = this.showData.find(item => item.id === id)
            for (const role of this.roles) {
                this.checkRole[role.id] = this.editData.type.includes(role.name)
            }
            this.showForm.update = true
        },
        store() {
            axios.post(route('user.store'), {
                name: this.addData.name,
                acadimyId: this.addData.acadimyId,
                roles: this.addData.roles,
                email: this.addData.email,
                password: this.addData.password,
            }).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    acadimyId: '',
                    name: '',
                    email: '',
                    password: '',
                    roles: []
                }
                this.addDataError = {
                    acadimyId: [''],
                    name: [''],
                    email: [''],
                    password: [''],
                    roles: ['']
                }
            }).catch(er => {

            })
        },
        update() {
            axios.post(route('user.update', { id: this.editData.id }), {
                name: this.editData.name,
                acadimyId: this.editData.acadimyId,
                roles: this.checkRole,
                email: this.editData.email,
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id == this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    acadimyId: '',
                    name: '',
                    email: '',
                    password: '',
                    roles: []
                }
                this.editDataError = {
                    acadimyId: [''],
                    name: [''],
                    email: [''],
                    password: [''],
                    roles: ['']
                }
            }).catch(er => {

            })
        },
        deleteFun() {
            axios.get(route('user.delete', { id: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id != this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    acadimyId: '',
                    name: '',
                    email: '',
                    password: '',
                    roles: []
                }
                this.editDataError = {
                    acadimyId: [''],
                    name: [''],
                    email: [''],
                    password: [''],
                    roles: ['']
                }
            }).catch(er => {

            })
        }
    }

}
</script>

<style>
</style>
