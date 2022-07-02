<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                <snap v-text="'id'" class="mx-auto w-1/5 text-gray-600"></snap>
                <snap v-text="'المريض'" class="mx-auto w-1/5 text-gray-600"></snap>
                <snap v-text="'الاسم'" class="mx-auto w-1/5 text-gray-600"></snap>
                <snap v-text="'النوع'" class="mx-auto w-1/5 text-gray-600"></snap>
                <snap v-text="'التاريخ'" class="mx-auto w-1/5 text-gray-600"></snap>
            </div>
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-gray-900 hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <snap v-text="'#' + item.id" class="mx-auto w-1/5 "></snap>
                    <snap v-text="item.patient" class="mx-auto w-1/5 "></snap>
                    <snap v-text="item.date" class="mx-auto w-1/5 "></snap>
                    <snap v-text="item.type" class="mx-auto w-1/5 "></snap>
                    <snap v-text="item.date" class="mx-auto w-1/5 "></snap>
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
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.date"> </h2>
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

                        <!-- <input v-model="addData.patient" type="text"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full"
                            list="new-patient">
                        <datalist id="new-patient">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.patient"
                                :key="index" :value="item.name" v-text="item.name"></option>
                        </datalist> -->

                        <select v-model="addData.patient"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.patient"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.patient[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <!-- <input v-model="addData.type" type="text"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full"
                            list="new-type">
                        <datalist id="new-type">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.type"
                                :key="index" :value="item.name" v-text="item.name"></option>
                        </datalist> -->

                        <select v-model="addData.type"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.type"
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
        <MyForm show-btn-classes="w-full" :show="showForm.update">
            <!-- show-button -->
            <template #show>
                <!-- for loop from classes -->

            </template>
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.date"> </h2>
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

                        <!-- <input v-model="editData.patient" type="text"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full"
                            list="edit-patient">
                        <datalist id="edit-patient">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.patient"
                                :key="index" :value="item.name" v-text="item.name"></option>
                        </datalist> -->

                        <select v-model="editData.patient"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.patient"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.patient[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <!-- <input v-model="editData.type" type="text"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full"
                            list="edit-type">
                        <datalist id="edit-type">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.type"
                                :key="index" :value="item.name" v-text="item.name"></option>
                        </datalist> -->

                        <select v-model="editData.type"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.type"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.type[0]" class="mt-2" />
                    </div>
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
            default: [{
                id: 1,
                acadimyId: 12345,
                date: 'root',
                email: 'email@gmail.com',
                type: 'admin',
                promissions: [
                    'reed',
                    'write'
                ]
            }]
        },
        roles: {
            type: Object,
            default: {
                type: [],
                patient: [],
            }
        },
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
                date: [''],
                patient: [''],
                type: [''],
            },
            editData: {
                date: '',
                patient: [''],
                type: [''],
            },
            addData: {
                date: '',
                patient: [''],
                type: [''],
            },
            addDataError: {
                date: [''],
                patient: [''],
                type: [''],
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
            this.editData['type'] = this.roles.type.find(v => v.name == this.editData.type).id
            this.editData['patient'] = this.roles.patient.find(v => v.name == this.editData.patient).id
            this.showForm.update = true
        },
        store() {
            axios.post(route('analysis.store'), {
                date: this.addData.date,
                type: this.addData.type,
                patient: this.addData.patient,
            }).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    date: '',
                    patient: [''],
                    type: [''],
                }
                this.addDataError = {
                    date: [''],
                    patient: [''],
                    type: ['']
                }
            }).catch(er => {

            })
        },
        update() {
            axios.post(route('analysis.update', { analysis: this.editData.id }), {
                date: this.editData.date,
                type: this.editData.type,
                patient: this.editData.patient,
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id == this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    date: '',
                    patient: [''],
                    type: [''],
                }
                this.editDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                }
            }).catch(er => {

            })
        },
        deleteFun() {
            axios.get(route('analysis.delete', { analysis: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id != this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    date: '',
                    patient: [''],
                    type: [''],
                }
                this.editDataError = {
                    date: [''],
                    patient: [''],
                    type: [''],
                }
            }).catch(er => {

            })
        }
    }

}
</script>

<style>
</style>
