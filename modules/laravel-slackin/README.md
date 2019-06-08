# Laravel Webhook

## functions 

- recieve Webhook
- builtin listener

## Usage

モジュールをインストールすることで、以下の構成がセットアップされます。

- Webhook 用の URL `ANY /webhook` のセットアップ
- Webhook 記録用の マイグレーション構成のセットアップ
- Webhook ログ構成を上記

## Webhook Route

Webhook Route は Webhook からリクエストを受け取り、
`Chatbox\LaravelWebhook\Events\EmitRequest` イベントを発火します。



