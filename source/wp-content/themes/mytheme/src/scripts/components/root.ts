import type { AlpineComponent } from "alpinejs";
import type { Store } from "../stores";

export type State = {
  scrollBarWidth: number;
  interval?: NodeJS.Timer;
  isRecaptcha: boolean;
  wpAdminBar?: Element | undefined | null;

  root: {
    [":class"]: () => {
      isDialogOpen: boolean | undefined;
      isMenuOpen: boolean | undefined;
      isPageActive: boolean | undefined;
      isScrollDown: boolean | undefined;
    };
    [":style"]: () => { "--window-scroll-bar-width": string };
    ["@resize.window"]: () => void;
  };

  setScrollbarWidth: () => void;
  scrollBarCheckInterval: () => void;
  setWPMatchMediaEvent: () => void;
  setWPAdminBarSize: () => void;
};

const mq = window.matchMedia("screen and (max-width: 782px)");

export const root = (): AlpineComponent<State & Store> => ({
  scrollBarWidth: 0,
  isRecaptcha: false,

  init() {
    this.$nextTick(() => {
      this.$store.siteStatus.isPageActive = true;
      this.scrollBarCheckInterval();
      this.setWPMatchMediaEvent();
    });
  },

  root: {
    [":class"]() {
      return {
        isDialogOpen: this.$store.siteStatus.isDialogOpen,
        isMenuOpen: this.$store.menuStatus.shown,
        isPageActive: this.$store.siteStatus.isPageActive,
        isScrollDown:
          this.$store.siteStatus.isScrollDown || this.$store.menuStatus.shown,
      };
    },

    [":style"]() {
      return {
        "--window-scroll-bar-width": `${this.scrollBarWidth}px`,
      };
    },

    ["@resize.window"]() {
      this.setWPAdminBarSize();
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

  setWPMatchMediaEvent() {
    if (!this.wpAdminBar) {
      this.wpAdminBar = document.getElementById("wpadminbar");
      if (!this.wpAdminBar) return;
    }
    this.setWPAdminBarSize();
    mq.addEventListener("change", () => this.setWPAdminBarSize());
  },

  setWPAdminBarSize() {
    if (!this.wpAdminBar) return;
    const size = this.wpAdminBar.getBoundingClientRect();
    this.$el.style.setProperty("--wp-adminbar-height", `${size.height}px`);
  },
});
