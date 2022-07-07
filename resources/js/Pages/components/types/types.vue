<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                <span v-text="'id'" class="mx-auto w-1/5 text-gray-600"></span>
                <span v-text="'الاسم'" class="mx-auto w-1/5 text-gray-600"></span>
            </div>
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-gray-900 hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span v-text="'#' + item.id" class="mx-auto w-1/5 "></span>
                    <span v-text="item.name" class="mx-auto w-1/5 "></span>
                </div>
            </div>
        </div>

        <!-- add from -->
        <MyForm :show="showForm.add">
            <!-- show-button -->
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.name"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الاسم" />

                        <JetInput v-model="addData.name" type="text" class="mt-1 block" placeholder="الاسم" />

                        <JetInputError :message="addDataError.name[0]" class="mt-2" />
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
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.name"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class=" my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الاسم" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block" placeholder="الاسم" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
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
import JetLabel from '@/Jetstream/Label.vue'
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
        JetLabel,
    },
    props: {
        getData: {
            type: Array,
            default: [{
                id: 1,
                name: 'root',
            }]
        },
        type: {
            type: String,
            default: 'types'
        },
        addForm: false,
        updateForm: false,
    },
    data() {
        return {
            isType: this.type,
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                name: [''],
            },
            editData: {
                name: '',
            },
            addData: {
                name: '',
            },
            addDataError: {
                name: [''],
            },
            type: {
                type: String,
                default: ''
            },
            showData: this.getData,
            showRoles: this.roles,
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
        roles: function (nv, ov) {
            this.showRoles = nv
        },
        type: function (nv, ov) {
            this.isType = nv
        }
    },
    methods: {
        editForm(id) {
            this.editData = this.showData.find(item => item.id === id)
            this.showForm.update = true
        },
        store() {
            axios.post(route('types.store'), {
                name: this.addData.name,
                type: this.isType,
            }).then(r => {
                this.showData.push(r.data.data[0])
                this.$emit('closeModel')
                this.addData = {
                    name: '',
                }
                this.addDataError = {
                    name: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'تمت العملية بنجاح',
                    type: 'success',
                });
            }).catch(er => {
                this.addDataError.name = er.response.data.errors.name
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn'
                });
            })
        },
        update() {
            axios.post(route('types.update', { id: this.editData.id }), {
                name: this.editData.name,
                type: this.isType,
            }).then(r => {
                console.log(r.data)
                this.showData = this.showData.map(item => {
                    if (item.id === this.editData.id) {
                        return r.data.data[0]
                    }
                    return item
                })
                this.showForm.update = false;
                this.editData = {
                    name: '',
                }
                this.editDataError = {
                    name: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'تمت العملية بنجاح',
                    type: 'success',
                });
            }).catch(er => {
                this.editDataError.name = er.response.data.errors.name
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn'
                });
            })
        },
        deleteFun() {
            axios.post(route('types.delete', { id: this.editData.id }), {
                type: this.isType
            }).then(r => {
                this.showData = this.showData.filter(item => item.id !== this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    name: '',
                }
                this.editDataError = {
                    name: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'تمت العملية بنجاح',
                    type: 'success',
                });
            }).catch(er => {
                this.editDataError.name = er.response.data.errors.name
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn'
                });
            })
        }
    }

}
</script>

<style>
</style>
