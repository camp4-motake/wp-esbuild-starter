import type { AlpineComponent } from "alpinejs";
import { toggleScrollRock } from "../module/toggleScrollRock";

interface State {
  isShow?: boolean;
  targetId?: unknown;
  toggleScrollRock: () => void;
}

export const modal = (...args: unknown[]): AlpineComponent<State> => ({
  isShow: false,
  targetId: args[0],

  init() {
    this.$nextTick(() => {
      this.toggleScrollRock();
    });
  },

  toggleScrollRock() {
    this.$watch("isShow", (shown: boolean) => {
      toggleScrollRock(this.$el, shown);
    });
  },

  modal: {
    ["x-show"]() {
      return this.isShow;
    },

    ["x-transition.opacity.duration.200ms"]() {
      return;
    },

    ["@click"](event: Event) {
      const { target } = event;
      if (!(target instanceof Element)) return;
      if (target?.closest(".modalContent,[data-close-ignore]")) return;
      event.preventDefault();
      this.isShow = false;
    },
  },

  modalTrigger: {
    ["@click"](event: Event) {
      event.preventDefault();
      this.isShow = true;
    },
  },

  modalClose: {
    ["@click"](event: Event) {
      event.preventDefault();
      this.isShow = false;
    },
  },
});
