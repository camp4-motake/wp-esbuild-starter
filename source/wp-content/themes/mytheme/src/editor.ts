/**
 * editor css glob import
 * @see https://github.com/vitejs/vite/discussions/6688#discussioncomment-3649999
 */
import.meta.glob("./styles/config/**/*.css", { eager: true })
import.meta.glob("./styles/editor/**/*.css", { eager: true })
import.meta.glob("./styles/{blocks,components,utils}/**/*.css", { eager: true })
import.meta.glob("./styles/global/typography.css", { eager: true })

/**
 * block scripts
 */
import { allowedBlock } from "./editor/allowedBlock"
import { blockStyles } from "./editor/blockStyles"
import { blockVariations } from "./editor/blockVariations"

window.addEventListener("load", () => {
  allowedBlock()
  blockStyles()
  blockVariations()
})
