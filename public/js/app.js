createPage = () => {
    return {
        mounted () {
            axios.get(
                this.$route.path,
                {
                    headers: {
                      'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            ).then(response => pageContent.innerHTML = response);
        },
        template: '<div id="pageContent"></div>'
    };
}

const routes = [
    { path: '/', component: createPage() },
    { path: '/about', component: createPage() },
    { path: '/contact', component: createPage() }
];

const router = new VueRouter({
    routes,
    linkExactActiveClass: "active"
});
const app    = new Vue({router}).$mount('#root')

// https://vuejs.org/v2/guide/
// https://router.vuejs.org/guide/#html
// https://daengweb.id/vuejs-ajax-request-menggunakan-axios
// https://medium.com/badr-interactive/mengenal-lifecycle-hooks-pada-vue-js-78cd2225a69