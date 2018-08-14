<?php

namespace Dittto\DoctrineEntityFactories\Doctrine\ORM\Mapping;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\ReflectionService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataFactory;

class ClassMetadataFactoryWithEntityFactories extends ClassMetadataFactory implements EntityFactoryAware
{
    /** @var EntityFactoryInterface[] */
    public static $entityFactories = [];
    /** @var GenericFactoryInterface|null */
    public static $genericFactory;

    /** @var EntityManagerInterface */
    private $em;

    public function setEntityManager(EntityManagerInterface $em)
    {
        parent::setEntityManager($em);
        $this->em = $em;
    }

    protected function newClassMetadataInstance($className): ClassMetadata
    {
        return new ClassMetadataWithEntityFactories(
            $className,
            $this->em->getConfiguration()->getNamingStrategy(),
            $this->getEntityFactories()
        );
    }

    public function addEntityFactory(string $name, EntityFactoryInterface $entityFactory): void
    {
        self::$entityFactories[$name] = $entityFactory;
    }

    public function addGenericFactory(GenericFactoryInterface $genericFactory): void
    {
        self::$genericFactory = $genericFactory;
    }

    /**
     * @return EntityFactoryInterface[]
     */
    public function getEntityFactories(): array
    {
        return self::$entityFactories;
    }

    public function wakeupReflection(ClassMetadata $class, ReflectionService $reflService)
    {
        parent::wakeupReflection($class, $reflService);
        if ($class instanceof ClassMetadataWithEntityFactories) {
            $class->setFactories(self::$entityFactories, self::$genericFactory);
        }
    }
}
