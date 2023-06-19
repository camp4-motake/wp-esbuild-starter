import Alpine from "alpinejs";
import { budouX } from "./budouX";
import { inView } from "./inView";
import { menuClose, menuToggle } from "./menuToggle";
import { navPrimary } from "./navPrimary";
import { root } from "./root";

export const components = () => {
  Alpine.data("budouX", budouX);
  Alpine.data("inView", inView);
  Alpine.data("menuClose", menuClose);
  Alpine.data("menuToggle", menuToggle);
  Alpine.data("navPrimary", navPrimary);
  Alpine.data("root", root);
};
