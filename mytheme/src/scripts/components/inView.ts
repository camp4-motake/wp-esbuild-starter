/**
 * inView
 *
 * usage:
 * <div x-data="inView" x-bind="trigger"></div>
 *
 * @requires @alpinejs/intersect
 * @see https://alpinejs.dev/plugins/intersect
 *
 */

type InView = {
  shown: boolean;
  once: boolean;
};

export const inView = (once = true) => ({
  shown: false,
  once,

  // x-bind
  trigger: {
    ['x-intersect:enter'](this: InView): void {
      this.shown = true;
    },

    ['x-intersect:leave'](this: InView): void {
      if (!once) this.shown = false;
    },

    [':data-scroll'](this: InView): string {
      return this.shown ? 'in' : 'out';
    },
  },
});
