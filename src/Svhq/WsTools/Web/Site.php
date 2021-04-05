<?php


namespace Svhq\WsTools\Web {

    use Svhq\Core\Inflated;
    use Svhq\Core\Inflating;
    use Svhq\WsTools\Web\Repo\Repository;

    class Site extends Inflated {

        use Inflating;

        private ?int $id;
        private string $domain;
        private string $installPath;
        private string $publicPath;
        private ?Repository $repository;

        public function __construct($data = null){
            if(property_exists($data, 'repository')){
                $repository = $data->repository;
                unset($data->repository);
            }

            parent::__construct($data);

            if(isset($repository)){
                if($repository instanceof Repository){
                    $this->repository = $repository;
                }
            }
        }

        /**
         * @return int|null
         */
        public function id(): ?int{
            if(isset($this->id)){
                return $this->id;
            }
            return null;
        }

        /**
         * @return string
         */
        public function domain(): string{
            return $this->domain;
        }

        /**
         * @param string $domain
         */
        public function setDomain(string $domain): void{
            $this->domain = $domain;
        }

        /**
         * @return string
         */
        public function installPath(): string{
            return $this->installPath;
        }

        /**
         * @param string $installPath
         */
        public function setInstallPath(string $installPath): void
        {
            $this->installPath = $installPath;
        }

        /**
         * @return string
         */
        public function publicPath(): string{
            return $this->publicPath;
        }

        /**
         * @param string $publicPath
         */
        public function setPublicPath(string $publicPath): void{
            $this->publicPath = $publicPath;
        }

        public function jsonSerialize(){
            $simple = (object) [
                'domain' => $this->domain(),
                'installPath' => $this->installPath(),
                'publicPath' => $this->publicPath()
            ];
            if(isset($this->id)){
                $simple->id = $this->id;
            }
            if(isset($this->repository)){
                $simple->repository = $this->repository->jsonSerialize();
            }
            return $simple;
        }

        /**
         * @return Repository|null
         */
        public function repository(): ?Repository{
            if(isset($this->repository)){
                return $this->repository;
            }
            return null;
        }

        /**
         * @param Repository|null $repository
         */
        public function setRepository(Repository $repository = null): void{
            $this->repository = $repository;
        }
    }
}