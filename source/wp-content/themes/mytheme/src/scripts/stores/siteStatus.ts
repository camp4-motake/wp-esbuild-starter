export interface SiteState {
  isPageActive: boolean;
  isScrollDown: boolean;
  isHeroInView: boolean;
  isRecaptcha: boolean;
}

export const siteStatus: SiteState = {
  isPageActive: false,
  isScrollDown: false,
  isHeroInView: false,
  isRecaptcha: false,
};
