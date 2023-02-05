import './bootstrap';

/*require('./bootstrap');*/

//import {createApp} from 'vue'
import { createApp } from 'vue/dist/vue.esm-bundler.js';

import CostDeliveryComponent from './components/CostDeliveryComponent.vue';

const App = createApp({
    components: {
        CostDeliveryComponent
    }
});

/*import App from './App.vue'*/

App.mount("#app")
