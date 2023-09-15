type MqPresets = { [key: string]: string };

// match media breakpoint: em
export const MQ: MqPresets = {
  sm: "(min-width:36em)", // 576px
  md: "(min-width:48em)", // 768px
  lg: "(min-width:62em)", // 992px
  xl: "(min-width:75em)", // 1200px
  xxl: "(min-width:100em)", // 1600px
};

// exclude link
export const EXCLUDE_LINK_SELECTOR: string = [
  '[href=""]',
  '[href="#0"]',
  '[href="#todo"]',
].join(",");
