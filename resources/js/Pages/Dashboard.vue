<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="bg-white h-[80vh] overflow-auto shadow-xl sm:rounded-lg">
            <Welcome/>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';

export default {
    components: {
        AppLayout,
        Welcome,
    },
    created() {
    },
    methods: {
        noti() {
            this.$notify({
                title: "Important message",
                text: "Hello user!",

                duration: 5000,
            });
        }
    }
}

</script>
