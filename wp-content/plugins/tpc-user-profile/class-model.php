<?php


abstract class TPC_Model {

    static $primary_key = 'id';

    public function __construct($id = null) {
        if (is_numeric($id)) {
            $instance = self::get($id);
            self::_populate_model($this, $instance->_get_values_to_save());
            $this->{self::$primary_key} = $id;
        } else if (is_array($id)) {
            // TODO: validar keys
            self::_populate_model($this, $id);
        }
    }

    public static function _table() {
        global $wpdb;
        $tablename = strtolower( get_called_class() );
        $tablename = 'tpc' . $tablename;
        return $wpdb->prefix . $tablename;
    }

    private static function _prepare_database_schema() {
        $fields = self::get_database_fields();

        if (empty($fields)) {
            throw new Exception('Cant create models if there has not fields to populate');
        }

        $sentences = self::$primary_key . ' bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,';
        $format = ' %s %s, ';

        foreach ($fields as $key => $value) {
            $sentences = $sentences . sprintf($format, $key, $value);
        }

        // $sentences = substr($sentences, 0, -1);  // remove comma
        $sql = "CREATE TABLE IF NOT EXISTS " . self::_table() . " (
            %s
            PRIMARY KEY (%s)
        );";

        $command_create = sprintf($sql, $sentences, self::$primary_key);
        return $command_create;
    }

    private static function get_database_fields() {
        $class = static::class;
        return $class::$database_fields;
    }

    public static function create_database() {
        $sql = self::_prepare_database_schema();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    private static function _fetch_sql( $value ) {
        global $wpdb;
        if (!is_array($value)) {
            $sql = sprintf( 'SELECT * FROM %s WHERE %s = %%s', self::_table(), self::$primary_key );
        } else {
            // TODO: ver como hacer esta consulta
            passthru;
        }
        return $wpdb->prepare( $sql, $value );
    }

    static function get_from_db( $value ) {
        global $wpdb;
        return $wpdb->get_row( self::_fetch_sql( $value ) );
    }

    static function _insert( $data ) {
        global $wpdb;
        $wpdb->insert( self::_table(), $data );
    }

    static function _update( $data, $where ) {
        global $wpdb;
        $wpdb->update( self::_table(), $data, $where );
    }

    static function delete( $value ) {
        global $wpdb;
        $sql = sprintf( 'DELETE FROM %s WHERE %s = %%s', self::_table(), self::$primary_key );
        return $wpdb->query( $wpdb->prepare( $sql, $value ) );
    }

    static function insert_id() {
        global $wpdb;
        return $wpdb->insert_id;
    }

    static function time_to_date( $time ) {
        return gmdate( 'Y-m-d H:i:s', $time );
    }

    static function now() {
        return self::time_to_date( time() );
    }

    static function date_to_time( $date ) {
        return strtotime( $date . ' GMT' );
    }

    private static function _populate_model($model_instance, $values) {
        foreach ($values as $key => $value) {
            $model_instance->{$key} = $value;
        }
    }

    public static function get($value) {
        $data = self::get_from_db($value);
        $class_name = get_called_class();
        $instance = new $class_name();
        self::_populate_model($instance, $data);
        return $instance;
    }

    public function save() {
        if (isset($this->{self::$primary_key})) {
            return $this->update();
        }
        return $this->create();
    }

    private function _get_values_to_save() {
        $fields = self::get_database_fields();
        $values_insert = array();
        foreach ($fields as $key => $value) {
            $values_insert[$key] = $this->{$key};
        }
        return $values_insert;
    }

    private function create() {
        global $wpdb;
        $data = $this->_get_values_to_save();
        self::_insert($data);
        $id = $wpdb->insert_id;
        $this->{self::$primary_key} = $id;
    }

    private function update() {
        $data = $this->_get_values_to_save();
        self::_update($data, array(self::$primary_key => $this->{self::$primary_key}));
    }
}

?>