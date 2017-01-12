<?php

namespace AdiFaidz\Base\Traits;

trait TableInfoTrait{

  public static function getColumns()
  {
    return \Schema::getColumnListing(with(new self)->getTable());
  }

}
