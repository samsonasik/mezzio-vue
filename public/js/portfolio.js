import createPage from './create-page.js';

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

            if (typeof this.$store.state.portfolio[keyword] !== 'undefined') {
                this.portfolio = this.$store.state.portfolio[keyword];

                return;
            }

            if (sessionStorage.getItem('search-' + keyword)) {
                let portfolio  = JSON.parse(sessionStorage.getItem('search-' + keyword));
                this.$store.commit('search', { keyword: keyword, value: portfolio });
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

                this.$store.commit('search', { keyword: keyword, value: this.portfolio });
            })();
        }
    },
    function () {
        this.$nextTick(() => this.search());
    }
);

export default portfolio;