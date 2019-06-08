<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTable extends Migration
{
    protected function schemas(){
        return [
            "t_team" => function(Blueprint $table){
                $table->increments('id');
                $table->string("team_id");
                $table->string("team_domain_key");
                $table->string("name");
                $table->binary("raw");
                $table->string("slack_token");
                $table->timestamps();
            },
            "t_team_clientkey" => function(Blueprint $table){
                $table->increments('id');
                $table->unsignedInteger("team_id");
                $table->string("name");
                $table->string("client_key");
                $table->string("client_secret");
                $table->timestamps();
            },
            "t_user" => function(Blueprint $table){
                $table->increments('id');
                $table->unsignedInteger("team_id");
                $table->string("user_key");
                $table->string("name");
                $table->binary("raw");
                $table->boolean("is_inactive");
                $table->timestamps();
            },
            "t_user_token" => function(Blueprint $table){
                $table->increments('id');
                $table->unsignedInteger("user_id");
                $table->string("token");
                $table->dateTime("expired_at");
                $table->timestamps();
            },
            "t_request" => function(Blueprint $table){
                $table->increments('id');
                $table->timestamps();
            },
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->schemas() as $tableName => $schema) {
            Schema::create($tableName,$schema);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->schemas() as $tableName => $schema) {
            Schema::dropIfExists($tableName);
        }
    }
}
