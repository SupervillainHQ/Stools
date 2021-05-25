<?php


namespace Svhq\Incubation\Cli {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\CliParser;

    abstract class ParentCommand implements CliCommand {
        /**
         * @var mixed|string|null
         */
        protected ?string $subCommand;

        public function __construct(string $subCommand = null) {
            if(is_null($subCommand)){
                $subCommand = CliParser::instance()->getCommand(1)->value();
            }
            $this->subCommand = $subCommand;
        }
    }
}