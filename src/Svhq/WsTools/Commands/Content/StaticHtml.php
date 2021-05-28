<?php


namespace Svhq\WsTools\Commands\Content {

    use Michelf\Markdown;
    use Phalcon\Di;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\CliParser;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Config\Config;

    class StaticHtml implements CliCommand {
        const IMPORT = 'import';

        /**
         * @var mixed|string|null
         */
        private ?string $subCommand;

        public function __construct(string $subCommand = null) {
            if(is_null($subCommand)){
                $subCommand = CliParser::instance()->getCommand(1)->value();
            }
            $this->subCommand = $subCommand;
        }

        function execute(): ?int {
            switch ($this->subCommand){
                case self::IMPORT:
                    $mdFile = CliParser::instance()->getArgumentValue('file');
                    $outputFilePath = CliParser::instance()->getArgumentValue('out');

                    $outputFilePathResolved = Config::instance()->absolutePath($outputFilePath, true);

                    if($mdFilePath = Config::instance()->absolutePath($mdFile)){
                        $mdFile = file_get_contents($mdFilePath);
                    }
                    $html = Markdown::defaultTransform($mdFile);
                    $resMan = Di::getDefault()->getResource($outputFilePathResolved);
                    $resMan->write($html, true);

                    return ExitCodes::OK;
            }
            return ExitCodes::OK;
        }
    }
}