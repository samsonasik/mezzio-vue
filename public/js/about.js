import createPage from './create-page.js';

const showoff = (name) => console.log(name, ' showing off');

const about = createPage(
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
