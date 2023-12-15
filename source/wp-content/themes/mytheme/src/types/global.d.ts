import { Alpine as AlpineType } from "alpinejs"

declare global {
  const wp: WPBlocks

  interface Window {
    Alpine: AlpineType
    CUSTOM_THEME_SLUG_STRING_CHECK: string | boolean
  }
}

declare module "alpinejs" {
  interface Alpine {
    // WORKAROUND
    $persist: (key: string | number) => { as: (key: string) => never }
  }
}
