import type { AlpineComponent, Bindings } from "alpinejs";
import { Store } from "../stores";

type MenuBinding = Bindings | { [key: string]: (event: Event) => void };

export type State = {
  isRunning: boolean;
  isOpen: boolean;
  isTriggerActive: boolean;
  dialog?: HTMLDialogElement;
  modalDialog: MenuBinding;
  modalTrigger: MenuBinding;
  modalClose: MenuBinding;
  open: () => void;
  close: () => void;
  animationTiming?: {
    duration: number | string;
    easing: string;
  };
  closeKeyframes: (el: HTMLElement) => Keyframe[];
  openKeyframes: (el: HTMLElement) => Keyframe[];
};

const rootStyle = getComputedStyle(document.documentElement);
const closeIgnore = "[data-modal-content]";

export const modal = (): AlpineComponent<State & Store> => ({
  isRunning: false,
  isOpen: false,
  isTriggerActive: false,
  dialog: undefined,

  modalDialog: {
    ["x-init"]() {
      if (!(this.$el instanceof HTMLDialogElement)) return;
      this.dialog = this.$el;
    },
    [":class"]() {
      return { "-is-active": this.isOpen };
    },
    [":open"]() {
      return this.isOpen;
    },
    ["@click"]({ target }) {
      if (!(target instanceof HTMLElement)) return;
      if (target?.closest(closeIgnore)) return;
      this.close();
    },
  },

  modalTrigger: {
    [":class"]() {
      return { "-is-active": this.isTriggerActive };
    },
    ["@click"](event: Event) {
      event.preventDefault();
      if (this.isRunning) return;
      if (this.isOpen) this.close();
      else this.open();
    },
  },

  modalClose: {
    ["@click"](event: Event) {
      event.preventDefault();
      if (this.isRunning) return;
      if (this.isOpen) this.close();
    },
  },

  close() {
    if (!this.dialog) return;
    const animation = this.dialog?.animate(
      this.closeKeyframes(this.dialog),
      this.animationTiming,
    );
    this.isRunning = true;
    this.isTriggerActive = false;
    this.$store.siteStatus.isDialogOpen = false;
    animation.onfinish = () => {
      this.isOpen = false;
      this.isRunning = false;
      this.dialog?.close();
    };
  },

  open() {
    if (!this.dialog) return;
    const animation = this.dialog.animate(
      this.openKeyframes(this.dialog),
      this.animationTiming,
    );
    this.isOpen = true;
    this.dialog?.showModal();
    this.isTriggerActive = true;
    this.isRunning = true;
    this.$store.siteStatus.isDialogOpen = true;
    animation.onfinish = () => (this.isRunning = false);
  },

  /**
   * animation keyframes
   */
  animationTiming: {
    duration: 400,
    easing: rootStyle.getPropertyValue("--ease-out-circ"),
  },
  closeKeyframes() {
    return [{ opacity: 1 }, { opacity: 0 }];
  },
  openKeyframes() {
    return [{ opacity: 0 }, { opacity: 1 }];
  },
});
