<?php

namespace AdiFaidz\Base;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  Router  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forAuth();
        $this->forAdmins();
        $this->forClients();
        $this->forApi();
    }

    /**
     * Register the routes needed for managing authentications.
     *
     * @return void
     */
    public function forAuth(){
      $this->router->group(['middleware' => ['web']], function(){
        require_once __DIR__ . '/../routes/auth.php';
      });
    }

    /**
     * Register the routes needed for managing admins.
     *
     * @return void
     */
    public function forAdmins(){
      $this->router->group(['middleware' => ['web'], 'prefix' => 'admin'], function(){
        require_once __DIR__ . '/../routes/admin.php';
      });
    }

    /**
     * Register the routes needed for managing clients.
     *
     * @return void
     */
    public function forClients(){
      $this->router->group(['middleware' => ['web']], function(){
        require_once __DIR__ . '/../routes/client.php';
      });
    }

    /**
     * Register the routes needed for managing authentications.
     *
     * @return void
     */
    public function forApi(){
      $this->router->group(['middleware' => ['api'], 'prefix' => 'api'], function(){
        require_once __DIR__ . '/../routes/api.php';
      });
    }
}
