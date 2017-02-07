<?php

namespace AdiFaidz\Base\Helpers;

use Illuminate\Support\Facades\DB;

class DBSeederHelper
{

    public static function enableForeignKeyChecks()
    {
        if ('sqlsrv' == DB::connection()->getDriverName()) {
            \Schema::table(config('basetrust.userprofiles_table'),function($table){
              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            \Schema::table(config('basetrust.role_user_table'),function($table){
                $table->foreign('user_id')->references('id')->on(config('basetrust.users_table'))
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on(config('basetrust.roles_table'))
                    ->onUpdate('cascade')->onDelete('cascade');
            });

            \Schema::table(config('basetrust.permission_role_table'),function($table){
              $table->foreign('permission_id')->references('id')->on(config('basetrust.permissions_table'))
                  ->onUpdate('cascade')->onDelete('cascade');
              $table->foreign('role_id')->references('id')->on(config('basetrust.roles_table'))
                  ->onUpdate('cascade')->onDelete('cascade');
            });
        }
        else{
          DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }

    public static function disableForeignKeyChecks()
    {
        if ('sqlsrv' == DB::connection()->getDriverName()) {
            \Schema::table(config('basetrust.userprofiles_table'),function($table){
              $table->dropForeign(['user_id']);
            });

            \Schema::table(config('basetrust.role_user_table'),function($table){
              $table->dropForeign(['user_id']);
              $table->dropForeign(['role_id']);
            });

            \Schema::table(config('basetrust.permission_role_table'),function($table){
              $table->dropForeign(['role_id']);
              $table->dropForeign(['permission_id']);
            });
        }
        else{
          DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }
    }
}
