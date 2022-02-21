# WP esbuild starter

## 必要環境

- Node.js >=16
- [docker クライアント](https://www.docker.com/get-started)

> Local、MAMP などを使用する場合は、テーマディレクトリにシンボリックリンクを設定してください。

## 初期設定

1 - .env-sample をコピーし環境変数ファイル .env を作成します。（必要に応じ.env の内容を変更します）

```sh
cp ./.env-example ./.env
```

2 - node_modules をインストールします

```sh
npm install
```

3 - 自動セットアップを実行。docker-compose で WordPress を起動し初期状態のセットアップを実行します（docker 利用時のみ）

```sh
npm run wp-setup
```

## コマンド

### フロントエンド

ウォッチ

```sh
npm run dev
```

ビルド

```sh
npm run build
```

### wp 関連

wp-cli

```sh
docker-compose run --rm cli bash -c "{wp-cliコマンド}"
```

wordmove

```sh
docker-compose run --rm cli bash -c "cd /home && export RUBYOPT=-EUTF-8 && {wordmoveコマンド}"
```

> 設定済みの movefile を docker/conf/movefile.yml に配置しておく必要があります。<br />
> ssh 接続の場合は、ホストの ~/.ssh の秘密鍵を参照します。

## その他

画像が反映されない場合は、ルートの `.cache/` ディレクトリを削除してから再ビルドしてください。
