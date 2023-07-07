import type { AlpineComponent } from "alpinejs";
import type { Store } from "../stores";

export interface State extends Store {
  scrollBarWidth: number;
  interval?: NodeJS.Timer;
  isRecaptcha: boolean;
  setScrollbarWidth: () => void;
  scrollBarCheckInterval: () => void;
}

export const root = (): AlpineComponent<State> => ({
  scrollBarWidth: 0,
  isRecaptcha: false,

  init() {
    this.$nextTick(() => {
      this.$store.siteStatus.isPageActive = true;
      this.scrollBarCheckInterval();
    });
  },

  root: {
    [":class"]() {
      return {
        isPageActive: this.$store.siteStatus.isPageActive,
        isScrollDown:
          this.$store.siteStatus.isScrollDown || this.$store.menuStatus.shown,
        isMenuOpen: this.$store.menuStatus.shown,
      };
    },

    [":style"]() {
      return {
        "--window-scroll-bar-width": `${this.scrollBarWidth}px`,
      };
    },
  },

  scrollBarCheckInterval() {
    this.interval = setInterval(() => {
      this.setScrollbarWidth();
    }, 1000);
  },

  setScrollbarWidth() {
    this.scrollBarWidth =
      window.innerWidth - document.documentElement.clientWidth;
  },
});
