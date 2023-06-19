import type { AlpineComponent } from "alpinejs";
import type { Store } from "../stores";

export interface State extends Store {
  scrollBarWidth: number;
  interval?: NodeJS.Timer;
  isRecaptcha: boolean;
  setScrollbarWidth: () => void;
}

export const root = (): AlpineComponent<State> => ({
  scrollBarWidth: 0,
  isRecaptcha: false,

  init() {
    this.interval = setInterval(() => {
      this.setScrollbarWidth();
    }, 1000);
  },

  setScrollbarWidth() {
    this.scrollBarWidth =
      window.innerWidth - document.documentElement.clientWidth;
  },

  root: {
    [":x-init"]() {
      this.$nextTick(() => {
        this.$store.siteStatus.isPageActive = true;
      });
    },

    [":class"]() {
      return {
        isPageActive: this.$store.siteStatus.isPageActive,
        isScrollDown:
          this.$store.siteStatus.isScrollDown || this.$store.menuStatus.shown,
        isHeroInView: this.$store.siteStatus.isHeroInView,
        isMenuOpen: this.$store.menuStatus.shown,
        isLangSwitcherOpen: this.$store.langSwitcherStatus.shown,
      };
    },

    [":style"]() {
      return {
        "--window-scroll-bar-width": `${this.scrollBarWidth}px`,
      };
    },
  },

  reCaptchaTerm: {
    ["x-init"]() {
      this.$nextTick(() => {
        const isRecaptcha = !!document.getElementById("google-recaptcha-js");
        this.$store.siteStatus.isRecaptcha = isRecaptcha;
      });
    },

    ["x-show"]() {
      return this.$store.siteStatus.isRecaptcha;
    },
  },
});
