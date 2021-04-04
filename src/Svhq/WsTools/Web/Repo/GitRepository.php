<?php


namespace Svhq\WsTools\Web\Repo {


    class GitRepository{

        public static function fromConnectionString(string $connectionString):GitRepository{
            return new GitRepository();
        }

        public function clone(){}

        public function checkOut(){}
    }
}