createPage = () => {
    return {
        data: () => {
            return  {
              content: ''
            }
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
        template: '<div v-html="content"></div>'
    };
}

const routes = [
    { path: '/', component: createPage() },
    { path: '/about', component: createPage() },
    { path: '/contact', component: createPage() }
];

const router = new VueRouter({
    routes,
    base: '/',
    mode: 'history',
    linkExactActiveClass: "active"
});
const app    = new Vue({router}).$mount('#root')

// https://vuejs.org/v2/guide/
// https://router.vuejs.org/guide/#html
// https://medium.com/badr-interactive/mengenal-lifecycle-hooks-pada-vue-js-78cd2225a69
// https://forum.vuejs.org/t/setting-a-correct-base-url-with-vue-router/24726/2