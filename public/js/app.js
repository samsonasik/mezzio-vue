createPage = (name, object = {}, methods = {}) => {
    return Vue.component('page-' + name, {
        data: function () {
            return Object.assign({'content': ''}, object);;
        },
        mounted () {
            (new Promise( (resolve) => {
                fetch(
                    this.$route.path,
                    {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    }
                ).then(response =>  resolve(response.text()));
            })).then(result => this.content = result);
        },
        render: function (c) {
            return c(Vue.compile('<div>' + this.content + '</div>'));
        },
        methods: methods
    });
}

const routes = [
    { path: '/', component: createPage('home') },
    { path: '/about', component: createPage(
        'about',
        {
            name: 'Abdul Malik Ikhsan'
        },
        {
            hit: () => alert('I am a web developer!')
        }
    )},
    { path: '/contact', component: createPage('contact') }
];

const router = new VueRouter({
    routes,
    base: '/',
    mode: 'history',
    linkExactActiveClass: "active"
});

vue = new Vue({
    router
}).$mount('#root');

// https://vuejs.org/v2/guide/
// https://router.vuejs.org/guide/#html
// https://medium.com/badr-interactive/mengenal-lifecycle-hooks-pada-vue-js-78cd2225a69
// https://forum.vuejs.org/t/setting-a-correct-base-url-with-vue-router/24726/2
// https://vuejs.org/v2/guide/render-function.html#Functional-Components
// https://stackoverflow.com/questions/51548729/vuejs-vue-app-render-method-with-dynamic-template-compiled-is-throwing-some/51552701