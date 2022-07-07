
<template>
    <div>
        <div @click="openModel" >
            <slot name="show" />
        </div>

        <JetDialogModal :show="dialog.show" @close="closeModal">
            <template #title>
                <slot name="model-title" />
            </template>

            <template #content>
                <slot name="model-content" />
            </template>

            <template #footer>

                <slot name="model-footer" />
            </template>
        </JetDialogModal>
    </div>

</template>
<script >
import JetDialogModal from '@/Jetstream/DialogModal.vue';

export default {
    components: {
        JetDialogModal,
    },
    props: {
        show: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            dialog: {
                show: false,
            }
        }
    },
    watch: {
        show: function (v, ov) {
            this.dialog.show = v;
        }
    },
    methods: {
        closeModal() {
            this.dialog.show = false;
        },
        openModel() {
            this.dialog.show = true;
        }
    }
}
</script>
