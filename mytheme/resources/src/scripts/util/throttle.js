/**
 * throttle
 *
 * ※ same lodash _.throttle
 * https://github.com/you-dont-need/You-Dont-Need-Lodash-Underscore#_throttle
 *
 * @param {Function} func
 * @param {Number} timeFrame
 */
export default (func, timeFrame) => {
  let lastTime;

  return (...args) => {
    const now = new Date().getTime();
    if (now - lastTime >= timeFrame) {
      func(...args);
      lastTime = now;
    }
  };
};
