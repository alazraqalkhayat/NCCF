<template>
    <AppLayoutVue title="Classes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                المحاضرة
            </h2>
        </template>
        <div class="bg-white h-[80vh] min-w-[80vw] overflow-auto shadow-xl sm:rounded-lg px-6">
            <!-- top -->
            <div  class="w-full border-b-2 h-1/5 mt-2">
                <div v-if="isType !== 'معلومات التطبيق'" class="flex w-full items-center justify-between text-sm">
                    <div class="flex items-center justify-center" >
                        <div class="flex items-center mx-1">
                            <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType}`" />
                        </div>
                        <SecondaryButton class="mx-1" @click="getRecords">بحث</SecondaryButton>
                    </div>
                    <PrimaryButton @click="showForm.add = true" class="mx-1">اضافة</PrimaryButton>
                </div>
                <div class="flex items-center text-sm mt-2 w-full">
                    <div v-for="item in type" @click="active(item.title)" :key="item"
                         :class="`mx-2 border-t border-r border-l  rounded-t-md cursor-pointer px-4 py-1 ${item.title == isType ? 'bg-gray-500 text-white' : ''}`">
                        {{ item.title }}
                    </div>
                </div>
            </div>

            <Analysis v-if="isType === 'التحاليل'" :getData="showData.data" :addForm="showForm.add"
                :updateForm="showForm.update" :roles="showData.roles"
                @closeModel="showForm.update = false; showForm.add = false" :editData="editData" :editForm="editForm" />

            <Dose v-if="isType === 'الجرعات'" :getData="showData.data" :addForm="showForm.add" :updateForm="showForm.update"
                :roles="showData.roles" @closeModel="showForm.update = false; showForm.add = false" :editData="editData"
                :editForm="editForm" />

            <Detection v-if="isType === 'الكشف المبكر'" :getData="showData.data" :addForm="showForm.add"
                :updateForm="showForm.update" :roles="showData.roles"
                @closeModel="showForm.update = false; showForm.add = false" :editData="editData" :editForm="editForm" />

            <Activity v-if="isType === 'الانشطة والفعاليات'" :getData="showData.data" :addForm="showForm.add"
                :updateForm="showForm.update" :roles="showData.roles"
                @closeModel="showForm.update = false; showForm.add = false" :editData="editData" :editForm="editForm" />

            <app_info v-if="isType === 'معلومات التطبيق'" :getData="showData.data"
                      :updateForm="showForm.update" @closeModel="showForm.update = false; showForm.add = false" />
        </div>

    </AppLayoutVue>
</template>

<script>
import AppLayoutVue from '../../Layouts/AppLayout.vue'
import Analysis from '../components/content/analysis.vue'
import Dose from '../components/content/dose.vue'
import Detection from '../components/content/detection.vue'
import Activity from '../components/content/activities.vue'
import PrimaryButton from '../../Jetstream/PrimaryButton.vue'
import SecondaryButton from '../../Jetstream/SecondaryButton.vue'
import JetInput from '../../Jetstream/Input.vue'
import App_info from "../components/content/app_info";

export default {
    components: {
        App_info,
        AppLayoutVue,
        PrimaryButton,
        SecondaryButton,
        JetInput,
        Analysis,
        Dose,
        Detection,
        Activity
    },
    props: {
        getData: [],
        roles: [],
    },
    mounted() {
        this.isType = this.type[0].title
    },
    data() {
        return {
            searchData: '',
            showData: [],
            showForm: {
                add: false,
                update: false
            },
            type: [
                { title: 'التحاليل', url: 'analysis.' },
                { title: 'الجرعات', url: 'dose.' },
                { title: 'الكشف المبكر', url: 'detection.' },
                { title: 'الانشطة والفعاليات', url: 'activity.' },
                { title: 'معلومات التطبيق', url: 'appinfo.' },
            ],
            isType: '',
            editData: {},
        }
    },
    created() {
        this.showData['data'] = this.getData
        this.showData['roles'] = this.roles
    },
    methods: {


        getRecords() {
            axios.post(route('content.getRecords'), {
                name: this.searchData,
                type: this.isType
            }).then(r => {
                this.showData = r.data
                console.log(r.data)
            }).catch(er => {

            })
        },
        active(title) {
            this.isType = title
            this.getRecords()
        },
    },
}
</script>

<style>
</style>
