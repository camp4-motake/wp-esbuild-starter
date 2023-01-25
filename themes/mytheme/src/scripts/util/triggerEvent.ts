/**
 * カスタムイベントトリガー
 */
export const triggerEvent = (
  element: HTMLElement,
  eventName: string,
  detail = {}
) => {
  let event;

  try {
    event = new CustomEvent(eventName, { detail });
  } catch (e) {
    // IE用fallback
    event = document.createEvent("CustomEvent");
    event.initCustomEvent(eventName, false, false, detail);
  }

  element.dispatchEvent(event);
};
