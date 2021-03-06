<?php

namespace Derp\Bundle\ERBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Sex
{
    const MALE = 'male';

    const FEMALE = 'female';

    const INTERSEX = 'intersex';

    /**
     * @ORM\Column(name="sex", type="string", length=10)
     */
    private $value;

    public function __construct($sex)
    {
        $this->setSex($sex);
    }

    /**
     * compromise
     */
    private function setSex($sex)
    {
        if ($sex !== static::MALE && $sex !== static::FEMALE && $sex !== static::INTERSEX) {
            throw new \InvalidArgumentException('Invalid sex provided');
        }

        $this->value = $sex;
    }

    public function getSex()
    {
        return $this->value;
    }
}
