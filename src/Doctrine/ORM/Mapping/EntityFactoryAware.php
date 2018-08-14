<?php
namespace Dittto\DoctrineEntityFactories\Doctrine\ORM\Mapping;

interface EntityFactoryAware
{
    public function addEntityFactory(string $name, EntityFactoryInterface $entityFactory): void;

    public function addGenericFactory(GenericFactoryInterface $genericFactory): void;
}