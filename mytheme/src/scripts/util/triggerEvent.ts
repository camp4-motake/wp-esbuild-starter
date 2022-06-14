/**
 * カスタムイベントトリガー
 */
export const triggerEvent = (
  element: HTMLElement,
  eventName: string,
  detail = {}
) => {
  const event = new CustomEvent(eventName, { detail });
  element.dispatchEvent(event);
};
