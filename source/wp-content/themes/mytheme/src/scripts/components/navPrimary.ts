import type { AlpineComponent } from "alpinejs";
import type { Store } from "../stores";

export type State = Store;

export const navPrimary = (): AlpineComponent<State> => ({
  navPrimary: {
    [":data-menu-status"]() {
      return this.$store.menuStatus.shown ? "shown" : "close";
    },
  },

  navPrimaryLink: {
    ["@click"]() {
      this.$store.menuStatus.shown = false;
    },
  },
});
