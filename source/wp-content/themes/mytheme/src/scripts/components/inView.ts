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
import type { AlpineComponent } from "alpinejs";

export interface State {
  isRepeat: boolean;
  isReverse: () => boolean;
}

export const inView = (...args: unknown[]): AlpineComponent<State> => ({
  isRepeat: args[0] === true,

  trigger: {
    ["x-init"](): void {
      this.$el.dataset.scroll = "out";
    },

    ["x-intersect:enter"](): void {
      this.$el.dataset.scroll = "in";
    },

    ["x-intersect:leave"](): void {
      if (!this.isRepeat) return;
      if (!this.isReverse()) return;
      this.$el.dataset.scroll = "out";
    },
  },

  isReverse() {
    return Math.sign(this.$el.getBoundingClientRect().top) === 1;
  },
});
