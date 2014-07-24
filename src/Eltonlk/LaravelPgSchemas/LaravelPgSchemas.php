<?php namespace Eltonlk\LaravelPgSchemas;

use Artisan, DB, Config;

class LaravelPgSchemas
{
  	/**
  	 * Create a new schema
  	 *
  	 * @return void
  	 */
    public function create($schemaName, $args = [])
    {
        $this->connection($args)->statement('CREATE SCHEMA ' . $schemaName);
    }

  	/**
  	 * Switch to use the schema
  	 *
  	 * @return void
  	 */
    public function switchTo($schemaName = 'public', $args = [])
    {
        $this->connection($args)->statement('SET search_path TO ' . $schemaName);
    }

  	/**
  	 * Drop schema
  	 *
  	 * @return void
  	 */
    public function drop($schemaName, $args = [])
    {
        $this->connection($args)->statement('DROP SCHEMA ' . $schemaName);
    }

  	/**
  	 * Invoke migrate:install on schema
  	 *
  	 * @return void
  	 */
    public function migrateInstall($schemaName, $args = [])
    {
        $this->switchTo($schemaName, $args);

        if (!$this->tableExists($schemaName, 'migrations', $args))
            $this->runCommand('migrate:install', array_only($args, '--database'));
    }

  	/**
  	 * Invoke migrate on schema
  	 *
  	 * @return void
  	 */
    public function migrate($schemaName, $args = [])
    {
        $this->switchTo($schemaName, $args);

        $this->migrateInstall($schemaName, $args);

        $this->runCommand('migrate', $args);
    }

  	/**
  	 * Invoke migrate:refresh on schema
  	 *
  	 * @return void
  	 */
    public function migrateRefresh($schemaName, $args = [])
    {
        $this->switchTo($schemaName, $args);

        $this->runCommand('migrate:refresh', $args);
    }

  	/**
  	 * Invoke migrate:refresh on schema
  	 *
  	 * @return void
  	 */
    public function migrateReset($schemaName, $args = [])
    {
        $this->switchTo($schemaName, $args);

        $this->runCommand('migrate:reset', $args);
    }

  	/**
  	 * Invoke migrate:rollback on schema
  	 *
  	 * @return void
  	 */
    public function migrateRollback($schemaName, $args = [])
    {
        $this->switchTo($schemaName, $args);

        $this->runCommand('migrate:rollback', $args);
    }

  	/**
  	 * Invoke artisan command
  	 *
  	 * @return void
  	 */
    protected function runCommand($commandName, $args = [])
    {
        // STDIN Fallback, we need that.
        if(!defined("STDIN")) define('STDIN', fopen("php://stdin","r"));

        // $args['--force'] = true;
        Artisan::call($commandName, $args);
    }

  	/**
  	 * Return if table exists in schema
  	 *
  	 * @return boolean
  	 */
    protected function tableExists($schemaName, $tableName, $args = [])
    {
        $tables = $this->tables($schemaName, $args);

        return in_array($tableName, $tables);
    }

  	/**
  	 * Return the tables names of schema
  	 *
  	 * @return array
  	 */
    protected function tables($schemaName, $args = [])
    {
        return $this->connection($args)
            ->table('information_schema.tables')
            ->select('table_name')
            ->where('table_schema', '=', $schemaName)
            ->lists('table_name');
    }

  	/**
  	 * Return a instance of DB::connection.
  	 *
  	 * @return DB::connection
  	 */
    protected function connection($args = []) {
        $connectionName = Config::get('database.default');

        if (isset($args['--database'])) $connectionName = $args['--database'];

        return DB::connection($connectionName);
    }

}
