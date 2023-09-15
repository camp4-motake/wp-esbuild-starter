/**
 * split text
 */

import type { AlpineComponent } from "alpinejs";
import Splitting from "splitting";

export type State = {
  isRepeat: boolean;
  splitText: {
    ["x-init"]: () => void;
    ["x-html"]: () => string;
  };
};

export const splitText = (): AlpineComponent<State> => ({
  isRepeat: false,

  splitText: {
    ["x-init"](): void {
      this.$el.dataset.scroll = "out";
    },
    ["x-html"]() {
      return Splitting.html({ content: this.$el.innerText, by: "chars" });
    },
  },
});
