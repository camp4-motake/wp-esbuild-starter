import type { AlpineComponent } from "alpinejs";
import { Swiper, Parallax, Thumbs } from "swiper";

interface State {
  viewSlider?: Swiper;
  thumbnailSlider?: Swiper;
  setSlider: () => void;
}

export const itemSlider = (): AlpineComponent<State> => ({
  init() {
    this.$nextTick(() => {
      this.setSlider();
    });
  },

  setSlider() {
    if (!this.$refs["view"] || !this.$refs["thumbnail"]) return;
    this.viewSlider = new Swiper(this.$refs["thumbnail"], {
      spaceBetween: 20,
      slidesPerView: 4,
      centerInsufficientSlides: true,
      freeMode: true,
      watchSlidesProgress: true,
      grabCursor: true,
    });
    this.thumbnailSlider = new Swiper(this.$refs["view"], {
      modules: [Parallax, Thumbs],
      spaceBetween: 1,
      speed: 1000,
      parallax: true,
      thumbs: { swiper: this.viewSlider },
    });
  },

  itemSlider: {},

  itemSliderView: {},

  itemSliderThumbnail: {},
});
