import createPage from './create-page.js';

export let showoff = (name) => console.log(name, ' showing off');

let about = createPage(
    'about',
    {
        name: 'Abdul Malik Ikhsan'
    },
    {
        hit: () => alert('This alert already proof that I am a web developer!')
    },
    function () {
        this.$nextTick(() => showoff(this.name));
    }
);

export default about;