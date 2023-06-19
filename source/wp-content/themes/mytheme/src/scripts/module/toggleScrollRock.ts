import { disableBodyScroll, enableBodyScroll } from "body-scroll-lock";
import type { BodyScrollOptions } from "body-scroll-lock";

const options: BodyScrollOptions = {
  reserveScrollBarGap: true,
};

export const toggleScrollRock = (el: HTMLElement, shown: boolean) => {
  if (shown) disableBodyScroll(el, options);
  else enableBodyScroll(el);
};
