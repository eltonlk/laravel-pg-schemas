<?php namespace Eltonlk\LaravelPgSchemas\Facades;

use Illuminate\Support\Facades\Facade;

class PGSchema extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() {
      return 'pgschema';
  }

}
