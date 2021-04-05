<?php


namespace Svhq\WsTools\Web\Repo {


    use Phalcon\Di;
    use Svhq\Incubation\Model\Serializer;

    class GitRepositorySerializer implements Serializer {
        /**
         * @var GitRepository
         */
        private GitRepository $repository;

        public function __construct(GitRepository $repository){
            $this->repository = $repository;
        }

        public static function serializeType(): string{
            return GitRepository::class;
        }

        public static function get(object $params){}
        public static function getById(int $id){}
        public static function getAll(){}

        public static function insert(object $data):object{
            $repository = new GitRepository($data);
            $serializer = new GitRepositorySerializer($repository);
            $serializer->create();
            return $serializer->repository();
        }

        public function create(){
            $db = Di::getDefault()->get('sqlite');
            $query = "insert into repositories (url, type)
                        values(:url, :type)";
            $values = [
                'url' => $this->repository->url(),
                'type' => $this->repository->type()
            ];

            $db->execute($query, $values);

            $data = $this->repository->jsonSerialize();
            $data->id = intval($db->lastInsertId());
            $this->repository = new GitRepository($data);
        }

        public function save(){}
        public function update(object $updates){}
        public function delete(){}

        /**
         * @return GitRepository
         */
        public function repository(): GitRepository{
            return $this->repository;
        }
    }
}