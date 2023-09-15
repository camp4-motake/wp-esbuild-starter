// import type { AlpineComponent } from "alpinejs";

// interface State {
//   parseString: () => Promise<string>;
// }

// export const budouX = (): AlpineComponent<State> => ({
//   budouX: {
//     ["x-html"]() {
//       return this.parseString();
//     },
//   },

//   async parseString() {
//     if (!this.parser) {
//       const { loadDefaultJapaneseParser } = await import("../plugins/budouX");
//       this.parser = loadDefaultJapaneseParser();
//     }
//     return this.parser.translateHTMLString(this.$el.innerHTML);
//   },
// });
