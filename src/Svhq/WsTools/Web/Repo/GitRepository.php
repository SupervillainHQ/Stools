<?php


namespace Svhq\WsTools\Web\Repo {


    use Svhq\Core\Inflated;
    use Svhq\Core\Inflating;

    class GitRepository extends Inflated implements Repository {
        const TYPE_GIT = 'git';
        const TYPE_HG = 'hg';

        use Inflating;

        private ?int $id;
        private string $url;
        private string $type;

        public static function fromConnectionString(string $connectionString):GitRepository{
            return new GitRepository();
        }

        public function clone():Repository{
            $cloned = $this->jsonSerialize();
            return new GitRepository($cloned);
        }

        public function cloneRemote(){}

        public function checkoutRemote(){}

        public function jsonSerialize(){
            $simple = (object) [
                'url' => $this->url,
                'type' => $this->type,
            ];
            if(isset($this->id)){
                $simple->id = $this->id;
            }

            return $simple;
        }

        /**
         * @return int|null
         */
        public function id(): ?int
        {
            return $this->id;
        }

        /**
         * @return string
         */
        public function url(): string{
            return $this->url;
        }

        /**
         * @param string $url
         */
        public function setUrl(string $url): void{
            $this->url = $url;
        }

        /**
         * @return string
         */
        public function type(): string{
            return $this->type;
        }

        /**
         * @param string $type
         */
        public function setType(string $type): void{
            $this->type = $type;
        }
    }
}