/**
 * ユーティリティ：指定ミリ秒待ってから関数を実行
 *
 * 例:
 * sleep(500).then(callback);
 *
 */
const sleep = (ms) =>
  new Promise((resolve) => setTimeout(() => resolve(null), ms));

export default sleep;
