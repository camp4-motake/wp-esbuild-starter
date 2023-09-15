import type { AlpineComponent, Bindings } from "alpinejs";
import type { Store } from "../stores";

export type State = {
  navPrimary: Bindings;
  navPrimaryLink: Bindings;
};

export const navPrimary = (): AlpineComponent<State & Store> => ({
  navPrimary: {
    ["x-init"]() {
      this.$watch("$store.menuStatus.shown", (isShown) => {
        if (isShown) this.$el.scrollTo(0, 0);
      });
    },
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
