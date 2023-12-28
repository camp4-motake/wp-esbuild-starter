import Alpine from "alpinejs"
import { loadDefaultJapaneseParser, type HTMLProcessingParser } from "budoux"

const parser: HTMLProcessingParser = loadDefaultJapaneseParser()

Alpine.data("budouX", () => ({
  budouX: {
    ["x-html"]() {
      return this.parseString()
    },
  },

  async parseString() {
    return parser.translateHTMLString(this.$el.innerHTML)
  },
}))
