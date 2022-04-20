/**
 * UA （UA削減対策で利用不可）
 */
// const ua = window.navigator.userAgent.toLowerCase();

/**
 * iOS 系デバイス判定（UA削減対策で利用不可）
 */
// export const isiOS = () =>
//   ua.indexOf('iphone') > -1 ||
//   ua.indexOf('ipad') > -1 ||
//   (ua.indexOf('macintosh') > -1 && 'ontouchend' in document);

/**
 * 簡易デバイスタイプ判定 （UA削減対策で利用不可）
 */
// export const deviceType = () =>
//   /iPad/.test(navigator.userAgent)
//     ? 'tablet'
//     : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(
//         navigator.userAgent
//       )
//     ? 'mobile'
//     : 'desktop';

/**
 * タッチデバイス簡易判定
 */
export const isTouchDevice = () =>
  'ontouchstart' in document && 'orientation' in window;

/**
 * IE判定
 *
 * documentMode is an IE-only property
 * http://msdn.microsoft.com/en-us/library/ie/cc196988(v=vs.85).aspx
 */
export const isIE = window?.document?.documentMode;

/**
 * WordPress: bodyタグに付与されるスラッグクラス名から現在のページを判定
 */
export const isPage = (slug) => document.body.classList.contains(slug);

/**
 * WordPress: 管理バーの有無判定 （兼、簡易ログイン状態判定）
 */
export const isWPAdminBar = () => !!document.getElementById('wpadminbar');

/**
 * URL 一致判定
 */
export const isMatchURL = (href) => {
  const loc = new URL(window.location.href);
  const tgt = new URL(href);

  return (
    `${loc.origin}${loc.pathname}${loc.search}` ===
    `${tgt.origin}${tgt.pathname}${tgt.search}`
  );
};
