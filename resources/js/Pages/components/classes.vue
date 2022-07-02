<template>
    <AppLayoutVue title="Classes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                المحاضرة
            </h2>
        </template>
        <div class="bg-white h-[80vh] min-w-[60vw] overflow-auto shadow-xl sm:rounded-lg px-6">

            <!-- filter -->
            <div class="w-full border-b-2 h-1/5 flex items-center justify-between">
                <div class="flex items-center justify-around text-sm">
                    <div class="flex items-center">
                        <JetInput v-model="searchData" type="number" class="m-1 block h-8 w-32"
                            placeholder="رقم المحاضرة" />
                    </div>
                    <div class="flex items-center">
                        <snap class="mx-2"> من :</snap>
                        <JetInput v-model="start_time" type="time" class="m-1 block h-8" placeholder="البحث" />
                    </div>
                    <div class="flex items-center">
                        <snap class="mx-2"> الى :</snap>
                        <JetInput v-model="end_time" type="time" class="m-1 block h-8" placeholder="البحث" />
                    </div>
                    <div class="flex items-center">
                        <snap class="mx-2"> التاريخ :</snap>
                        <JetInput v-model="date" type="date" class="m-1 block h-8" placeholder="البحث" />
                    </div>
                    <button class="py-2 px-4 mx-2 bg-gray-500 text-white hover:bg-gray-800 rounded-lg"
                        @click="getRecords">بحث</button>
                </div>

                <button @click="showForm.add = true"
                    class="flex items-center justify-center rounded-md text-white bg-indigo-500 hover:bg-indigo-900 p-2 focus:outline-none focus:bg-indigo-800 transition duration-150 ease-in-out">
                    اظافة
                    <!-- <svg class="h-6 w-6 flex items-center justify-center" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v8m0 0v8m0-8h8m-8 0H4" />
                    </svg> -->
                </button>
            </div>

            <!-- tables -->
            <div class="w-full h-[60vh]">
                <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                    <snap v-text="'id'" class="mx-auto w-1/6 text-gray-600"></snap>
                    <snap v-text="'الاسم'" class="mx-auto w-1/6 text-gray-600"></snap>
                    <snap v-text="'المسار'" class="mx-auto w-1/6 text-gray-600"></snap>
                    <snap v-text="'الحالة'" class="mx-auto w-1/6 text-gray-600"></snap>
                    <snap v-text="'وقد البدا'" class="mx-auto w-1/6 text-gray-600"></snap>
                    <snap v-text="'وقت النهاية'" class="mx-auto w-1/6 text-gray-600"></snap>
                    <snap v-text="'التاريخ'" class="mx-auto w-1/6 text-gray-600"></snap>
                </div>
                <div class="h-4/5 overflow-auto snap-y scroll-smooth">
                    <div class="flex rounded-lg items-center text-center max-h-[6vh] text-sm shadow-lg my-2 hover:bg-gray-900 hover:text-white cursor-pointer"
                        v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                        <snap v-text="'#' + item.id" class="mx-auto w-1/6 "></snap>
                        <snap v-text="item.name" class="mx-auto w-1/6 "></snap>
                        <snap v-text="item.course.name" class="mx-auto w-1/6 "></snap>
                        <snap v-text="item.status.status == 'ABSENT' ? 'غائب' : 'حاضر'" class="mx-auto w-1/6 "></snap>
                        <snap v-text="item.start_time" class="mx-auto w-1/6 "></snap>
                        <snap v-text="item.end_time" class="mx-auto w-1/6 "></snap>
                        <snap v-text="item.date" class="mx-auto w-1/6 "></snap>
                    </div>
                </div>
            </div>


            <!-- add new from -->
            <MyForm :show="showForm.add" show-btn-classes="fixed bottom-0 left-0 ml-10 mb-10">
                <!-- show-button -->
                <template #model-title>
                    <div dir="rtl" class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">
                            اظافة محاظرة
                        </h2>
                    </div>
                </template>
                <!-- model-content -->
                <template #model-content>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="اسم المحاضرة" />

                        <JetInput v-model="newData.name" type="text" class="mt-1 block w-3/4"
                            placeholder="اسم المحاضرة" />

                        <JetInputError :message="newDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full grid grid-cols-2 gap-4">
                        <div class="">
                            <JetLable class="mb-2" value="اسم الكورس" />
                            <select v-model="newData.course_id"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                                <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in courses"
                                    :key="index" :value="item.id" v-text="item.name"></option>
                            </select>
                        </div>
                        <div class="">
                            <JetLable class="mb-2" value="وقت بدا المحاظرة" />
                            <JetInput v-model="newData.start_time" type="time" class="mt-1 block w-3/4"
                                placeholder="وقت بدا المحاظرة" />

                            <JetInputError :message="newDataError.start_time[0]" class="mt-2" />
                        </div>
                        <div class="">
                            <JetLable class="mb-2" value="وقت الانتهاء" />
                            <JetInput v-model="newData.end_time" type="time" class="mt-1 block w-3/4"
                                placeholder="وقت الانتهاء" />

                            <JetInputError :message="newDataError.end_time[0]" class="mt-2" />
                        </div>
                        <div class="">
                            <JetLable class="mb-2" value="التاريخ" />
                            <JetInput v-model="newData.date" type="date" class="mt-1 block w-3/4"
                                placeholder="التاريخ" />

                            <JetInputError :message="newDataError.date[0]" class="mt-2" />

                        </div>
                    </div>
                </template>
                <template #model-footer>
                    <div dir="rtl" class="w-full flex items-center justify-between">
                        <JetPrimaryButton @click="addClass" class="mx-5">
                            حفظ
                        </JetPrimaryButton>
                        <JetSecondaryButton @click="showForm.add = false">
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
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="اسم المحاضرة" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block w-3/4"
                            placeholder="اسم المحاضرة" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full grid grid-cols-2 gap-4">
                        <div class="">
                            <JetLable class="mb-2" value="اسم الكورس" />
                            <select v-model="editData.course_id"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm max-w-full">
                                <option class="border-gray-300 rounded-md shadow-sm" v-for="(item, index) in courses"
                                    :key="index" :value="item.id" v-text="item.name"></option>
                            </select>
                        </div>
                        <div class="">
                            <JetLable class="mb-2" value="وقت بدا المحاظرة" />
                            <JetInput v-model="editData.start_time" type="time" class="mt-1 block w-3/4"
                                placeholder="وقت بدا المحاظرة" />

                            <JetInputError :message="editDataError.start_time[0]" class="mt-2" />
                        </div>
                        <div class="">
                            <JetLable class="mb-2" value="وقت الانتهاء" />
                            <JetInput v-model="editData.end_time" type="time" class="mt-1 block w-3/4"
                                placeholder="وقت الانتهاء" />

                            <JetInputError :message="editDataError.end_time[0]" class="mt-2" />
                        </div>
                        <div class="">
                            <JetLable class="mb-2" value="التاريخ" />
                            <JetInput v-model="editData.date" type="date" class="mt-1 block w-3/4"
                                placeholder="التاريخ" />

                            <JetInputError :message="editDataError.date[0]" class="mt-2" />

                        </div>
                    </div>
                </template>
                <template #model-footer>
                    <div dir="rtl" class="w-full flex items-center justify-between">
                        <div>
                            <JetPrimaryButton @click="updateClass" class="mx-5">
                                حفظ
                            </JetPrimaryButton>
                            <JetDangButton @click="deleteClass" class="mx-5">
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
    </AppLayoutVue>
</template>

<script>
import AppLayoutVue from '../../Layouts/AppLayout.vue'
import MyForm from './my_form.vue'
import JetInput from '../../Jetstream/Input.vue'
import JetInputError from '../../Jetstream/InputError.vue'
import JetPrimaryButton from '../../Jetstream/PrimaryButton.vue'
import JetDangButton from '../../Jetstream/DangerButton.vue'
import JetSecondaryButton from '../../Jetstream/SecondaryButton.vue'
import axios from 'axios'
import JetLable from '../../Jetstream/Label.vue'

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
        classes: {
            type: Array,
            default: () => [
                {
                    id: 1,
                    name: 'root'
                },
                {
                    id: 2,
                    name: 'root',
                },
                {
                    id: 3,
                    name: 'root',
                },
            ]
        },
        courses: {
            type: Array,
            default: []
        },
    },
    data() {
        return {
            showData: this.classes,
            editData: {
                name: 'root',
            },
            editDataError: {
                name: [],
                start_time: [],
                end_time: [],
                date: [],
            },
            newData: {
                name: '',
            },
            newDataError: {
                name: [],
                start_time: [],
                end_time: [],
                date: [],
            },
            showForm: {
                add: false,
                update: false
            },
            start_time: null,
            end_time: null,
            searchData: null,
            date: null,

            filterClasses: {}
        }
    },
    methods: {
        editForm(id) {
            this.editData = this.showData.find(item => item.id === id)
            this.showForm.update = true
        },
        updateClass() {
            axios.post(route('updateClasses', { id: this.editData.id })).then(r => {
                this.showForm.update = false
                console.log(r)
            }).catch(er => {
                console.log(er)
            })
        },
        addClass() {
            let form = {
                name: this.newData.name,
                start_time: this.newData.start_time,
                end_time: this.newData.end_time,
                date: this.newData.date,
                course_id: this.newData.course_id,
            }

            axios.post(route('addNewClasses'), form)
                .then(r => {
                    this.showForm.add = false
                    console.log(r)
                })
                .catch(er => {
                    console.log(er)
                })
        },
        deleteClass() {
            axios.get(route('deleteClasses', { id: this.editData.id })).then(r => {
                this.showForm.update = false
                console.log(r)
            }).catch(er => {
                console.log(er)
            })
        },
        getRecords() {
            axios.post(route('getRecourds'), {
                start_time: this.start_time,
                end_time: this.end_time,
                date: this.date,
                id: this.searchData,
            }).then(r => {
                this.showData = r.data
                console.log(r.data)
            }).catch(er => {

            })
        }
    },
}
</script>

<style>
</style>
