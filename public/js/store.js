import portfolioStore from './portfolio-store.js';

const store = new Vuex.Store({
    modules: {
        portfolio: portfolioStore
    }
});

export default store;