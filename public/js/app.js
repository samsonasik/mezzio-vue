createPage = (name, object = {}, methods = {}) => {
    return Vue.component('page-' + name, {
        data    : () => Object.assign({content: ''}, object),
        methods : methods,
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
        render : function (c) {
            if (this.content == '') {
                return;
            }

            return c(Vue.compile('<div>' + this.content + '</div>'));
        }
    });
}

const store = new Vuex.Store({
    state: {
        portfolio : {}
    },
    mutations: {
        search (state, data) {
            state.portfolio[data.keyword] = data.value;
        }
    }
});

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
        component: createPage(
            'about',
            {
                name: 'Abdul Malik Ikhsan'
            },
            {
                hit: () => alert('This alert already proof that I am a web developer!')
            }
        ),
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
        component: createPage(
            'portfolio',
            {
                portfolio : []
            },
            {
                search: function (e) {
                    let keyword = e.target.value;

                    if (typeof store.state.portfolio[keyword] !== 'undefined') {
                        this.portfolio = store.state.portfolio[keyword];
                        return;
                    }

                    (async () => {
                        let portfolio = [];

                        await new Promise( (resolve) => {
                            fetch(
                                '/api/portfolio?keyword=' + keyword,
                                {
                                    method: 'GET',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                    }
                                }
                            ).then(response =>  resolve(response.json()));
                        }).then(result => portfolio = result);

                        store.commit('search', { keyword: keyword, value: portfolio });
                        this.portfolio = portfolio;
                    })();
                }
            }
        ),
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

vue = new Vue({
    router
}).$mount('#root');

// https://vuejs.org/v2/guide/
// https://router.vuejs.org/guide/#html
// https://medium.com/badr-interactive/mengenal-lifecycle-hooks-pada-vue-js-78cd2225a69
// https://forum.vuejs.org/t/setting-a-correct-base-url-with-vue-router/24726/2
// https://vuejs.org/v2/guide/render-function.html#Functional-Components
// https://stackoverflow.com/questions/51548729/vuejs-vue-app-render-method-with-dynamic-template-compiled-is-throwing-some/51552701
// https://medium.com/js-dojo/how-to-permanently-save-data-with-vuex-localstorage-in-your-vue-app-f1d5c140db69