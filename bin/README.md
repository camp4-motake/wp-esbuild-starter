
# ヘルパーコマンド

## wp-　setup

自動セットアップを実行します (要docker クライアント)

```sh
npm run wp-setup
```

## wp-cli

dockerコンテナ内で [wp-cli コマンド](https://developer.wordpress.org/cli/commands/)を実行します。

```sh
npm run wp-cli '{wp-cli_command}'
```

## Wordmove

コンテナから [wordmove コマンド](https://github.com/welaika/wordmove#usage)を実行します

```sh
npm run wp-wordmove '{wordmove_command}'
```

- 実行には、事前にデプロイ先のサーバーへの ssh 接続設定と、設定済みの `docker/conf/movefile.yml` を配置しておく必要があります。
- ssh 時の秘密鍵や ssh config はホスト OS の ~/.ssh を参照します。
