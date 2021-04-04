<?php


namespace Svhq\WsTools\Web\Server\Apache {

    use Svhq\Core\Inflated;
    use Svhq\Core\Inflating;

    class ApacheDirectoryStanza extends Inflated {

        use Inflating;

        private string $path;
        private array $directives;

        public function __construct($data = null){
            parent::__construct($data);
            $this->directives = [
                'Options Indexes FollowSymLinks',
                'AllowOverride All',
                'Require all granted'
            ];
        }


        public function __toString():string{
            $directives = implode("\n\t\t", $this->directives);
            return "<Directory {$this->path}>\n\t\t{$directives}\n\t</Directory>";
        }

        public function jsonSerialize(){
            return (object) [
                'path' => $this->path,
                'directives' => $this->directives,
            ];
//            foreach ($this->directives as $directive) {
//                array_push($simple->directives, $directive);
//            }
//            return $simple;
        }
    }
}