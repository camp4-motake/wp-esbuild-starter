/**
 * UA （UA削減対策で利用不可）
 */

// タッチデバイス簡易判定
export const isTouchDevice = () =>
  'ontouchstart' in document && 'orientation' in window;

// WordPress: bodyタグに付与されるスラッグクラス名から現在のページを判定
export const isPage = (slug: string) => document.body.classList.contains(slug);

// WordPress: 管理バーの有無判定 （兼、簡易ログイン状態判定）
export const isWPAdminBar = () => !!document.getElementById('wpadminbar');

// URL 一致判定
export const isMatchURL = (href: string) => {
  const loc = new URL(window.location.href);
  const tgt = new URL(href);

  return (
    `${loc.origin}${loc.pathname}${loc.search}` ===
    `${tgt.origin}${tgt.pathname}${tgt.search}`
  );
};
