<?php

declare(strict_types=1);

namespace JeroenG\Explorer\Domain\Syntax;

class Multiple implements SyntaxInterface
{
    public function __construct(
        private array $queries,
    )
    {
    }

    public function build(): array
    {
        $build = [];

        foreach ($this->queries as $query){
            if($query instanceof SyntaxInterface){
                $build[] = $query->build();
            }
        }

        return $build;
    }
}
