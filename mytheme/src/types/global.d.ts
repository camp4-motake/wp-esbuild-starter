/* eslint-disable no-var */
import { Alpine as AlpineType } from 'alpinejs';

declare global {
  const wp: any;

  interface Window {
    Alpine: AlpineType;
    CUSTOM_THEME_SLUG_STRING_CHECK: string | boolean;
  }
}
