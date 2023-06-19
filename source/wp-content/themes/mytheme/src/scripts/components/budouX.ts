import type { AlpineComponent } from "alpinejs";
import { loadDefaultJapaneseParser } from "budoux";

// interface State {}

const parser = loadDefaultJapaneseParser();

export const budouX = (): AlpineComponent => ({
  budouX: {
    ["x-html"]() {
      return parser.translateHTMLString(this.$el.innerHTML);
    },
  },
});
