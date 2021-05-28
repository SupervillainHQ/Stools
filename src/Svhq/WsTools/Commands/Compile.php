<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Incubation\Cli\ParentCommand;
    use Svhq\WsTools\Commands\Content\StaticHtml;

    /**
     * Precompile content for static delivery
     * Class Compile
     * @package Svhq\WsTools\Commands\Content
     */
    class Compile extends ParentCommand implements CliCommand {

        const HTML = 'html';

        function execute(): ?int{
            switch ($this->subCommand){
                case self::HTML:
                    $sub = new StaticHtml(StaticHtml::IMPORT);
                    return $sub->execute();
            }
            return ExitCodes::GENERIC_ERROR;
        }
    }
}