<?php
/**
 * 
 *
 * @author Justin Hendrickson <justin.hendrickson@gmail.com>
 * @package Doctrine2Dough\Dbal\Type\Money
 */

namespace Doctrine2Dough\Dbal\Type;

use \Doctrine\DBAL\Types\ConversionException;
use \Doctrine\DBAL\Types\DecimalType;
use \Doctrine\DBAL\Types\Type;
use \Doctrine\DBAL\Platforms\AbstractPlatform;
use \Dough\Money\Money;

/**
 * Money type for Doctrine DBAL
 *
 * @package Doctrine2Dough\Dbal\Type\Money
 */
class Money extends Type
{

    /**
     * Type name constant
     *
     * @var string
     */
    const MONEY = "money";

    /**
     * Get the SQL used to create the column
     *
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $fieldDeclaration["default"] = 0;
        $fieldDeclaration["precision"] = 8;
        $fieldDeclaration["scale"] = 2;

        return $platform->getDecimalTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * Convert the database value to a PHP value
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Money
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return new Money($value);
    }

    /**
     * Convert the PHP value to a database value
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value) {
            return null;
        }

        if (!$value instanceof Money) {
            throw new ConversionException("The value is not a money object.");
        }

        /* @var $value Money */
        return $value->getAmount();
    }

    /**
     * Get the name of the type
     *
     * @return string
     */
    public function getName()
    {
        return self::MONEY;
    }

}
