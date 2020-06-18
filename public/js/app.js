import about      from './about.js';
import createPage from './create-page.js';
import portfolio  from './portfolio.js';
import store      from './store.js';

const routes = [
    {
        path: '/',
        component: createPage('home'),
        meta: {
            title: 'Home'
        }
    },
    {
        path: '/about',
        component: about,
        meta: {
            title: 'About Me'
        }
    },
    {
        path: '/contact',
        component: createPage('contact'),
        meta: {
            title: 'Contact Me'
        }
    },
    {
        path: '/portfolio',
        component: portfolio,
        meta: {
            title: 'My Portfolio'
        }
    },
    {
        path: "*",
        component: createPage('404'),
        meta: {
            title: '404 Not Found'
        }
    }
];

const router = new VueRouter({
    routes,
    base: '/',
    mode: 'history',
    linkExactActiveClass: "active"
});

router.afterEach(to => document.title = to.meta.title);

new Vue({router, store: store, createPage: createPage}).$mount('#root');

// https://vuejs.org/v2/guide/
// https://router.vuejs.org/guide/#html
// https://medium.com/badr-interactive/mengenal-lifecycle-hooks-pada-vue-js-78cd2225a69
// https://forum.vuejs.org/t/setting-a-correct-base-url-with-vue-router/24726/2
// https://vuejs.org/v2/guide/render-function.html#Functional-Components
// https://stackoverflow.com/questions/51548729/vuejs-vue-app-render-method-with-dynamic-template-compiled-is-throwing-some/51552701
// https://medium.com/js-dojo/how-to-permanently-save-data-with-vuex-localstorage-in-your-vue-app-f1d5c140db69
// https://javascript.info/modules-intro