# 開発用 WordPress の初期設定(docker compose)

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

2, プロジェクトルートに、ACF Pro インストール用の `auth.json` を作成し、`username` に ACF Pro のライセンスキーを指定します。

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

> auth.json については[ACF Pro 公式ドキュメント](https://www.advancedcustomfields.com/resources/installing-acf-pro-with-composer/)参照

3, 以下の手順でセットアップを実行します。

```sh
# 1, npm / composer で依存モジュールやプラグインをインストール
npm run setup:tools

# 2, docker を起動
docker compose up -d

# 3, WordPress の初期設定を実行（手作業で設定する場合や、他のデータベースをインポートする場合は不要）
npm run setup:wp
```

初期設定では<http://localhost:$WP_PORT> (ユーザー名: admin、パスワード: admin)　で利用可

> 下層ページが表示されない場合は `npm run wp-cli 'wp rewrite flush --hard'`コマンドで flush してみてください。
