import domReady from "@wordpress/dom-ready";
import { allowedBlock } from "./scripts/editor/allowedBlock";
import { blockStyles } from "./scripts/editor/blockStyles";

domReady(() => {
  allowedBlock();
  blockStyles();
});
