<?php
namespace Dittto\DoctrineEntityFactories\Doctrine\ORM\Mapping;

interface GenericFactoryInterface
{
    public function getEntity(string $className);
}