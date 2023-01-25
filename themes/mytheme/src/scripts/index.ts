import Alpine from "alpinejs";
import { components } from "./components";

window.Alpine = Alpine;
Alpine.plugin(components);
Alpine.start();
