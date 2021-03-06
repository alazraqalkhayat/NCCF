import './bootstrap';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import {ZiggyVue} from 'ziggy';
import Notifications from '@kyvg/vue3-notification'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, app, props, plugin}) {
        const myapp = createApp({render: () => h(app, props)});
        myapp.use(plugin)
        myapp.use(ZiggyVue, Ziggy)
        myapp.use(Notifications)
        myapp.component('Datepicker', Datepicker);
        myapp.mount(el);
        myapp.config.globalProperties['mainUrl'] = 'http://127.0.0.1:8000'
        myapp.config.globalProperties['successNotification'] = successNotification;
        myapp.config.globalProperties['errorNotification'] = errorNotification;
        return myapp;
    },
});

InertiaProgress.init({color: '#4B5563'});

function errorNotification() {
    return this.$notify({
        title: 'Error',
        text: 'حدث خطاء ما!',
        type: 'warn',
    })
}

function successNotification() {
    return this.$notify({
        title: 'تم',
        text: 'كل شيئ على مايرام',
        type: 'success',
    })
}
