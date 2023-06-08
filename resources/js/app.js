import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';

import UsersTable from './components/UsersTable.vue';

createApp({
    components: {
        'example-component': ExampleComponent
    }
}).mount('#app');
createApp({
    components: {
        'users-table': UsersTable
    }
}).mount('#appmap');
