/**
 *  Component: Menu Close
 */

import type { AlpineComponent, Bindings } from "alpinejs";
import type { Store } from "../../stores";

export type State = { menuClose: Bindings };

export const menuClose = (): AlpineComponent<State & Store> => ({
  menuClose: {
    ["@click"]() {
      this.$store.menuStatus.shown = false;
    },
  },
});
