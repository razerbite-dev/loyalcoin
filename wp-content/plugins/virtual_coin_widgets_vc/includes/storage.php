<?php defined( 'VCW_INDEX' ) or die( '' );

if(!class_exists('VCW_Storage')) {

    class VCW_Storage {

        static protected $option_name = 'vcw_storage';

        static public function fetch(&$data, &$last_update)
        {
            $stored = maybe_unserialize(get_option(self::$option_name, null));

            if(is_array($stored)){
                $data = $stored['data'];
                $last_update = $stored['last_update'];
                return true;
            }
            else {
                $data = null;
                $last_update = 0;
                return false;
            }
        }

        static public function save($data)
        {
            $serialized = maybe_serialize(array(
                'last_update' => time(),
                'data' => $data
            ));

            return update_option(self::$option_name, $serialized);
        }

    }
}