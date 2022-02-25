# Docker

このディレクトリは docker 関連のファイルが含まれます。

```sh
docker/
├── conf/              # wordmove を使用する場合に movefile.yaml を配置します。
└── wordpress/
    ├── mu-plugins/    # mu-plugin を追加する場合はここに追加します。
    ├── Dockerfile     # wordpress コアの Dockerfile
    ├── php-xdebug.ini # xdebug 設定
    ├── php.ini        # php 設定
    ├── plugin.txt     # 自動セットアップ時にインストールするプラグインリスト
    ├── setup.sh       # 自動セットアップスクリプト
    └── wp-cli.yml     # wp-cli 設定
```

## ショートカットコマンド

### wp-cli

```sh
npm run wp-cli {wp-cli_command}
```

### Wordmove

```sh
npm run wp-wordmove {wordmove_command}
```

- 事前に docker/conf/movefile.yml を配置する必要があります。
- ssh 時の秘密鍵や ssh config はホスト OS の ~/.ssh を参照します。

## docker-compose を拡張

`docker-compose.override.yml` を追加し必要に応じて設定を拡張できます。

```yaml
# 例） mailhog を追加する場合

version: "3.1"

services:
  mailhog:
    image: mailhog/mailhog
    ports:
      - $LOCAL_MAIL_PORT:8025
      - $LOCAL_SMTP_PORT:1025
```

[参考](https://docs.docker.jp/compose/extends.html)
