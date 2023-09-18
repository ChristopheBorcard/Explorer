<?php

declare(strict_types=1);

namespace JeroenG\Explorer\Tests\Unit\Syntax;

use JeroenG\Explorer\Domain\Syntax\Multiple;
use JeroenG\Explorer\Domain\Syntax\Nested;
use JeroenG\Explorer\Domain\Syntax\Term;
use JeroenG\Explorer\Domain\Syntax\Wildcard;
use PHPUnit\Framework\TestCase;

class MultipleTest extends TestCase
{
    public function test_it_builds_the_right_query(): void
    {
        $subject = new Nested(
            'test', new Multiple(
                [
                    new Term('test.id', '5', 5.5),
                    new Wildcard('test.name', '12*', 4.4)
                ]
            )
        );

        $expected = [
            'nested' => [
                'path'  => 'test',
                'query' => [
                    [
                        'term' => [
                            'test.id' => [
                                'value' => '5',
                                'boost' => 5.5,
                            ]
                        ]
                    ],
                    [
                        'wildcard' => [
                            'test.name' =>
                                [
                                    'value'            => '12*',
                                    'boost'            => 4.4,
                                    'case_insensitive' => false,
                                    'rewrite'          => 'constant_score',
                                ],
                        ],
                    ]
                ],
            ]
        ];

        $query = $subject->build();

        self::assertSame($expected, $query);
    }
}
