/**
 *  Component: Menu Close
 */

import type { AlpineComponent } from "alpinejs";
import type { Store } from "../../stores";

export type State = {
  menuClose: { ["@click"]: () => void };
};

export const menuClose = (): AlpineComponent<State & Store> => ({
  menuClose: {
    ["@click"]() {
      this.$store.menuStatus.shown = false;
    },
  },
});
