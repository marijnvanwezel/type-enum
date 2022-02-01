<?php declare(strict_types=1);
/*
 * This file is part of marijnvanwezel/type-enum.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MarijnVanWezel\TypeEnum;

use UnitEnum;

/**
 * This enum provides a set of values that represent each native data type in PHP.
 */
enum Type
{
	case ARRAY;
	case BOOLEAN;
	case CALLABLE;
	case CLOSED_RESOURCE;
	case DOUBLE;
	case ENUM;
	case FLOAT;
	case INTEGER;
	case ITERABLE;
	case NULL;
	case NUMERIC;
	case OBJECT;
	case RESOURCE;
	case SCALAR;
	case STRING;

	/**
	 * Returns true if and only if $value matches this type.
	 *
	 * @param mixed $value The value to check.
	 * @return bool True if the type matches, false otherwise.
	 */
	public function matches(mixed $value): bool
	{
		return match($this) {
			Type::ARRAY => is_array($value),
			Type::BOOLEAN => is_bool($value),
			Type::CALLABLE => is_callable($value),
			Type::CLOSED_RESOURCE => gettype($value) === 'resource (closed)',
			Type::DOUBLE => is_double($value),
			Type::ENUM => $value instanceof UnitEnum,
			Type::FLOAT => is_float($value),
			Type::INTEGER => is_int($value),
			Type::ITERABLE => is_iterable($value),
			Type::NULL => is_null($value),
			Type::NUMERIC => is_numeric($value),
			Type::OBJECT => is_object($value),
			Type::RESOURCE => gettype($value) === 'resource' || gettype($value) === 'resource (closed)',
			Type::SCALAR => is_scalar($value),
			Type::STRING => is_string($value)
		};
	}

	/**
	 * Returns the string representation of this type.
	 *
	 * @return string
	 */
	public function toString(): string
	{
		return match($this) {
			Type::ARRAY => 'array',
			Type::BOOLEAN => 'boolean',
			Type::CALLABLE => 'callable',
			Type::CLOSED_RESOURCE => 'closed resource',
			Type::DOUBLE => 'double',
			Type::ENUM => 'enum',
			Type::FLOAT => 'float',
			Type::INTEGER => 'integer',
			Type::ITERABLE => 'iterable',
			Type::NULL => 'null',
			Type::NUMERIC => 'numeric',
			Type::OBJECT => 'object',
			Type::RESOURCE => 'resource',
			Type::SCALAR => 'scalar',
			Type::STRING => 'string'
		};
	}
}