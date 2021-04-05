<?php


namespace Svhq\WsTools\Web {

    use Phalcon\Di;

    class SiteSerializer{

        /**
         * @var Site
         */
        private Site $site;

        public function __construct(Site $site){
            $this->site = $site;
        }

        public static function get(object $params){}
        public static function getById(int $id){}
        public static function getAll(){}

        public function create(){
            $db = Di::getDefault()->get('sqlite');
            $query = "insert into sites (domain, installPath, publicPath, createdAt)
                        values(:domain, :installPath, :publicPath, strftime('%Y-%m-%d %H:%M:%S', 'now'))";
            $values = [
                'domain' => $this->site->domain(),
                'installPath' => $this->site->installPath(),
                'publicPath' => $this->site->publicPath()
            ];
            $db->execute($query, $values);
        }

        public function save(){}
        public function update(object $updates){}
        public function delete(){}
    }
}