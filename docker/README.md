# 開発用 WordPress 設定

ライブリロードでの作業には、docker で ローカル開発環境を起動し、必要な設定を行います。

## 必要要件

- Node.js 18
- [docker クライアント](https://www.docker.com/get-started)

## WordPress のセットアップ

以降の手順はワークスペースルートを想定しています。

1, 作成していない場合は .env を作成します。

```sh
cp ./docker/.env-sample ./.env
```

2, プロジェクトルートに、ACF Pro インストール用の [auth.json](https://www.advancedcustomfields.com/resources/installing-acf-pro-with-composer/) を作成し、`username` に ACF Pro のライセンスキーを指定します。

```json
{
  "http-basic": {
    "connect.advancedcustomfields.com": {
      "username": "{ACF_PRO_KEY}",
      "password": "https://camp4.jp/"
    }
  }
}
```

3, 以下の手順でセットアップを実行します。

```sh
# 1, npm / composer で依存モジュールやプラグインをインストール
npm run setup:tools

# 2, docker を起動
docker compose up -d

# WordPress 初期設定を実行（管理画面で設定、または他のデータベースをインポートする場合は不要です）
npm run setup:wp
```

初期設定では<http://localhost:${WP_PORT}> (ユーザー名: admin、パスワード: admin)　で利用可

> 下層ページが表示されない場合は `npm run wp-cli 'wp rewrite flush --hard'`コマンドで flush してください（または管理画面からパーマリンクを更新）。
