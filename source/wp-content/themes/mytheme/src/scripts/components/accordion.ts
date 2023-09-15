import type { AlpineComponent, Bindings } from "alpinejs";
import { sleep } from "../util/sleep";

export type State = {
  isRunning: boolean;
  isOpen: boolean;
  isTriggerActive: boolean;
  accordion: Bindings;
  accordionTrigger: Bindings | { [key: string]: (event: Event) => void };
  open: () => void;
  close: () => void;
  toggle: (open: boolean) => void;
  animationTiming?: { duration: number | string; easing: string };
  closeKeyframes: (el: HTMLElement) => Keyframe[];
  openKeyframes: (el: HTMLElement) => Keyframe[];
};

const rootStyle = getComputedStyle(document.documentElement);

export const accordion = (): AlpineComponent<State> => ({
  isRunning: false,
  isOpen: false,
  isTriggerActive: false,

  accordion: {
    [":class"]() {
      return { "-is-active": this.isOpen };
    },
    [":open"]() {
      return this.isOpen;
    },
  },

  accordionTrigger: {
    [":class"]() {
      return { "-is-active": this.isTriggerActive };
    },
    ["@click"](event) {
      event.preventDefault();
      if (!this.isRunning) this.toggle(!this.isOpen);
    },
  },

  toggle(open) {
    if (open) this.open();
    else this.close();
  },

  close() {
    const animation = this.$refs.accordionContent.animate(
      this.closeKeyframes(this.$refs.accordionContent),
      this.animationTiming,
    );
    this.isRunning = true;
    this.isTriggerActive = false;
    animation.onfinish = () => {
      this.isOpen = false;
      this.isRunning = false;
    };
  },

  open() {
    this.isOpen = true;
    this.isTriggerActive = true;
    this.isRunning = true;
    this.$refs.accordionContent.style.height = "0";
    sleep(1).then(() => {
      this.$refs.accordionContent.style.height = "";
      const animation = this.$refs.accordionContent.animate(
        this.openKeyframes(this.$refs.accordionContent),
        this.animationTiming,
      );
      animation.onfinish = () => (this.isRunning = false);
    });
  },

  /**
   * animation keyframes
   */
  animationTiming: {
    duration: 400,
    easing: rootStyle.getPropertyValue("--ease-out-circ"),
  },
  closeKeyframes(el) {
    return [{ height: el.offsetHeight + "px" }, { height: 0 }];
  },
  openKeyframes(el) {
    return [{ height: 0 }, { height: el.offsetHeight + "px" }];
  },
});
