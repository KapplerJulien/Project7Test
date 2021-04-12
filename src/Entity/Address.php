<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

/** 
* @Serializer\ExclusionPolicy("all") 
*/
class Address
{
    /**     
    * @Serializer\Expose()     
    * @Serializer\Type("string")
    *     
    * @var string|null     
    */
    private $name;

    /**     
    * @Serializer\Expose()     
    * @Serializer\Type("string")     
    * @Serializer\SerializedName("line1")
    * @var string|null
    */
    private $lineOne;

    /**     
    * @Serializer\Expose()     
    * @Serializer\Type("string")     
    * @Serializer\SerializedName("line2")
    * @var string|null
    */
    private $lineTwo;

    /**     
    * @Serializer\Expose()     
    * @Serializer\Type("string")     
    * @Serializer\SerializedName("line3")
    * @var string|null
    */
    private $lineThree;

    /**     
    * @Serializer\Expose()     
    * @Serializer\Type("string")     
    * @Serializer\SerializedName("city")
    * @var string|null
    */
    private $city;

    /**     
    * @Serializer\Expose()     
    * @Serializer\Type("string")     
    * @Serializer\SerializedName("postcode")
    * @var string|null
    */
    private $postcode;

    /**     
    * @Serializer\Expose()     
    * @Serializer\Type("string")     
    * @Serializer\SerializedName("country")
    * @var string|null
    */
    private $country;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLineOne(): ?string
    {
        return $this->lineOne;
    }

    public function getLineTwo(): ?string
    {
        return $this->lineTwo;
    }

    public function getLineThree(): ?string
    {
        return $this->lineThree;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }
    
}

?>