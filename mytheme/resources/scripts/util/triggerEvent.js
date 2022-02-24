/**
 * カスタムイベントトリガー
 *
 * @param {HTMLElement} element - 対象要素
 * @param {string} eventName - カスタムイベント名
 * @param {object} detail - 追加の引数
 */
const triggerEvent = (element, eventName, detail = {}) => {
  let event;

  try {
    event = new CustomEvent(eventName, { detail });
  } catch (e) {
    // IE用fallback
    event = document.createEvent('CustomEvent');
    event.initCustomEvent(eventName, false, false, detail);
  }

  element.dispatchEvent(event);
};
export default triggerEvent;
