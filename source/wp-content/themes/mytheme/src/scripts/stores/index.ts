/**
 * Alpine.store
 * https://alpinejs.dev/globals/alpine-store
 *
 * Persist Plugin
 * https://alpinejs.dev/plugins/persist
 */

import Alpine from "alpinejs";

export type Store = {
  $store?: {
    menuStatus: { shown?: boolean };
    siteStatus: {
      isPageActive: boolean;
      isScrollDown: boolean;
      isDialogOpen: boolean;
    };
  };
};

export const stores = () => {
  Alpine.store("menuStatus", {
    menu: false,
  });
  Alpine.store("siteStatus", {
    isPageActive: false,
    isScrollDown: false,
    isDialogOpen: false,
  });
};
