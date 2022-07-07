<template>
    <div class="bg-white h-[80vh] min-w-[80vw] overflow-auto shadow-xl sm:rounded-lg px-6">
        <!-- top -->
        <div class="w-full border-b-2 h-1/5 mt-2">
            <div v-if="isType !== 'معلومات التطبيق'" class="flex w-full items-center justify-between text-sm">
                <div class="flex items-center justify-around text-sm">
                    <div class="flex items-center mx-1">
                        <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType.title}`"/>
                    </div>
                    <SecondaryButton class="mx-1" @click="getRecords(searchData,type)">بحث</SecondaryButton>
                </div>
            </div>
            <div></div>
        </div>

        <report :getData="showData.data"/>
    </div>

</template>

<script>
import SecondaryButton from "../../Jetstream/SecondaryButton";
import PrimaryButton from "../../Jetstream/PrimaryButton";
import Report from "../components/reports/report";
import JetInput from "../../Jetstream/Input";

export default {
    name: "reports",
    components: {Report, PrimaryButton, SecondaryButton, JetInput},
    props: {
        getData: [],
        type: {},
        getRecords:()=>{}
    },
    data() {
        return {
            isType: this.type,
            showData: {},
            searchData: ''
        };
    },
    created() {
        this.showData['data'] = this.getData
    },
    watch: {
        getData: function (nv, ov) {
            this.showData['data'] = nv
        },
        type: function (nv, ov) {
            this.isType = nv
        },
    },
}
</script>

<style scoped>
</style>
