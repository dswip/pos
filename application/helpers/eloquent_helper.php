<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Capsule\Manager as Capsule;
$db_config_file = FCPATH.'.database';
if(file_exists($db_config_file))
{
    // Get DB Config
    $db_config = json_decode(file_get_contents($db_config_file),TRUE);

    // Configure Database
    $capsule = new Capsule;
    foreach ($db_config as $db_group => $config)
    {
        $capsule->addConnection([
            'driver'    => ($config['dbdriver'] == 'mysqli')?'mysql':$config['dbdriver'],
            'host'      => $config['hostname'],
            'database'  => $config['database'],
            'username'  => $config['username'],
            'password'  => $config['password'],
            'charset'   => $config['char_set'],
            'collation' => $config['dbcollat'],
            'prefix'    => $config['dbprefix']
        ],$db_group);    
    }
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    /* Check Connection */
    function check_connection($connection=ENVIRONMENT)
    {
        return Capsule::connection($connection)->getPdo();
    }

    /* Show Database Columns */
    function show_columns($table=null,$connection=ENVIRONMENT)
    {
        return Capsule::connection($connection)->getSchemaBuilder()->getColumnListing((is_object($table))?$table->table:$table);
    }

    /* Get Schema Builder */
    function schema($connection=ENVIRONMENT)
    {
        return Capsule::connection($connection)->getSchemaBuilder();    
    }

    /* Show Tables */
    function show_tables($connection=ENVIRONMENT)
    {
        foreach (Capsule::connection($connection)->select('SHOW TABLES') as $value)
        {
            $tables[] = $value->{'Tables_in_'.Capsule::connection($connection)->getDatabaseName()};
        }
        return $tables;
    }

    /* Show Create Table */
    function show_create_table($table_name=null)
    {
        return Capsule::select('SHOW CREATE TABLE '.$table_name);
    }
}
/* End of file eloquent_helper.php */
/* Location: ./application/helpers/eloquent_helper.php */