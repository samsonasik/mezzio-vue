export default (name) => (
    {
      name: name,
      showoff() {
        console.log(this.name, ' showing off');
      }
    }
);
// ref https://masputih.com/2017/12/import-export-modul-dalam-es6