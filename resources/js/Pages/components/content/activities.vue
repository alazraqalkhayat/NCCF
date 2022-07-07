<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                <span v-text="'id'" class="mx-auto w-10 text-gray-600"></span>
                <span v-text="'النوع'" class="mx-auto max-w-full text-gray-600"></span>
            </div>
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div
                    class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-gray-900 hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span v-text="'#' + item.id" class="mx-auto w-10 "></span>
                    <span v-text="item.type" class="mx-auto max-w-full "></span>
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
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.date"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="w-full grid grid-cols-2 gap-6">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="النوع"/>

                        <select v-model="addData.type"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.type"
                                    :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.type[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full h-72">
                        <JetLabel class="mb-2" value="الصورة او الفيديو"/>

                        <input type="file" accept="image/*,video/*"
                               class="file:bg-indigo-100 file:border-none border-none file:outline-hidden outline-hidden file:rounded-lg file:hover:text-white file:hover:bg-indigo-800  p-1  focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                               @change="setImage" placeholder="الملف"/>

                        <JetInputError :message="addDataError.path[0]" class="mt-2"/>
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
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.date"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="w-full grid grid-cols-2 gap-6">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="النوع"/>

                        <select v-model="editData.type"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                            <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in roles.type"
                                    :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.type[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full h-72">
                        <JetLabel class="mb-2" value="الصورة او الفيديو"/>

                        <input type="file" accept="image/*,video/*"
                               class="file:bg-indigo-100 file:border-none border-none file:outline-hidden outline-hidden file:rounded-lg file:hover:text-white file:hover:bg-indigo-800  p-1  focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                               @change="setImage" placeholder="الملف"/>

                        <JetInputError :message="editDataError.path[0]" class="mt-2"/>
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
import AppLayoutVue from '../../../Layouts/AppLayout.vue'
import MyForm from '../../components/my_form.vue'
import JetInput from '../../../Jetstream/Input.vue'
import JetInputError from '../../../Jetstream/InputError.vue'
import JetPrimaryButton from '../../../Jetstream/PrimaryButton.vue'
import JetDangButton from '../../../Jetstream/DangerButton.vue'
import JetSecondaryButton from '../../../Jetstream/SecondaryButton.vue'
import JetLabel from '../../../Jetstream/Label.vue'
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
                path: '',
                type: 'root',
            }]
        },
        roles: {
            type: Object,
            default: {
                type: [],
            }
        },
        addForm: false,
        updateForm: false,
    },
    data() {
        return {
            image: this.getData[0].path,
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                path: [''],
                type: [''],
            },
            editData: {
                path: '',
                type: [''],
            },
            addData: {
                path: '',
                type: [''],
            },
            addDataError: {
                path: [''],
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
            for (const item of this.showData) {
                if (item.id === id) {
                    this.editData = {
                        id: item.id,
                        path: item.path,
                        type: this.roles.type.filter(val => val.name === item.type)[0]?.id,
                    }
                    break;
                }
            }
            this.image = '/' + this.editData.path
            this.showForm.update = true
        },
        store() {
            let form = new FormData();
            form.append('path', this.addData.path)
            form.append('type', this.addData.type)
            form.append('fileType', this.addData.path.type.includes('image') ? 'image' : 'video')
            axios.post(route('activity.store'), form).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    path: '',
                    type: [''],
                }
                this.addDataError = {
                    path: [''],
                    type: ['']
                }
                this.$notify({
                    title: 'تم',
                    text: 'تمت العملية بنجاح',
                    type: 'success',
                });

            }).catch(er => {
                console.log(er)
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
            })
        },
        update() {
            let form = new FormData();
            form.append('path', this.editData.path)
            form.append('type', this.editData.type)
            form.append('fileType', this.editData.path.type.includes('image') ? 'image' : 'video')
            axios.post(route('activity.update', {activity: this.editData.id}), form).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id === this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    path: '',
                    type: [''],
                }
                this.editDataError = {
                    path: [''],
                    type: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'تمت العملية بنجاح',
                    type: 'success',
                });
            }).catch(er => {
                console.log(er)
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn'
                });
            })
        },
        deleteFun() {
            axios.get(route('activity.delete', {activity: this.editData.id})).then(r => {
                this.showData = this.showData.filter(v => v.id !== this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    path: '',
                    type: [''],
                }
                this.editDataError = {
                    path: [''],
                    type: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'تمت العملية بنجاح',
                    type: 'success',
                });
            }).catch(er => {
                console.log(er)
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
            })
        },
        setImage(e) {
            console.log(e.target.files[0])
            this.addData.path = e.target.files[0]
            this.editData.path = e.target.files[0]
        }
    }

}
</script>

<style>
</style>
