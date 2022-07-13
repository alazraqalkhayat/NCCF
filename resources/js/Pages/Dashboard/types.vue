<template>
        <div class="bg-white h-[80vh] w-[75vw] overflow-auto shadow-xl sm:rounded-lg px-6">
            <!-- filter -->
            <div class="w-full border-b-2 h-1/5 flex items-center justify-between">
                <div></div>
                <div class="flex items-center justify-around text-sm">
                    <div class="flex items-center mx-1">
                        <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType.title}`"/>
                    </div>
                    <SecondaryButton class="mx-1" @click="getRecords(searchData,isType)">بحث</SecondaryButton>
                    <PrimaryButton @click="showForm.add = true" class="mx-1">اضافة</PrimaryButton>
                </div>
            </div>

            <Types :getData="showData.data" :addForm="showForm.add" :updateForm="showForm.update"
                   :roles="showData.roles" :type="isType.type" @closeModel="showForm.update = false; showForm.add = false"
                   :editData="editData"/>

        </div>

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
        type: {},
        getRecords:()=>{}
    },
    data() {
        return {
            searchData: '',
            showData: [],
            showForm: {
                add: false,
                update: false
            },
            isType: this.type,
            editData: {},
        }
    },
    created() {
        this.showData['data'] = this.getData
        this.showData['roles'] = this.roles
    },
    watch: {
        type: function (nv, ov) {
            this.isType = nv
        },
        getData: function (nv, ov) {
            this.showData['data'] = nv
        },
        roles: function (nv, ov) {
            this.showData['roles'] = nv
        }
    },
}
</script>
