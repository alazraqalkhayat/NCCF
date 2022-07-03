<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                <span v-text="'id'" class="mx-auto w-1/6 text-gray-600"></span>
                <span v-text="'الاسم'" class="mx-auto w-1/6 text-gray-600"></span>
                <span v-text="'النوع'" class="mx-auto w-1/6 text-gray-600"></span>
                <span v-text="'التاريخ'" class="mx-auto w-1/6 text-gray-600"></span>
                <span v-text="'الحالة'" class="mx-auto w-1/6 text-gray-600"></span>
            </div>
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-gray-900 hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span v-text="'#' + item.id" class="mx-auto w-1/6 "></span>
                    <span v-text="item.patient" class="mx-auto w-1/6 "></span>
                    <span v-text="item.type" class="mx-auto w-1/6 "></span>
                    <span v-text="item.date" class="mx-auto w-1/6 "></span>
                    <span v-text="item.status" class="mx-auto w-1/6 "></span>
                </div>
            </div>
        </div>

        <!-- add from -->
        <MyForm :show="showForm.add">
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.date"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="التاريخ" />

                        <JetInput v-model="addData.date" type="date" class="mt-1 block" placeholder="التاريخ" />

                        <JetInputError :message="addDataError.date[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="المريض" />

                        <select v-model="addData.patient"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm"
                                v-for="(item, index) in showRoles.patient" :key="index" :value="item.id"
                                v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.patient[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <select v-model="addData.type"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in showRoles.type"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.type[0]" class="mt-2" />
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
        <MyForm :show="showForm.update">
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.date"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="التاريخ" />

                        <JetInput v-model="editData.date" type="date" class="mt-1 block" placeholder="التاريخ" />

                        <JetInputError :message="editDataError.date[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="المريض" />

                        <select v-model="editData.patient"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.patient"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.patient[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الحالة" />

                        <select @change="havReason" v-model="editData.status"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.status"
                                :key="index" :value="item.id" v-text="item.status"></option>
                        </select>

                        <JetInputError :message="editDataError.status[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <select v-model="editData.type"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.type"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.type[0]" class="mt-2" />
                    </div>
                </div>

                <div v-if="showReason" dir="rtl" class="w-full">
                    <JetLable class="mb-2" value="السبب" />

                    <textarea v-model="editData.reason"
                        class="border-gray-300 w-full h-32 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        placeholder="السبب" />

                    <!--                    <JetInputError :message="editDataError.aboutUs[0]" class="mt-2"/>-->
                </div>
            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <div>
                        <JetPrimaryButton @click="update" class="mx-5">
                            حفظ
                        </JetPrimaryButton>
                        <JetDangButton @click="deleteFun" class="mx-5">
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
            default: []
        },
        roles: {
            type: Object,
            default: {
                status: [{
                    id: '',
                    name: ''
                }],
                type: [
                    {
                        id: '',
                        name: ''
                    }
                ],
                patient: [
                    {
                        id: '',
                        name: ''
                    }
                ]
            }
        },
        addForm: false,
        updateForm: false,
        type: '',
    },
    data() {
        return {
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                date: [''],
                patient: [''],
                type: [''],
                status: [''],
            },
            editData: {
                date: '',
                patient: '',
                type: '',
                status: '',
            },
            addData: {
                date: '',
                patient: '',
                type: '',
                status: '',
            },
            addDataError: {
                date: [''],
                patient: [''],
                type: [''],
                status: [''],

            },
            showData: this.getData,
            showRoles: this.roles,
            checkRole: [],
            isType: this.type,
            showReason: false,
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

        roles: function (nv, ov) {
            this.showRoles = nv
        },
        type: function (nv, ov) {
            this.isType = nv
        }
    },
    methods: {
        store() {
            axios.post(route('a.d.d.store', { type: this.isType }), {
                date: this.addData.date,
                type: this.addData.type,
                patient: this.addData.patient,
                reason: this.showReason ? this.editData.reason : null
            }).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    date: '',
                    patient: [''],
                    type: [''],
                    status: ''
                }
                this.addDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                    status: ['']
                }
                this.editData = {
                    date: '',
                    patient: [''],
                    type: [''],
                    status: ''
                }
                this.editDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                    status: ['']
                }
                return this.$notify({
                    title: 'تم',
                    text: 'كل شيئ على مايرام',
                    type: 'success',
                })

            }).catch(er => {
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
                console.log(er)
            })
        },
        editForm(id) {
            let showDataIndex = this.showData.findIndex(v => v.id == id);
            this.editData = this.showData[showDataIndex]
            this.showRoles.type.map(v => {
                if (this.editData.type == v.name) this.editData.type = v.id
                return v
            })
            this.showRoles.patient.map(v => {
                if (this.editData.patient == v.name) this.editData.patient = v.id
                return v
            })
            this.showRoles.status.map(v => {
                if (this.editData.status == v.status) this.editData.status = v.id
                return v
            })
            this.havReason()
            this.showForm.update = true
        },
        update() {
            axios.post(route('a.d.d.update', { id: this.editData.id, type: this.isType }), {
                date: this.editData.date,
                type: this.editData.type,
                patient: this.editData.patient,
                status: this.editData.status,
                reason: this.showReason ? this.editData.reason : null
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id == this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.addData = {
                    date: '',
                    patient: [''],
                    type: [''],
                    status: ''
                }
                this.addDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                    status: ['']
                }
                this.editData = {
                    date: '',
                    patient: [''],
                    type: [''],
                    status: ''
                }
                this.editDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                    status: ['']
                }
                return this.$notify({
                    title: 'تم',
                    text: 'كل شيئ على مايرام',
                    type: 'success',
                })

            }).catch(er => {
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
                console.log(er)
            })
        },
        deleteFun() {
            axios.get(route('a.d.d.delete', { id: this.editData.id, type: this.isType })).then(r => {
                this.showData = this.showData.filter(v => v.id != this.editData.id)
                this.showForm.update = false;
                this.addData = {
                    date: '',
                    patient: [''],
                    type: [''],
                    status: ''
                }
                this.addDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                    status: ['']
                }
                this.editData = {
                    date: '',
                    patient: [''],
                    type: [''],
                    status: ''
                }
                this.editDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                    status: ['']
                }
                return this.$notify({
                    title: 'تم',
                    text: 'كل شيئ على مايرام',
                    type: 'success',
                })
            }).catch(er => {
                console.log(er)
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
            })
        },
        havReason() {
            this.showReason = this.roles.status[this.roles.status.findIndex(v => v.id == this.editData.status)].status == 'CANCEL'
        }
    }
}
</script>
