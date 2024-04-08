<?php
/**
 * DplOpeningHoursListGET200ResponseInnerCategory
 *
 * PHP version 8.1.1
 *
 * @category Class
 * @package  DanskernesDigitaleBibliotek\CMS\Api\Model
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */

/**
 * DPL CMS - REST API
 *
 * The REST API provide by the core REST module.
 *
 * The version of the OpenAPI document: Versioning not supported
 * 
 * Generated by: https://github.com/openapitools/openapi-generator.git
 *
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */

namespace DanskernesDigitaleBibliotek\CMS\Api\Model;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class representing the DplOpeningHoursListGET200ResponseInnerCategory model.
 *
 * @package DanskernesDigitaleBibliotek\CMS\Api\Model
 * @author  OpenAPI Generator team
 */

class DplOpeningHoursListGET200ResponseInnerCategory 
{
        /**
     * @var string|null
     * @SerializedName("title")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected ?string $title = null;

    /**
     * A CSS compatible color code which can be used to represent the category
     *
     * @var string|null
     * @SerializedName("color")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected ?string $color = null;

    /**
     * Constructor
     * @param array|null $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        if (is_array($data)) {
            $this->title = array_key_exists('title', $data) ? $data['title'] : $this->title;
            $this->color = array_key_exists('color', $data) ? $data['color'] : $this->color;
        }
    }

    /**
     * Gets title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }



    /**
     * Sets title.
     *
     * @param string|null $title
     *
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets color.
     *
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }



    /**
     * Sets color.
     *
     * @param string|null $color  A CSS compatible color code which can be used to represent the category
     *
     * @return $this
     */
    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}

