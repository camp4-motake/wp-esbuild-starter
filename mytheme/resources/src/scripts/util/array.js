/**
 * 配列からランダム取り出し
 */
export const randomExtract = (array) =>
  array[Math.floor(Math.random() * array.length)];

/**
 * 配列シャッフル
 */
export const shuffleArray = (array) =>
  array
    .map((a) => [Math.random(), a])
    .sort((a, b) => a[0] - b[0])
    .map((a) => a[1]);

/**
 * slice - 配列オブジェクトを生成
 *
 * ※IE対策などに
 */
// export const slice = (obj: object) =>
//   obj ? Array.prototype.slice.call(obj, 0) : [];
