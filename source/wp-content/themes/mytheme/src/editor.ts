import { allowedBlock } from "./scripts/editor/allowedBlock";
import { blockStyles } from "./scripts/editor/blockStyles";
// import "./styles/editor.css";

window.addEventListener("load", () => {
  allowedBlock();
  blockStyles();
});
