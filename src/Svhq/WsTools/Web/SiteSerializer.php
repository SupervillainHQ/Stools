<?php


namespace Svhq\WsTools\Web {

    use Phalcon\Di;
    use Svhq\Incubation\Model\Serializer;

    class SiteSerializer implements Serializer{

        /**
         * @var Site
         */
        private Site $site;

        public function __construct(Site $site){
            $this->site = $site;
        }

        public static function serializeType(): string{
            return Site::class;
        }

        public static function get(object $params){}
        public static function getById(int $id){}
        public static function getAll(){}

        public static function insert(object $data): object{
            $site = new Site($data);
            $siteSerializer = new SiteSerializer($site);
            $siteSerializer->create();
            return $siteSerializer->site;
        }

        public function create(){
            $db = Di::getDefault()->get('sqlite');
            $query = "insert into sites (repositoryId, domain, installPath, publicPath, createdAt)
                        values(:repositoryId, :domain, :installPath, :publicPath, strftime('%Y-%m-%d %H:%M:%S', 'now'))";
            $values = [
                'repositoryId' => null,
                'domain' => $this->site->domain(),
                'installPath' => $this->site->installPath(),
                'publicPath' => $this->site->publicPath()
            ];
            $bindTypes = [
                'repositoryId' => \PDO::PARAM_NULL
            ];

            if($repository = $this->site->repository()){
                $values['repositoryId'] = $repository->id();
                $bindTypes['repositoryId'] = \PDO::PARAM_INT;
            }
            $db->execute($query, $values, $bindTypes);

            $data = $this->site->jsonSerialize();
            $data->id = intval($db->lastInsertId());
            $this->site = new Site($data);
        }

        public function save(){}
        public function update(object $updates){}
        public function delete(){}
    }
}