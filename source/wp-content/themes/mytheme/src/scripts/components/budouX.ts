import type { AlpineComponent } from "alpinejs";
import { loadDefaultJapaneseParser, type HTMLProcessingParser } from "budoux";

export type State = {
  budouX: { ["x-html"]: () => string | Promise<string> };
  parseString: () => Promise<string>;
};

const parser: HTMLProcessingParser = loadDefaultJapaneseParser();

export const budouX = (): AlpineComponent<State> => ({
  budouX: {
    ["x-html"]() {
      return this.parseString();
    },
  },

  async parseString() {
    return parser.translateHTMLString(this.$el.innerHTML);
  },
});
