import type { AlpineComponent } from "alpinejs";
import { toggleScrollRock } from "../module/toggleScrollRock";

interface State {
  isShowConfirm?: boolean;
  isSendComplete?: boolean;
  isRecaptcha?: boolean;
  isAcceptance?: boolean;
  isSending?: boolean;
  thx?: string;
  labelElements?: Element[];
  previewItems?: { label: string; value: string | number }[];
  toggleScrollRock: () => void;
  showDialog: () => void;
  closeDialog: () => void;
  sentError: () => void;
  disableEnterKey: (event: KeyboardEvent) => void;
  setPreviewItems: () => void;
  change: (event: Event) => void;
}

export const contactForm = (): AlpineComponent<State> => ({
  isShowConfirm: false,
  isSendComplete: false,
  isAcceptance: false,
  isSending: false,
  thx: "",
  previewItems: [],

  init() {
    this.thx = this.$el.getAttribute("data-thx-page") || "";
    this.labelElements = Array.from(this.$el.querySelectorAll("[data-label]"));
    this.toggleScrollRock();
  },

  toggleScrollRock() {
    this.$watch("isShowConfirm", (shown: boolean) => {
      toggleScrollRock(this.$el, shown);
    });
  },

  showDialog() {
    if (this.isSending) return;
    this.isShowConfirm = true;
  },

  closeDialog() {
    if (this.isSending) return;
    this.isShowConfirm = false;
  },

  sentError() {
    this.isSending = false;
    this.closeDialog();
    window.location.href = "#contactForm";
  },

  disableEnterKey(event) {
    if (event.key !== "Enter") return;
    event.preventDefault();
  },

  setPreviewItems() {
    if (!this.labelElements?.length) return;
    this.previewItems = this.labelElements.map((el) => {
      return {
        label: el.getAttribute("data-label") || "",
        value: "",
      };
    });
  },

  change() {
    // console.log(event.target);
    // console.log(this.$el.querySelectorAll(".wpcf7-not-valid").length);
  },

  contactForm: {
    ["@change"](event: Event) {
      if (!(event.target instanceof HTMLInputElement)) return;
      if (event.target?.id !== "user-acceptance") return;
      this.isAcceptance = event.target.checked;
    },

    // ["@focusout"](event: Event) {
    //   this.change(event);
    // },

    // ["@input"](event: Event) {
    //   this.change(event);
    // },

    ["@submit.document"]() {
      this.isSending = true;
    },

    /**
     * disable enter key
     */
    ["@keydown.window"](event: KeyboardEvent) {
      this.disableEnterKey(event);
    },

    ["@keypress.window"](event: KeyboardEvent) {
      this.disableEnterKey(event);
    },

    ["@keyup.window"](event: KeyboardEvent) {
      this.disableEnterKey(event);
    },

    /**
     * CF7 DOM event
     * @see https://contactform7.com/ja/dom-events/
     */
    ["@wpcf7invalid.document"]() {
      this.sentError();
    },

    ["@wpcf7spam.document"]() {
      this.sentError();
    },

    ["@wpcf7mailsent.document"]() {
      if (!this.thx) return;
      window.location.href = this.thx;
    },

    ["@wpcf7mailfailed.document"]() {
      this.sentError();
    },

    // ["@wpcf7submit.document"]() { this.sentError(); },
  },

  confirmDialog: {
    ["x-show"]() {
      return this.isShowConfirm;
    },

    ["x-transition.opacity.duration.200ms"]() {
      return;
    },

    ["@click"](event: Event) {
      const { target } = event;
      if (!(target instanceof Element)) return;
      if (target?.closest(".modalContent,[data-close-ignore]")) return;
      this.closeDialog();
    },

    [":class"]() {
      return { isShow: this.isShowConfirm };
    },
  },

  confirmDialogTrigger: {
    ["@click"](event: Event) {
      event.preventDefault();
      this.showDialog();
      // this.setPreviewItems();
    },

    [":class"]() {
      return { isDisabled: this.isAcceptance };
    },

    [":disabled"]() {
      return !this.isAcceptance;
    },
  },

  confirmDialogClose: {
    ["@click"](event: Event) {
      event.preventDefault();
      this.closeDialog();
    },
  },
});
