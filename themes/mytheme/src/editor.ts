import alert from "./scripts/editor/alert";
import allowedBlock from "./scripts/editor/allowedBlock";
import "./styles/editor.scss";

window.addEventListener("load", () => {
  alert();
  allowedBlock();
});
