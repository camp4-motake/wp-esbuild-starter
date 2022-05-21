import alert from './scripts/editor/alert';
import allowedBlock from './scripts/editor/allowedBlock';
import './styles/editor.css';

window.addEventListener('load', () => {
  alert();
  allowedBlock();
});
