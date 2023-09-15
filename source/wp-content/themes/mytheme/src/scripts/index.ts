import intersect from "@alpinejs/intersect";
import Alpine from "alpinejs";
import { components } from "./components";
import { stores } from "./stores";

window.Alpine = Alpine;
Alpine.plugin(intersect);
Alpine.plugin(stores);
Alpine.plugin(components);
Alpine.start();
