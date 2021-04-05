<?php


namespace Svhq\WsTools\Web {

    use Svhq\Core\Inflated;
    use Svhq\Core\Inflating;

    class Site extends Inflated {

        use Inflating;

        private string $domain;
        private string $installPath;
        private string $publicPath;



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
        public function setPublicPath(string $publicPath): void
        {
            $this->publicPath = $publicPath;
        }

        public function jsonSerialize(){
            return (object) [
                'domain' => $this->domain(),
                'installPath' => $this->installPath(),
                'publicPath' => $this->publicPath()
            ];
        }
    }
}