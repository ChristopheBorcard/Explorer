<?php

declare(strict_types=1);

namespace JeroenG\Explorer\Domain\Syntax;

class HasChild implements SyntaxInterface
{
    public function __construct(
        private string          $type,
        private SyntaxInterface $query,
        private ?int            $max_children = null,
        private ?int            $min_children = null,
        private string          $score_mode = 'none',
    ) {
    }

    public function build(): array
    {
        $build = [
            'type'       => $this->type,
            'query'      => $this->query->build(),
            'score_mode' => $this->score_mode,
        ];

        if ($this->max_children !== null) {
            $build['max_children'] = $this->max_children;
        }

        if ($this->min_children !== null) {
            $build['min_children'] = $this->min_children;
        }

        return [
            'has_child' => $build,
        ];
    }
}
