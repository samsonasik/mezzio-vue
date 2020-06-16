import createPage from '/js/create-page.js';

let about = createPage(
    'about',
    {
        name: 'Abdul Malik Ikhsan'
    },
    {
        hit: () => alert('This alert already proof that I am a web developer!')
    }
);

export let showoff = (name) => console.log(name, ' showing off');

export default about;