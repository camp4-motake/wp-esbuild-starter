/**
 * Alpine.store
 * https://alpinejs.dev/globals/alpine-store
 */

import Alpine from "alpinejs";
import { MenuState, menuStatus } from "./menuStatus";
import { SiteState, siteStatus } from "./siteStatus";

export interface Store {
  $store?: {
    menuStatus: MenuState;
    siteStatus: SiteState;
  };
}

export const stores = () => {
  Alpine.store("menuStatus", menuStatus);
  Alpine.store("siteStatus", siteStatus);
};
