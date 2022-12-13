<?php

namespace Rklab\Crud\Http\Controllers\Generator;

class CrudGeneratorCollection
{
    /**
     * @var CrudGeneratorInterface[]
     */
    private array $generators;

    /**
     * @param CrudGeneratorInterface $generator
     *
     * @return $this
     */
    public function addGenerator(CrudGeneratorInterface $generator): self
    {
        $this->generators[] = $generator;

        return $this;
    }

    /**
     * @return CrudGeneratorInterface[]
     */
    public function getGenerators(): array
    {
        return $this->generators;
    }
}
