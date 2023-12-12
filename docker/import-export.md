# WordPress データのエクスポート・インポート

## エクスポート

```sh
npm run wp-export
```

- コンテナ内のデータベースを `env/_bkp/wp-backup-db.sql` にエクスポートします。
- コンテナ内の`wp-content/uploads`を を `env/_bkp/uploads/` 以下にコピーします。

***注：`env/_bkp/` 以下に同じディレクトリやファイルがある場合は削除・上書きされます***

## インポート

```sh
npm run wp-import
```

- `env/_bkp/wp-backup-db.sql`をDBにインポートします。
- `env/_bkp/uploads/`をコンテナ内の`wp-content/uploads`と差し替えます

***注：コンテナ内の既存の DB と uploads/ は削除・上書きされます***
