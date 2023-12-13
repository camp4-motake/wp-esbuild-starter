
# docker compose CLI

## tools

```sh
# wp cli
docker compose run --rm cli bash -c wp plugin list

# composer (ex: wp plugin update)
docker compose run --rm composer update

# composer (ex: theme module update)
docker compose run --rm composer bash -c 'composer update -d source/wp-content/themes/$WP_THEME_NAME'
```

## docker compose

```sh
# コンテナを起動
docker compose up -d

# コンテナを再起動
docker compose restart

# コンテナを停止
docker compose down

# コンテナを停止し環境内のボリュームをすべて削除（注： -v ではデータベースやアップロード画像などがすべて削除されます）
docker compose down -v

# [利用時注意] 完全に削除 - docker compose で作られた、コンテナ、イメージ、ボリューム、ネットワークそして未定義コンテナ、全てを一括消去
docker compose down --rmi all --volumes --remove-orphans
```

その他のコマンドや詳細は[公式ドキュメント](https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/commandline/compose/)など参照
