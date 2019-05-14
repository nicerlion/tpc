<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


if (!class_exists('TPC_Model')) {
    include_once(dirname(__FILE__) . '/class-model.php');
}


class Card_User_Data extends TPC_Model {

    static $database_fields = array(
        'type' => 'varchar(255) NULL',
        'cvv' => 'varchar(255) NULL',
        'expiration_date' => 'varchar(255) NULL',
        'member_id' => 'bigint(20) UNSIGNED',
        'number' => 'bigint(20) UNSIGNED',
        'order_limelight_id' => 'bigint(20) UNSIGNED',
    );

    private function get_foreign_key($field, $function) {  // singleton
        if ($this->{self::$primary_key}) {
            if (isset($this->{$field})) {
                return $this->{$field};
            } else if (isset($this->{$field . '_id'})) {
                $resolve = $function($this->{$field . '_id'});
                return $resolve;
            }
        }
        return null;
    }

    public function get_user() {
        if (isset($this->user)) {
            return $this->user;
        }
        return get_user_by('id', $this->member_id);
    }

    public function get_member() {
        $member = function ($id) {
            $user = get_user_by('id', $id);
            $membership = $this->get_membership();
            return wc_memberships_get_user_membership($user->ID, $membership->id);
        };
        return $this->get_foreign_key('member', $member);
    }

    public function get_membership() {
        $membership = function($id) {
            return wc_memberships_get_membership_plan($id);
        };
        return $this->get_foreign_key('membership', $membership);
    }

    public static function get_from_user_id($user_id) {
        global $wpdb;
        $sql = sprintf('SELECT * FROM %s WHERE %s = %%s', self::_table(), 'member_id');
        $prepare = $wpdb->prepare($sql, $user_id);
        $returned = $wpdb->get_row($prepare);
        $class = get_called_class();
        return new $class((array) $returned);;
    }
}

?>
