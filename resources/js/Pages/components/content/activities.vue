<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                <snap v-text="'id'" class="mx-auto w-1/5 text-gray-600"></snap>
                <snap v-text="'النوع'" class="mx-auto w-2/5 text-gray-600"></snap>
                <!-- <snap v-text="'مسار الملف'" class="mx-auto w-2/5 text-gray-600"></snap> -->
            </div>
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-gray-900 hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <snap v-text="'#' + item.id" class="mx-auto w-1/5 "></snap>
                    <snap v-text="item.type" class="mx-auto w-2/5 "></snap>
                    <!-- <snap v-text="item.path" class="mx-auto w-2/5 overflow-auto"></snap> -->
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
                <div class="my-2 w-full">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <JetInput v-model="addData.type" type="text" class="mt-1 block" placeholder="التاريخ" />

                        <JetInputError :message="addDataError.type[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full h-72">
                        <JetLable class="mb-2" value="الصورة" />

                        <input id="addImage" type="file" class="mt-1 hidden" @change="setImage" placeholder="الصورة" />

                        <label for="addImage" class="w-full shadow-lg rounded-lg h-full">
                            <img :src="image" class="w-full h-full object-cover" alt="">
                        </label>

                        <JetInputError :message="addDataError.path[0]" class="mt-2" />
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
                <div class="my-2 w-full">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <JetInput v-model="editData.type" type="text" class="mt-1 block" placeholder="التاريخ" />

                        <JetInputError :message="editDataError.type[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full h-72">
                        <JetLable class="mb-2" value="الصورة" />

                        <input id="editImage" type="file" class="mt-1 hidden" @change="setImage" placeholder="الصورة" />

                        <label for="editImage" class="w-full shadow-lg rounded-lg h-full">
                            <img :src="image" class="w-full h-full object-cover" alt="">
                        </label>

                        <JetInputError :message="editDataError.path[0]" class="mt-2" />
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
                path: '',
                type: 'root',
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
            image: this.getData.path,
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
            this.editData = this.showData.find(item => item.id === id)
            this.image = '/' + this.editData.path
            this.showForm.update = true
        },
        store() {
            let form = new FormData();
            form.append('path', this.addData.path)
            form.append('type', this.addData.type)
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
                this.iamge = ''

            }).catch(er => {

            })
        },
        update() {
            let form = new FormData();
            form.append('path', this.editData.path)
            form.append('type', this.editData.type)
            axios.post(route('activity.update', { activity: this.editData.id }), form).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id == this.editData.id) v = r.data[0]
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
                this.iamge = ''
            }).catch(er => {

            })
        },
        deleteFun() {
            axios.get(route('activity.delete', { activity: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id != this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    path: '',
                    type: [''],
                }
                this.editDataError = {
                    path: [''],
                    type: [''],
                }
            }).catch(er => {

            })
        },
        setImage(e) {
            this.image = URL.createObjectURL(e.target.files[0])
            this.addData.path = e.target.files[0]
            this.editData.path = e.target.files[0]
        }
    }

}
</script>

<style>
</style>
