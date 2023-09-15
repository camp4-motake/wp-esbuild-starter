import Alpine from "alpinejs";
import { accordion } from "./accordion";
import { inView } from "./inView";
import { menuClose } from "./menu/close";
import { menuToggle } from "./menu/toggle";
import { modal } from "./modal";
import { navPrimary } from "./navPrimary";
import { root } from "./root";

export const components = () => {
  Alpine.data("accordion", accordion);
  Alpine.data("inView", inView);
  Alpine.data("menuClose", menuClose);
  Alpine.data("menuToggle", menuToggle);
  Alpine.data("modal", modal);
  Alpine.data("navPrimary", navPrimary);
  Alpine.data("root", root);
};
