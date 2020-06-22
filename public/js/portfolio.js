import createPage from './create-page.js';
import store      from './store.js';

store.registerModule('portfolio', {
    state: {
        portfolio : []
    },
    mutations: {
        searchPortfolio (state, data) {
            sessionStorage.setItem('search-portfolio-' + data.keyword, JSON.stringify(data.value));
            state.portfolio[data.keyword] = data.value;
        }
    }
});

let portfolio = createPage(
    'portfolio',
    {
        portfolio : [
            {
                title : 'loading...',
                image : '',
                link  : '',
            }
        ]
    },
    {
        search: function (e = null) {
            let keyword = e !== null
                ? e.target.value
                : '';

            if (typeof store.state.portfolio.portfolio[keyword] !== 'undefined') {
                this.portfolio = store.state.portfolio.portfolio[keyword];

                return;
            }

            if (sessionStorage.getItem('search-portfolio-' + keyword)) {
                let portfolio  = JSON.parse(sessionStorage.getItem('search-portfolio-' + keyword));
                store.commit('searchPortfolio', { keyword: keyword, value: portfolio });
                this.portfolio = portfolio;

                return;
            }

            (async () => {
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
                }).then(result => this.portfolio = result);

                store.commit('searchPortfolio', { keyword: keyword, value: this.portfolio });
            })();
        }
    },
    function () {
        this.$nextTick(() => this.search());
    }
);

export default portfolio;