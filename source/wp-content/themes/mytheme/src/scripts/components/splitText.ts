/**
 * split text
 */

import type { AlpineComponent } from "alpinejs";
import Splitting from "splitting";

export interface State {}

export const splitText = (): AlpineComponent<State> => ({
  splitText: {
    ["x-init"](): void {
      this.$el.dataset.scroll = "out";
    },

    ["x-html"]() {
      return Splitting.html({ content: this.$el.innerText, by: "chars" });
    },

    ["x-intersect:enter"](): void {
      this.$el.dataset.scroll = "in";
    },

    ["x-intersect:leave"](): void {
      if (!this.isRepeat) return;
      if (!this.isReverse()) return;
      this.$el.dataset.scroll = "out";
    },

    [":class"]() {
      return { "text-split-in": true };
    },
  },
});
