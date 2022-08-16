/**
 * ブロックエディターカスタムアクション用JS
 */

//投稿ボタン無効化フラグ
let isLocked = false;

/**
 * 記号・2バイト文字スラッグ禁止メッセージを表示
 */
const validateSlug = () => {
  const slug = wp.data.select('core/editor').getEditedPostAttribute('slug');

  if (slug === '') return;

  const isValid = String(slug).match(/^[a-zA-Z0-9-_]*$/);

  if (!isValid) {
    if (!isLocked) {
      isLocked = true;
      wp.data.dispatch('core/editor').lockPostSaving('slug-invalid');
      wp.data
        .dispatch('core/notices')
        .createNotice(
          'warning',
          '「パーマリンク」の「URLスラッグ」に無効な文字が含まれています。半角英数字のみで設定してください（空白・記号や、日本語などの全角文字は使用できません）',
          { id: 'slug-invalid', isDismissible: false }
        );
    }
  } else if (isLocked) {
    isLocked = false;
    wp.data.dispatch('core/editor').unlockPostSaving('slug-invalid');
    wp.data.dispatch('core/notices').removeNotice('slug-invalid');
  }
};

export default () => {
  if (!wp || !window.CUSTOM_THEME_SLUG_STRING_CHECK) {
    return;
  }
  wp.data.subscribe(validateSlug);
};
