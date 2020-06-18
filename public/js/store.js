let store = new Vuex.Store({
    state: {
        portfolio : []
    },
    mutations: {
        search (state, data) {
            sessionStorage.setItem('search-' + data.keyword, JSON.stringify(data.value));
            state.portfolio[data.keyword] = data.value;
        }
    }
});

export default store;