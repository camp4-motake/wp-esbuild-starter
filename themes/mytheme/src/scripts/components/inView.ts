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

interface Props {
  shown: boolean;
  isRepeat: boolean;
}

export const inView = (...args: unknown[]) => ({
  shown: false,
  isRepeat: args[0],

  // x-bind
  trigger: {
    ["x-intersect:enter"](this: Props): void {
      this.shown = true;
    },

    ["x-intersect:leave"](this: Props): void {
      if (this.isRepeat) this.shown = false;
    },

    [":data-scroll"](this: Props): string {
      return this.shown ? "in" : "out";
    },
  },
});
