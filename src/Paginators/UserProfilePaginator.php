<?php

namespace AdiFaidz\Base\Paginators;

use AdiFaidz\Base\Transformers\Transformer;
use AdiFaidz\Base\Paginators\Paginator;

class UserProfilePaginator extends Paginator {
  protected $model;

  public function __construct(Transformer $transformer){
    $this->transformer = $transformer;
    $this->model = config('basetrust.userprofile');
  }

  public function filterData($data){
    $data->where(function($q) {
      $filter = request()->filter;
      $value = "%$filter%";
      $q->where('id', 'like', $value)
				->orWhere('created_at', 'like', $value)
				->orWhere('updated_at', 'like', $value);
    });

    return $data;
  }
}
