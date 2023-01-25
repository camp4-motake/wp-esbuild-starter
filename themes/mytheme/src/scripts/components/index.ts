import Alpine from "alpinejs";
import { inView } from "./inView";
import { menuToggle, menuClose } from "./menuToggle";

export const components = () => {
  Alpine.data("inView", inView);
  Alpine.data("menuClose", menuClose);
  Alpine.data("menuToggle", menuToggle);
};
