import { allowedBlock } from "./scripts/editor/allowedBlock"
import { blockStyles } from "./scripts/editor/blockStyles"

// WORKAROUND: css glob import
// @see https://github.com/vitejs/vite/discussions/6688#discussioncomment-3649999
import.meta.glob("./styles/config/*.css", { eager: true })
import.meta.glob("./styles/{editor,blocks,components,utils}/**/*.css", {
  eager: true,
})
import.meta.glob("./styles/global/typography.css")

window.addEventListener("load", () => {
  allowedBlock()
  blockStyles()
})
