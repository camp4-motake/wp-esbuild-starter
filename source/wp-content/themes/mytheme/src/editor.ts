import { allowedBlock } from "./scripts/editor/allowedBlock"
import { blockStyles } from "./scripts/editor/blockStyles"

window.addEventListener("load", () => {
  allowedBlock()
  blockStyles()
})
