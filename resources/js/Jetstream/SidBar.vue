<template>
    <div>
        <div v-for="(item, i) in links" :key="i" class="w-full text-sm h-auto rounded-b-lg text-center px-auto p-2">
            <!-- Navigation Links -->

            <div @click="active(item)"
                :class="item.isShow ? 'bg-gray-300 text-gray-900' : ' hover:bg-gray-100 hover:text-gray-500 '"
                class="h-auto w-full text-center py-2 cursor-pointer rounded-md">
                {{ item.title }}
            </div>

            <div v-if="item.subUrl" :class="item.isShow ? ' h-auto bg-gray-100 rounded-b-lg' : ' h-0 '"
                class="transition-all block duration-300 ease-linear w-full items-center justify-center">
                <div class="mx-auto w-full">
                    <div @click="active(subItem)" v-for="(subItem, k) in item.subUrl" :key="k"
                        :style="item.isShow ? 'font-size:10pt' : 'font-size:0pt'"
                        :class="item.isShow ? `${subItem.isShow ? ' bg-primary text-white' : ''} 'h-10 py-2 my-1 '` : ' h-0 '"
                        class=" rounded-lg cursor-pointer text-center w-full px-auto items-center justify-center transition-all block duration-300 ease-linear hover:text-gray-50 hover:bg-primary focus:outline-none focus:text-gray-50 "
                        v-text="subItem.title">
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import NavLink from '../Jetstream/NavLink.vue';

export default {
    data() {
        return {
            links: [
                {
                    type: "DASHBOARD",
                    title: "Dashboard",
                    isShow: false,
                    subUrl: []
                },
                {
                    type: "CONTENT",
                    title: "ادارة المحتوى",
                    isShow: false,
                    subUrl: [
                        {title: 'التحاليل', type: 'ANALYSIS', isShow: false},
                        {title: 'الجرعات', type: 'DOSE', isShow: false},
                        {title: 'الكشف المبكر', type: 'DETECTION', isShow: false},
                        {title: 'الانشطة والفعاليات', type: 'ACTIVITIES', isShow: false},
                        {title: 'معلومات التطبيق', type: 'APP_INFO', isShow: false},
                    ]
                },
                {
                    type: "TYPES",
                    title: "ادارة الانواع",
                    isShow: false,
                    subUrl: [
                        {title: 'انواع التحاليل', type: 'ANALYSIS_TYPE', isShow: false},
                        {title: 'انواع الجرعات', type: 'DOSE_TYPE', isShow: false},
                        {title: 'انواع الكشف', type: 'DEDICATION_TYPE', isShow: false},
                        {title: 'انواع الانشطة', type: 'ACTIVITIES_TYPE', isShow: false},
                    ]
                },
                {
                    type: "REPORTS",
                    title: "التقارير",
                    isShow: false,
                    subUrl: [
                        {title: 'الدعم النفسي', type: 'PSYCHOLOGICAL_AID', isShow: false},
                        {title: 'اصدقاء مرضى السرطان', type: 'PATIENT_FRIENDS', isShow: false},
                    ]
                },
                {
                    type: "USERS",
                    title: "ادارة المستحدمين",
                    subUrl: [
                        {title: 'المستخدمين', type: "USER", isShow: false},
                        {title: "انواع المستخدمين", type: 'ROLE', isShow: false},
                        {title: "الصلاحيات", type: 'PERMISSION', isShow: false},
                    ],
                },
            ],
            isType: {}
        }
    },
    components: {NavLink},
    created() {
        this.active(this.links[0])
    },
    methods: {
        active(item) {
            this.links = this.links.map(v => {
                let subShow = false
                v.subUrl.map(value => {
                    value.isShow = value.type === item.type
                    if (value.type === item.type) {
                        subShow = true
                    }
                    return value
                })
                if (!subShow) {
                    v.isShow = v.type === item.type
                }
                return v
            })
            this.$emit('getRecord', item);
        }
    }
}
</script>

<style>
</style>
