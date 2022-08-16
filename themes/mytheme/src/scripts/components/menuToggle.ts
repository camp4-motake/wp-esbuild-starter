import { MQ } from '../constants';

interface State {
  shown: boolean;
  $dispatch: (trigger: string) => void;
  addMatchMediaEvent: () => void;
  addOuterClickEvent: () => void;
  close: () => void;
  toggleClass: () => void;
}

const activeClass = 'js-isMenuOpen';
const classList = document.documentElement.classList;

/**
 * menu toggle button
 *
 * example:
 * <button type="button" title="menu-toggle" x-data="menuToggle" x-bind="toggle"></button>
 */
export const menuToggle = () => ({
  shown: false,

  init(this: State) {
    this.addMatchMediaEvent();
    this.addOuterClickEvent();
  },

  addMatchMediaEvent(this: State) {
    window.matchMedia(MQ.lg).addEventListener('change', () => {
      this.$dispatch('menu:close');
    });
  },

  addOuterClickEvent() {
    document.addEventListener('click', (event: Event) => {
      const { target } = event;
      if (!(target instanceof Element)) return;
      if (target?.closest('.header,.navMenu,.menuToggle')) return;
      this.close();
    });
  },

  close() {
    this.shown = false;
    classList.remove(activeClass);
  },

  toggleClass(this: State) {
    if (this.shown) classList.add(activeClass);
    else classList.remove(activeClass);
  },

  // x-bind
  toggle: {
    ['@click'](this: State) {
      this.shown = !this.shown;
      this.toggleClass();
    },

    [':data-menu-toggle'](this: State) {
      return this.shown ? 'shown' : 'close';
    },

    [':title'](this: State) {
      return this.shown ? 'Menu Close' : 'Menu Open';
    },

    ['@menu:close.window'](this: State) {
      this.close();
    },
  },
});

/**
 * menu close button
 *
 * example:
 * <button type="button" title="menu-close" x-data="menuClose" x-bind="close"></button>
 */
export const menuClose = () => ({
  // x-bind
  close: {
    ['@click'](this: State) {
      this.$dispatch('menu:close');
      classList.remove(activeClass);
    },
  },
});
