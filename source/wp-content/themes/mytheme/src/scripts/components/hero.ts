import type { AlpineComponent } from "alpinejs";
import type { Store } from "../stores";

import { Autoplay, Pagination, Parallax, Swiper } from "swiper";
import { MQ } from "../constants";
import { range } from "../util/range";
import { sleep } from "../util/sleep";

interface State extends Store {
  delay: number; // 1 = 1s
  length: number;
  percentage: number;
  slice: number;
  slideWidth: number;
  slider?: Swiper;
  isFirstTransitionComplete: boolean;
  isSlideImageLoaded: boolean;
  isSliderActive: boolean;
  setSlice: () => number;
  setSlider: (index?: number) => void;
  setDelay: (index?: string) => string;
  titleTransition: () => void;
}

interface ImgEvent extends Event {
  detail: { imgIndex: string };
}

const mq = window.matchMedia(MQ.lg);

export const hero = (): AlpineComponent<State> => ({
  length: 0,
  slice: 6,
  delay: 6,
  slideWidth: 0,
  percentage: 0,
  isSliderActive: false,
  isFirstTransitionComplete: false,
  isSlideImageLoaded: false,
  range,

  init() {
    this.slice = this.setSlice();
    mq.addEventListener("change", () => {
      this.slice = this.setSlice();
    });
  },

  setSlice() {
    return mq.matches ? 8 : 6;
  },

  setSlider() {
    this.length = this.$el.querySelectorAll(".swiper-slide").length;
    this.slider = new Swiper(this.$el, {
      modules: [Autoplay, Pagination, Parallax],
      slidesPerView: 1,
      spaceBetween: 0,
      parallax: true,
      autoplay:
        this.length > 1
          ? {
              delay: this.delay * 1000,
              disableOnInteraction: false,
              pauseOnMouseEnter: false,
            }
          : false,
      grabCursor: false,
      loop: true,
      speed: 1800,
      pagination: {
        el: this.$refs["pagination"],
        type: "bullets",
        clickable: true,
      },
      on: {
        afterInit: () => {
          this.titleTransition();
        },
        autoplayTimeLeft: (_swiper, _timeLeft, percentage) => {
          this.percentage = 1 - percentage;
        },
      },
    });
    this.slider.autoplay.pause();
  },

  setDelay() {
    const rand = Math.floor(Math.random() * 2);
    const num = Math.floor(Math.random() * 10) + 1 * 10;
    return String(rand % 2 === 0 ? -1 * num : num) + "%";
  },

  titleTransition() {
    sleep(400).then(() => {
      this.isSliderActive = true;
    });
    sleep(800).then(() => {
      this.slider?.autoplay.resume();
    });
    sleep(1200).then(() => {
      this.isFirstTransitionComplete = true;
    });
  },

  hero: {
    ["x-intersect:enter"](): void {
      this.$store.siteStatus.isHeroInView = true;
    },

    ["x-intersect:leave"](): void {
      this.$store.siteStatus.isHeroInView = false;
    },

    [":class"]() {
      return {
        isFirstTransitionComplete: this.isFirstTransitionComplete,
        isSlideImageLoaded: this.isSlideImageLoaded,
        isSliderActive: this.isSliderActive,
        isSlideImageLoading: !this.isSlideImageLoaded,
      };
    },

    ["@hero:img-decoded"](event: ImgEvent) {
      if (this.isSlideImageLoaded) return;
      if (event.detail.imgIndex === "1") this.isSlideImageLoaded = true;
    },
  },

  heroSlider: {
    ["x-init"]() {
      this.$watch("isSlideImageLoaded", () => {
        this.setSlider();
      });
      this.$nextTick(() => {
        this.slideWidth = this.$el.getBoundingClientRect().width;
        sleep(400).then(() => {
          this.isSliderActive = true;
        });
        if (this.$el.querySelector(".swiper-slide img")) return;
        this.isSlideImageLoaded = true;
      });
    },

    ["@resize.window"]() {
      this.slideWidth = this.$el.getBoundingClientRect().width;
    },

    [":style"]() {
      return {
        "--hero-slide-width": `${this.slideWidth}px`,
      };
    },
  },

  heroSliderClone: {
    ["x-init"]() {
      this.$nextTick(() => {
        const index = this.$el.getAttribute("data-index");
        this.$el.style.setProperty("--index", index);
      });
    },

    [":style"]() {
      return {
        left: `calc(${100 / this.slice}% * var(--index))`,
        width: `${100 / this.slice}%`,
      };
    },
  },

  heroSliderCloneLayer: {
    [":style"]() {
      return {
        left: `calc(-${this.slideWidth / this.slice}px * var(--index))`,
      };
    },
  },

  heroSliderPagination: {
    [":style"]() {
      return {
        // "--bullet-speed": `${this.delay}s`,
        "--autoplay-delay": this.percentage,
      };
    },
  },

  heroPicture: {
    ["x-init"]() {
      if (this.$el.tagName !== "IMG") return;
      if (!(this.$el instanceof HTMLImageElement)) return;
      // if (!this.$el.decoding) { this.$el.classList.add("isDecoded"); return; }
      this.$el
        .decode()
        .then(() => {
          this.$el.classList.add("isDecoded");
          this.$dispatch("hero:img-decoded", {
            imgIndex: this.$el.getAttribute("data-img-index"),
          });
        })
        .catch(() => {
          this.$el.classList.add("isDecoded");
          this.$el.classList.add("isDecodeError");
        });
    },
  },
});
