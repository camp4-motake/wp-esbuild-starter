/**
 * 不要なデフォルトブロックを解除
 *
 * ex)
 * https://www.nxworld.net/wp-gutenberg-remove-default-block-using-blacklist.html
 */
export default () => {
  // 非表示ブロックリスト
  const disallowedBlock = [
    // 'core/missing',
    // 'core/block',

    // テキスト
    // 'core/paragraph', // 段落
    // 'core/heading', // 見出し
    // 'core/list', // リスト
    // 'core/quote', // 引用
    // 'core/code', // コード
    // 'core/html',
    // 'core/freeform', // クラシック
    // 'core/preformatted', // 整形済みテキスト
    // 'core/pullquote', // プルクオート
    // 'core/table', // テーブル
    'core/verse', // 詩

    // メディア
    // 'core/embed',
    // 'core/image', // 画像
    'core/gallery', // ギャラリー
    'core/audio', // 音声
    // 'core/cover', // カバー
    'core/file', // ファイル
    // 'core/media-text', // メディアと文章
    'core/video', // 動画

    // デザイン
    // 'core/button',  // ボタン
    // 'core/buttons', // ボタン
    // 'core/column', // カラム
    // 'core/columns', // カラム
    // 'core/group', // グループ
    'core/more', // 続きを読む
    // 'core/nextpage', // ページ区切り
    // 'core/separator', // 区切り
    // 'core/spacer', // スペーサー

    // ウィジェット
    // 'core/shortcode', // ショートコード
    'core/archives', // アーカイブ
    'core/calendar', // カレンダー
    'core/categories', // カテゴリー
    // 'core/html', // カスタムHTML
    'core/latest-comments', // 最新のコメント
    'core/latest-posts', // 最新の投稿
    'core/rss', // RSS
    'core/social-links', // ソーシャルアイコン
    'core/tag-cloud', // タグクラウド
    'core/search', // 検索

    // WP5.8~
    'core/page-list',
    'core/text-columns',
    'core/site-logo',
    'core/site-tagline',
    'core/site-title',
    'core/query',
    'core/post-template',
    'core/query-title',
    'core/query-pagination',
    'core/query-pagination-next',
    'core/query-pagination-numbers',
    'core/query-pagination-previous',
    'core/post-title',
    'core/post-content',
    'core/post-date',
    'core/post-excerpt',
    'core/post-featured-image',
    'core/post-terms',

    // Yoast SEO
    'yoast-seo/breadcrumbs',
    'yoast/faq-block',
    'yoast/how-to-block',

    // contact form7
    'contact-form-7/contact-form-selector',
  ];

  // embedで許可するブロック
  const allowedEmbedVariation = ['twitter', 'youtube', 'vimeo', 'wordpress'];

  wp.domReady(() => {
    // 不許可デフォルトブロックを解除
    disallowedBlock.forEach((block) => {
      wp?.blocks?.unregisterBlockType(block);
    });

    // embedの許可ブロック以外を解除
    wp?.blocks?.getBlockVariations('core/embed').forEach((valiation) => {
      if (allowedEmbedVariation.indexOf(valiation.name) !== -1) return;
      wp?.blocks?.unregisterBlockVariation('core/embed', valiation.name);
    });
  });
};
