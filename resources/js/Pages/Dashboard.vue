<template>
    <AppLayout :title="type.title" :get-records="setType">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ type.title }}
            </h2>
        </template>

        <div class="bg-white h-[80vh] overflow-auto shadow-xl sm:rounded-lg">
            <Welcome v-if="type.type === 'DASHBOARD'"/>

            <content v-if="['CONTENT','ANALYSIS','DOSE','DETECTION','ACTIVITIES','APP_INFO'].includes(type.type)"
                     :get-records="getRecords"
                     :getData="mainData"
                     :type="type"
            />
            <types v-if="['TYPES','ANALYSIS_TYPE','DOSE_TYPE','DEDICATION_TYPE','ACTIVITIES_TYPE'].includes(type.type)"
                   :get-records="getRecords"
                   :get-data="mainData.data"
                   :roles="mainData.roles"
                   :type="type"
            />

            <reports v-if="['REPORTS','PSYCHOLOGICAL_AID','PATIENT_FRIENDS'].includes(type.type)"
                     :get-records="getRecords"
                     :get-data="mainData.data"
                     :type="type"
            />

            <users v-if="['USER','PERMISSION','ROLE','USERS'].includes(type.type)"
                   :get-data="mainData.data"
                   :roles="mainData.roles"
                   :type="type"
                   :get-records="getRecords"
            />
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '../Layouts/AppLayout.vue';
import Welcome from '../Jetstream/Welcome.vue';
import Content from "./Dashboard/content";
import Types from "./Dashboard/types";
import Reports from "./Dashboard/reports";
import Users from "./Dashboard/users";

export default {
    components: {
        Users,
        Reports,
        Types,
        Content,
        AppLayout,
        Welcome,
    },
    data() {
        return {
            type: {},
            mainData: {},
        };
    },
    created() {
    },
    methods: {
        async setType(v) {
            await this.getRecords('', v)
            this.type = v
        },
        getRecords(name, type) {
            axios.post(route('main.getRecords'), {
                name: name,
                type: type.type
            }).then(r => {
                this.mainData = r.data
                console.log('get', r.data)
            }).catch(er => {
                console.log(er)
            })

        }
    }
}

</script>
