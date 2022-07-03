<template>
    <AppLayoutVue :title="isTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isTitle }}
            </h2>
        </template>
        <div class="bg-white h-[80vh] min-w-[80vw] overflow-auto shadow-xl sm:rounded-lg px-6">
            <!-- filter -->
            <div class="w-full border-b-2 h-1/5 flex items-center justify-between">
                <div class="flex items-center justify-around text-sm">
                    <div v-for="item in type" @click="active(item.type)" :key="item.url"
                        :class="`mx-2 border-t border-r border-l  rounded-t-md cursor-pointer px-4 py-1 ${item.type === isType ? 'bg-gray-500 text-white' : ''}`">
                        {{ item.title }}
                    </div>
                </div>
                <div class="flex items-center justify-around text-sm">
                    <div class="flex items-center mx-1">
                        <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType}`" />
                    </div>
                    <SecondaryButton class="mx-1" @click="getRecords">بحث</SecondaryButton>
                    <PrimaryButton @click="showForm.add = true" class="mx-1">اضافة</PrimaryButton>
                </div>
            </div>

            <Types :getData="showData.data" :addForm="showForm.add" :updateForm="showForm.update"
                :roles="showData.roles" :type="isType" @closeModel="showForm.update = false; showForm.add = false"
                :editData="editData" />

        </div>

    </AppLayoutVue>
</template>

<script>
import AppLayoutVue from '../../Layouts/AppLayout.vue'
import Types from '../components/types/types.vue'
import PrimaryButton from '../../Jetstream/PrimaryButton.vue'
import SecondaryButton from '../../Jetstream/SecondaryButton.vue'
import JetInput from '../../Jetstream/Input.vue'

export default {
    components: {
        AppLayoutVue,
        PrimaryButton,
        SecondaryButton,
        JetInput,
        Types
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
                { title: 'انواع التحاليل', type: 'ANALYSIS' },
                { title: 'انواع الجرعات', type: 'DOSE' },
                { title: 'انواع الكشف', type: 'DEDICATION' },
            ],
            isType: '',
            isTitle: '',
            editData: {},
        }
    },
    created() {
        this.showData['data'] = this.getData
        this.showData['roles'] = this.roles
        this.isType = this.type[0].type
    },
    methods: {


        getRecords() {
            axios.post(route('types.getRecords'), {
                name: this.searchData,
                type: this.isType
            }).then(r => {
                this.showData = r.data
                console.log(r.data)
            }).catch(er => {
                console.log(er)
            })
        },
        active(title) {
            this.isType = title
            this.type.map(v => {
                if (v.type == title) {
                    this.isTitle = v.title
                }
                return v
            })
            this.getRecords()
        },
    },
}
</script>

<style>
</style>
