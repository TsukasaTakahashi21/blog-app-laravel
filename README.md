# 🐳

## 環境構築

### 1. .envファイルの作成

```
.env.example をコピーして作成しましょう。
コピーして名前を「.env」に変更するだけでokです。
```

### 2. コンテナの立ち上げ

```
make up
```
※ `make` コマンドは学習用に用意したコマンドとなるため、正式な Docker のコマンドではありません。

### 3. ライブラリのインストール

```
//コンテナの中に入る
make bash

//ディレクトリ移動
cd laravel-project

//ライブラリのインストール
composer install
```
※ `make` コマンドは学習用に用意したコマンドとなるため、正式な Docker のコマンドではありません。
![ターミナル](https://github.com/tech-quest/docker-laravel-template-2023/assets/114050379/2eb45d06-e354-4383-8e0d-cded27dbbbf4)


### 4. APP_KEYの設定

```
//APP_KEYの設定
php artisan key:generate
```

<br>

## コンテナの止め方

### Dockerコンテナの停止

```
make stop
```

<br>

## ページ紹介

php

[localhost:8000](http://localhost:8000)

PHPMyAdmin

[localhost:4040](http://localhost:4040)
