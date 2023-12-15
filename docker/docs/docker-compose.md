# docker compose CLI

## tools

```sh
# wp cli
docker compose run --rm cli bash -c wp plugin list

# composer
docker compose run --rm composer update

# composer (例: 別ディレクトリを対象に実行する場合)
docker compose run --rm composer bash -c 'composer update -d source/wp-content/themes/$WP_THEME_NAME'
```

## docker compose

```sh
# コンテナを生成して起動
docker compose up -d

# サービスを起動
docker compose start

# サービスを停止
docker compose stop

# コンテナを再起動
docker compose restart

# コンテナーとネットワークを停止して削除
docker compose down

# コンテナーとネットワークを停止してボリューム削除（注：永続化していないデータベースやアップロード画像などがすべて削除されます）
docker compose down -v

# [利用時注意] 完全に削除 - docker compose で作られた、コンテナ、イメージ、ボリューム、ネットワークそして未定義コンテナ、全てを一括消去
docker compose down --rmi all --volumes --remove-orphans
```

その他のコマンドや詳細は[公式ドキュメント](https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/commandline/compose/)など参照
