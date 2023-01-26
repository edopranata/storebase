import './bootstrap';
import '../css/app.css';
import '@vueform/multiselect/themes/default.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Notifications from '@kyvg/vue3-notification'
import number from '@coders-tm/vue-number-format'

import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Guest from '@/Layouts/Guest.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.then((module) => {
            if (name.startsWith('Auth') || name.startsWith('Welcome')) {
                module.default.layout = module.default.layout || Guest;
            } else {
                module.default.layout = module.default.layout || AuthenticatedLayout;
            }
        });
        return page;
    },
    progress: {
        color: '#581c87',
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Notifications)
            .use(number)
            .mount(el);
    },
});
