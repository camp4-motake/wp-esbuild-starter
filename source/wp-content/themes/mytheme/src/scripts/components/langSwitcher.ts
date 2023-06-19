import type { AlpineComponent } from "alpinejs";
import type { Store } from "../stores";

export interface State extends Store {
  addOuterClickEvent: () => void;
}

const ignoreCloseSelector = ".langSwitcher-toggle, .bogo-language-switcher";

export const langSwitcher = (): AlpineComponent<State> => ({
  init() {
    this.addOuterClickEvent();
  },

  addOuterClickEvent() {
    document.addEventListener("click", (event) => {
      const { target } = event;
      if (!(target instanceof Element)) return;
      if (target?.closest(ignoreCloseSelector)) return;
      this.$store.langSwitcherStatus.shown = false;
    });
  },

  langSwitcherToggle: {
    ["@click"]() {
      this.$store.langSwitcherStatus.shown =
        !this.$store.langSwitcherStatus.shown;
    },
  },
});
