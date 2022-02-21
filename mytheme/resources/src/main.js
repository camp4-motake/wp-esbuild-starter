import domReady from './scripts/util/domReady';
import './styles/main.scss';

// window.Alpine = Alpine;

async function main() {
  await domReady(() => {
    document.getElementById('noLongerSupport')?.remove();
  });
}
main();
