import Alpine from 'alpinejs';
import { inView } from './inView';

export const components = () => {
  Alpine.data('inView', inView);
};
