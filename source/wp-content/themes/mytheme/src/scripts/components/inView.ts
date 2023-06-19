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

import { AlpineComponent } from "alpinejs";

export interface State {
  shown: boolean;
  isRepeat: unknown;
}

export const inView = (...args: unknown[]): AlpineComponent<State> => ({
  shown: false,
  isRepeat: args[0],

  trigger: {
    ["x-intersect:enter"](): void {
      this.shown = true;
    },
    ["x-intersect:leave"](): void {
      if (this.isRepeat) this.shown = false;
    },
    [":data-scroll"](): string {
      return this.shown ? "in" : "out";
    },
  },
});
