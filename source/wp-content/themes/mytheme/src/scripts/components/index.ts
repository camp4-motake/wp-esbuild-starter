import Alpine from "alpinejs";
import { budouX } from "./budouX";
import { contactForm } from "./contactForm";
import { hero } from "./hero";
import { inView } from "./inView";
import { itemSlider } from "./itemSlider";
import { langSwitcher } from "./langSwitcher";
import { menuClose, menuToggle } from "./menuToggle";
import { modal } from "./modal";
import { navPrimary } from "./navPrimary";
import { root } from "./root";

export const components = () => {
  Alpine.data("budouX", budouX);
  Alpine.data("contactForm", contactForm);
  Alpine.data("hero", hero);
  Alpine.data("inView", inView);
  Alpine.data("itemSlider", itemSlider);
  Alpine.data("langSwitcher", langSwitcher);
  Alpine.data("menuClose", menuClose);
  Alpine.data("menuToggle", menuToggle);
  Alpine.data("modal", modal);
  Alpine.data("navPrimary", navPrimary);
  Alpine.data("root", root);
};
