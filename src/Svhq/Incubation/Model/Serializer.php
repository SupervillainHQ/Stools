<?php


namespace Svhq\Incubation\Model {


    interface Serializer{

        public static function serializeType():string;

        public static function get(object $params);
        public static function getById(int $id);
        public static function getAll();

        public static function insert(object $data):object;

        public function create();
        public function save();
        public function update(object $updates);
        public function delete();
    }
}