<?php

namespace App\DTO;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\XmlValue;
use Symfony\Component\Serializer\Annotation\SerializedName;

# Jms annotation
#[XmlRoot("foo")]
class Foo
{
    # Sf annotation
    #[SerializedName("@dummmy")]

    # Jms annotation
    #[Type("string")]
    #[XmlAttribute]
    public ?string $dummy = null;

    # Sf annotation
    #[SerializedName("#")]

    # Jms annotation
    #[Type("string")]
    #[XmlValue]
    public ?string $content = null;

}