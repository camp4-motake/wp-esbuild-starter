import type { AlpineComponent } from "alpinejs";
import { MQ } from "../constants";
import type { Store } from "../stores";

export interface State extends Store {
  addMatchMediaEvent: () => void;
  addOuterClickEvent: () => void;
  close: () => void;
}

const ignoreCloseSelector =
  ".nav-primary,.menu-toggle,[data-menu-close-ignore]";

const breakpoint = MQ.xxl;

/**
 *  Component: Menu Toggle
 */
export const menuToggle = (): AlpineComponent<State> => ({
  init(this: State) {
    this.addMatchMediaEvent();
    this.addOuterClickEvent();
  },

  toggle: {
    ["@click"]() {
      this.$store.menuStatus.shown = !this.$store.menuStatus.shown;
    },

    ["@menu:close.window"]() {
      this.close();
    },

    [":title"]() {
      return this.$store.menuStatus.shown ? "Menu Close" : "Menu Open";
    },

    [":aria-expanded"]() {
      return this.$store.menuStatus.shown;
    },

    [":data-menu-toggle"]() {
      return this.$store.menuStatus.shown ? "shown" : "close";
    },
  },

  menuLabel: {
    ["x-text"]() {
      return this.$store.menuStatus.shown ? "Close" : "Menu";
    },
  },

  addMatchMediaEvent() {
    window.matchMedia(breakpoint).addEventListener("change", () => {
      this.$dispatch("menu:close");
    });
  },

  addOuterClickEvent() {
    document.addEventListener("click", (event) => {
      const { target } = event;
      if (!(target instanceof Element)) return;
      if (target?.closest(ignoreCloseSelector)) return;
      this.close();
    });
  },

  close() {
    this.$store.menuStatus.shown = false;
  },
});

/**
 *  Component: Menu Close
 */
export const menuClose = (): AlpineComponent<Store> => ({
  menuClose: {
    ["@click"]() {
      this.$store.menuStatus.shown = false;
    },
  },
});
