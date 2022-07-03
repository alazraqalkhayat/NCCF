<template>
    <AppLayoutVue :title="isType">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isType }}
            </h2>
        </template>
        <div class="bg-white h-[80vh] min-w-[80vw] overflow-auto shadow-xl sm:rounded-lg px-6">
            <!-- filter -->
            <div class="w-full border-b-2 h-1/5 flex items-center justify-between">
                <div class="flex items-center justify-around text-sm">
                    <div v-for="item in type" @click="active(item.title)" :key="item"
                        :class="`mx-2 border-t border-r border-l  rounded-t-md cursor-pointer px-4 py-1 ${item.title == isType ? 'bg-gray-500 text-white' : ''}`">
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

            <Users v-if="isType == 'users'" :getData="showData.data" :addForm="showForm.add"
                :updateForm="showForm.update" :roles="showData.roles"
                @closeModel="showForm.update = false; showForm.add = false" :editData="editData" :editForm="editForm" />
            <Role v-if="isType == 'role'" :getData="showData.data" :addForm="showForm.add" :updateForm="showForm.update"
                :roles="showData.roles" @closeModel="showForm.update = false; showForm.add = false" :editData="editData"
                :editForm="editForm" />
            <Promission v-if="isType == 'permission'" :getData="showData.data" :addForm="showForm.add"
                :updateForm="showForm.update" :roles="showData.roles"
                @closeModel="showForm.update = false; showForm.add = false" :editData="editData" :editForm="editForm" />
        </div>

    </AppLayoutVue>
</template>

<script>
import AppLayoutVue from '../../Layouts/AppLayout.vue'
import Users from '../components/users/users.vue'
import PrimaryButton from '../../Jetstream/PrimaryButton.vue'
import SecondaryButton from '../../Jetstream/SecondaryButton.vue'
import JetInput from '../../Jetstream/Input.vue'
import Role from '../components/users/role.vue'
import Promission from '../components/users/promission.vue'

export default {
    components: {
        AppLayoutVue,
        Users,
        PrimaryButton,
        SecondaryButton,
        JetInput,
        Role,
        Promission
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
                { title: 'users', url: 'user.' },
                { title: 'role', url: 'role.' },
                { title: 'permission', url: 'permission.' },
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
            axios.post(route('user.getRecourds'), {
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
