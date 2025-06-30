# 模擬案件フリマアプリ
---
## 環境構築
---
- Dockerビルド
1. 
2. DockerDesktopアプリを立ち上げる
3. docker-compose up -d --build

- Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. 「.env.example」ファイルを「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
