/**
 * Alpine.store
 * https://alpinejs.dev/globals/alpine-store
 */

import Alpine from "alpinejs";
import { LangSwitcherStatus, langSwitcherStatus } from "./langSwitcherStatus";
import { MenuState, menuStatus } from "./menuStatus";
import { SiteState, siteStatus } from "./siteStatus";

export interface Store {
  $store?: {
    langSwitcherStatus: LangSwitcherStatus;
    menuStatus: MenuState;
    siteStatus: SiteState;
  };
}

export const stores = () => {
  Alpine.store("langSwitcherStatus", langSwitcherStatus);
  Alpine.store("menuStatus", menuStatus);
  Alpine.store("siteStatus", siteStatus);
};
