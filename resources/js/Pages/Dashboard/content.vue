<template>
    <div class="bg-white h-[80vh] min-w-[80vw] overflow-auto shadow-xl sm:rounded-lg px-6">
        <!-- top -->
        <div class="w-full border-b-2 h-1/5 mt-2">
            <div v-if="isType !== 'معلومات التطبيق'" class="flex w-full items-center justify-between text-sm">
                <div></div>
                <div class="flex items-center justify-around text-sm">
                    <div class="flex items-center mx-1">
                        <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType.title}`"/>
                    </div>
                    <SecondaryButton class="mx-1" @click="getRecords(searchData,type)">بحث</SecondaryButton>
                    <PrimaryButton @click="showForm.add = true" class="mx-1">اضافة</PrimaryButton>
                </div>
            </div>
        </div>

        <a_d_d v-if="['CONTENT', 'DOSE', 'ANALYSIS','DETECTION'].includes(isType.type)"
               @closeModel="showForm.update = false; showForm.add = false" :get-data="showData.data"
               :roles="showData.roles" :type="isType.type" :add-form="showForm.add"/>

        <Activity v-if="isType.type === 'ACTIVITIES'" :getData="showData.data" :addForm="showForm.add"
                  :updateForm="showForm.update" :roles="showData.roles"
                  @closeModel="showForm.update = false; showForm.add = false" :editData="editData"/>

        <app_info v-if="isType.type === 'APP_INFO'" :getData="showData.data" :updateForm="showForm.update"
                  @closeModel="showForm.update = false; showForm.add = false"/>
    </div>
</template>

<script>
import Activity from '../components/content/activities.vue'
import PrimaryButton from '../../Jetstream/PrimaryButton.vue'
import SecondaryButton from '../../Jetstream/SecondaryButton.vue'
import JetInput from '../../Jetstream/Input.vue'
import App_info from "../components/content/app_info";
import A_d_d from "../components/content/a_d_d";

export default {
    components: {
        A_d_d,
        App_info,
        PrimaryButton,
        SecondaryButton,
        JetInput,
        Activity
    },
    props: {
        getData: {},
        type: {},
        getRecords: () => {
        }
    },
    data() {
        return {
            searchData: '',
            showData: {},
            showForm: {
                add: false,
                update: false
            },
            isType: this.type,
            editData: {},
        }
    },
    watch: {
        type: function (nv, ov) {
            this.isType = nv
        },
        getData: function (nv, ov) {
            this.showData = nv
        },
    },
}
</script>

<style>
</style>
