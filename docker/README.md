# 開発用 WordPress 設定

ライブリロードでの作業には、docker で ローカル開発環境を起動し、必要な設定を行います。

## 必要要件

- Node.js >=18
- [docker クライアント](https://www.docker.com/get-started)

## WordPress のセットアップ

以降の手順はワークスペースルートを想定しています。

1, 以下のコマンドを実行します。プロジェクトルートに`.env`と`auth.json`が作成されます。

```sh
npm run setup:init
```

> 注: `.env`と`auth.json`がすでに存在している場合は生成されません。
> .env ファイルが先に存在してる場合は docker/.env-sample の内容を参考に追記してください。

2, [auth.json](https://www.advancedcustomfields.com/resources/installing-acf-pro-with-composer/) の `username` キーに ACF Pro のライセンスキーを指定します。

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
# 1, docker を起動
docker compose up -d

# 2, composer で依存モジュールやプラグインをインストール
npm run setup:plugins

# 3, [任意]WordPress の簡易設定を実行（管理画面で手動設定、または他のデータベースをインポートする場合は不要です）
npm run setup:wp
```

初期設定では<http://localhost:${WP_PORT}> (ユーザー名: admin、パスワード: admin)　で利用可

> 下層ページが表示されない場合は `npm run wp-cli 'wp rewrite flush --hard'`コマンドで flush、または管理画面でパーマリンクを更新

---

## その他

```sh
# コンテナを再起動
docker compose restart

# docker compose を停止
docker compose down

# docker compose を停止し環境内のボリュームをすべて削除（注： -v ではデータベースやアップロード画像などがすべて削除されます）
docker compose down -v

# [利用時注意] 完全に削除 - docker compose で作られた、コンテナ、イメージ、ボリューム、ネットワークそして未定義コンテナ、全てを一括消去
docker compose down --rmi all --volumes --remove-orphans
```
