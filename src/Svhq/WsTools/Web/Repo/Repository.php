<?php


namespace Svhq\WsTools\Web\Repo {

    interface Repository extends \JsonSerializable {
        public function id():?int;
    }
}