<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaratrustSetupTables extends Migration
{
    protected $users_table;
    protected $roles_table;
    protected $permissions_table;
    protected $role_user_table;
    protected $permission_role_table;

    public function __construct(){
      $this->users_table = config('basetrust.users_table');
      $this->roles_table = config('basetrust.roles_table');
      $this->permissions_table = config('basetrust.permissions_table');
      $this->role_user_table = config('basetrust.role_user_table');
      $this->permission_role_table = config('basetrust.permission_role_table');
    }

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create($this->roles_table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create($this->role_user_table, function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on($this->users_table)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on($this->roles_table)
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create($this->permissions_table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create($this->permission_role_table, function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on($this->permissions_table)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on($this->roles_table)
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop($this->permission_role_table);
        Schema::drop($this->permissions_table);
        Schema::drop($this->role_user_table);
        Schema::drop($this->roles_table);
    }
}
