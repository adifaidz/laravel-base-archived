<?php
namespace AdiFaidz\Base\Paginators;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

abstract class Paginator {
  protected $transformer;

  public function getJson(Array $fields = ['*']){
    $data = $this->model::select($fields);

    if($fields == ['*'])
      $fields = $data->getModel()->getColumns();

    return $this->generateJson($data, $fields);
  }

  protected function generateJson($data, $fields){
    if (request()->has('sort')) {
      list($sortCol, $sortDir) = explode('|', request()->sort);
      $data->orderBy($sortCol, $sortDir);
    }
    else {
      $data->orderBy('id', 'asc');
    }

    if (request()->exists('filter')) {
      $data = $this->filterData($data);
    }

    $perPage = request()->has('per_page') ? (int) request()->per_page : null;

    $paginated = $data->paginate($perPage);
    $results = $paginated->items();

    return [
      'total' => $paginated->total(),
      'per_page' => $paginated->perPage(),
      'current_page' => $paginated->currentPage(),
      'last_page' => $paginated->lastPage(),
      'from' => $paginated->firstItem(),
      'to' => $paginated->lastItem(),
      'data'=> $this->transformer->transformCollection($results)
    ];
  }

  public abstract function filterData($data);
}
