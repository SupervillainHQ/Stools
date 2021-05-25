<?php


namespace Svhq\WsTools\Commands\Favicon {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\CliParser;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Config\Config;

    class Create implements CliCommand {

        private static $defaultB64BmpData = "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";

        /**
         * @var mixed
         */
        private string $source;
        private string $outputFilePath;

        public function __construct($source = null, string $outputFilePath = null) {
            $this->source = $source ?? self::$defaultB64BmpData;
            // TODO: also check if source is a file-path that should be loaded

            if(is_null($outputFilePath)){
                $outputFilePath = CliParser::instance()->getArgumentValue('outputFilePath');
            }
            $this->outputFilePath = $outputFilePath ?? './public/favicon.ico';
        }

        function execute(): ?int{
            if($filePath = Config::instance()->absolutePath($this->outputFilePath, true)){
                $im = imagecreatefromstring(base64_decode($this->source));
                imagepng($im, $filePath);
                imagedestroy($im);
            }
            return ExitCodes::OK;
        }
    }
}