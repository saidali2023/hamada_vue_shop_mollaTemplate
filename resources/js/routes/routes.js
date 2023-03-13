import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import ExampleComponent from '../components/ExampleComponent.vue'
import FrontMain from '../components/FrontMain.vue'
import GlobalHome from '../components/GlobalHome.vue'

const routes = [
    { path: '/myexampppp', component: ExampleComponent, name: 'ExampleComponent' },
    { path: '/frontmain', component: FrontMain, name: 'FrontMain' },
    { path: '/globalhome', component: GlobalHome, name: 'GlobalHome' },
];

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history'
})

export default router;
