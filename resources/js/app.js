import 'vite/dynamic-import-polyfill';

import '../css/app.css';

import './bootstrap';

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const el = document.getElementById('app');

const pages = import.meta.globEager('./Pages/**/*.vue');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => {
                return pages[`./Pages/${name}.vue`].default;
            },
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .mount(el);

InertiaProgress.init({ color: '#0b9e70' });
