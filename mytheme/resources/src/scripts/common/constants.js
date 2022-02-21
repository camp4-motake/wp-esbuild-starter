/**
 * constants
 *
 * 定数
 *
 */

/*
// match media breakpoint: px
export const MQ = {
  sm: '(min-width:576px)',
  md: '(min-width:768px)',
  lg: '(min-width:992px)',
  xl: '(min-width:1200px)',
  xxl: '(min-width:1600px)',
};
*/

// match media breakpoint: em
export const MQ = {
  sm: '(min-width:36em)',
  md: '(min-width:48em)',
  lg: '(min-width:62em)',
  xl: '(min-width:75em)',
  xxl: '(min-width:100em)',
};

// exclude link
export const EXCLUDE_LINK_SELECTOR = [
  '[href=""]',
  '[href="#0"]',
  '[href="#todo"]',
].join(',');

// Theme value
export const THEME_OPTIONS = window.THEME_OPTIONS || {};
