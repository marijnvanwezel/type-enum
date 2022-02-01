<?php declare(strict_types=1);
/*
 * This file is part of marijnvanwezel/type-enum.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MarijnVanWezel\TypeEnum\Tests;

use Exception;
use MarijnVanWezel\TypeEnum\Type;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MarijnVanWezel\TypeEnum\Type
 */
class TypeTest extends TestCase
{
	public function testArray(): void
	{
		$this->assertTrue((Type::ARRAY)->matches(['a']));
		$this->assertFalse((Type::ARRAY)->matches('array'));
	}

	public function testBoolean(): void
	{
		$this->assertTrue((Type::BOOLEAN)->matches(true));
		$this->assertTrue((Type::BOOLEAN)->matches(false));
		$this->assertFalse((Type::BOOLEAN)->matches('true'));
	}

	public function testCallable(): void
	{
		$this->assertTrue((Type::CALLABLE)->matches(fn() => null));
		$this->assertFalse((Type::CALLABLE)->matches('callable'));
	}

	public function testClosedResource(): void
	{
		$resource = fopen('php://stdin', 'r');
		fclose($resource);

		$this->assertTrue((Type::CLOSED_RESOURCE)->matches($resource));
	}

	public function testDouble(): void
	{
		$this->assertTrue((Type::DOUBLE)->matches(1.0));
		$this->assertFalse((Type::DOUBLE)->matches('double'));
	}

	public function testEnum(): void
	{
		$this->assertTrue((Type::ENUM)->matches(Type::ENUM));
		$this->assertFalse((Type::ENUM)->matches('enum'));
	}

	public function testFloat(): void
	{
		$this->assertTrue((Type::FLOAT)->matches(1.0));
		$this->assertFalse((Type::FLOAT)->matches('float'));
	}

	public function testInteger(): void
	{
		$this->assertTrue((Type::INTEGER)->matches(1));
		$this->assertFalse((Type::INTEGER)->matches('integer'));
	}

	public function testIterable(): void
	{
		$this->assertTrue((Type::ITERABLE)->matches(['a']));
		$this->assertTrue((Type::ITERABLE)->matches(new class implements \Iterator
		{
			public function current(): mixed
			{
				return null;
			}

			public function next(): void
			{
			}

			public function key(): mixed
			{
				return null;
			}

			public function valid(): bool
			{
				return false;
			}

			public function rewind(): void
			{
			}
		}));
		$this->assertFalse((Type::ITERABLE)->matches('iterable'));
	}

	public function testNull(): void
	{
		$this->assertTrue((Type::NULL)->matches(null));
		$this->assertFalse((Type::NULL)->matches('null'));
	}

	public function testNumeric(): void
	{
		$this->assertTrue((Type::NUMERIC)->matches(1));
		$this->assertTrue((Type::NUMERIC)->matches(1.0));
		$this->assertTrue((Type::NUMERIC)->matches(-1));
		$this->assertTrue((Type::NUMERIC)->matches(-1.0));
		$this->assertFalse((Type::NUMERIC)->matches('numeric'));
	}

	public function testObject(): void
	{
		$this->assertTrue((Type::OBJECT)->matches(new Exception()));
		$this->assertFalse((Type::OBJECT)->matches('object'));
	}

	public function testResource(): void
	{
		$resource = fopen('php://stdin', 'r');

		$this->assertTrue((Type::RESOURCE)->matches($resource));

		fclose($resource);

		$this->assertTrue((Type::RESOURCE)->matches($resource));
		$this->assertFalse((Type::RESOURCE)->matches('resource'));
	}

	public function testScalar(): void
	{
		$this->assertTrue((Type::SCALAR)->matches(1));
		$this->assertTrue((Type::SCALAR)->matches(-1));
		$this->assertTrue((Type::SCALAR)->matches(1.0));
		$this->assertTrue((Type::SCALAR)->matches(-1.0));
		$this->assertTrue((Type::SCALAR)->matches('scalar'));
		$this->assertTrue((Type::SCALAR)->matches(true));
		$this->assertTrue((Type::SCALAR)->matches(false));
		$this->assertFalse((Type::SCALAR)->matches(new Exception()));
	}

	public function testString(): void
	{
		$this->assertTrue((Type::STRING)->matches('string'));
		$this->assertFalse((Type::STRING)->matches(new Exception()));
	}

	/**
	 * @dataProvider provideToStringData
	 */
	public function testToString(Type $type, string $expected): void
	{
		$this->assertSame($expected, $type->toString());
	}

	public function provideToStringData(): array
	{
		return [
			[Type::ARRAY, 'array'],
			[Type::BOOLEAN, 'boolean'],
			[Type::CALLABLE, 'callable'],
			[Type::CLOSED_RESOURCE, 'closed resource'],
			[Type::DOUBLE, 'double'],
			[Type::ENUM, 'enum'],
			[Type::FLOAT, 'float'],
			[Type::INTEGER, 'integer'],
			[Type::ITERABLE, 'iterable'],
			[Type::NULL, 'null'],
			[Type::NUMERIC, 'numeric'],
			[Type::OBJECT, 'object'],
			[Type::RESOURCE, 'resource'],
			[Type::SCALAR, 'scalar'],
			[Type::STRING, 'string']
		];
	}
}