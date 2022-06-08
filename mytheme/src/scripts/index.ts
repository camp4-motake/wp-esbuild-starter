import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import { components } from './components';

window.Alpine = Alpine;
Alpine.plugin(intersect);
Alpine.plugin(components);
Alpine.start();
