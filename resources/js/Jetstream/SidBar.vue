<template>
    <div>
        <div v-for="(item, i) in links" :key="i"
            class="w-full h-12 rounded-lg text-center px-auto py-2 flex items-center justify-center">
            <!-- Navigation Links -->
            <NavLink :href="route(item.url)" :active="route().current(item.url)"
                @click="item.isShow = route().current(item.url)">
                <span>{{ item.title }}</span>
            </NavLink>
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
                    url: "dashboard",
                    title: "Dashboard",
                    isShow: false,
                    subUrl: null
                },
                {
                    url: "content.index",
                    title: "ادارة المحتوى",
                    isShow: false,
                    subUrl: null
                },
                {
                    url: "types.index",
                    title: "ادارة الانواع",
                    isShow: false,
                    subUrl: null
                },
                {
                    url: "reports.index",
                    title: "التقارير",
                    isShow: false,
                    subUrl: null
                },
                {
                    url: "user.index",
                    title: "ادارة المستحدمين",
                    subUrl: {
                        user: {
                            url: "user.index",
                            title: "User"
                        },
                        role: {
                            url: "user.role",
                            title: "User"
                        },
                        promission: {
                            url: "user.promission",
                            title: "User"
                        },
                    },
                    isShow: false
                },
            ]
        }
    },
    components: { NavLink }
}
</script>

<style>
</style>
