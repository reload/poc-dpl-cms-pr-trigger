<?php
/**
 * DplOpeningHoursCreatePOSTRequest
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
 * Class representing the DplOpeningHoursCreatePOSTRequest model.
 *
 * @package DanskernesDigitaleBibliotek\CMS\Api\Model
 * @author  OpenAPI Generator team
 */

class DplOpeningHoursCreatePOSTRequest 
{
        /**
     * An serial unique id of the opening hours instance.
     *
     * @var int|null
     * @SerializedName("id")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected ?int $id = null;

    /**
     * @var DplOpeningHoursListGET200ResponseInnerCategory|null
     * @SerializedName("category")
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Assert\Type("DanskernesDigitaleBibliotek\CMS\Api\Model\DplOpeningHoursListGET200ResponseInnerCategory")
     * @Type("DanskernesDigitaleBibliotek\CMS\Api\Model\DplOpeningHoursListGET200ResponseInnerCategory")
     */
    protected ?DplOpeningHoursListGET200ResponseInnerCategory $category = null;

    /**
     * The date which the opening hours applies to. In ISO 8601 format.
     *
     * @var \DateTime|null
     * @SerializedName("date")
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Assert\Type("\Date")
     * @Type("DateTime<'Y-m-d'>")
     */
    protected ?\DateTime $date = null;

    /**
     * When the opening hours start. In format HH:MM
     *
     * @var string|null
     * @SerializedName("start_time")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected ?string $startTime = null;

    /**
     * When the opening hours end. In format HH:MM
     *
     * @var string|null
     * @SerializedName("end_time")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected ?string $endTime = null;

    /**
     * The id for the branch the instance belongs to
     *
     * @var int|null
     * @SerializedName("branch_id")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected ?int $branchId = null;

    /**
     * Constructor
     * @param array|null $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        if (is_array($data)) {
            $this->id = array_key_exists('id', $data) ? $data['id'] : $this->id;
            $this->category = array_key_exists('category', $data) ? $data['category'] : $this->category;
            $this->date = array_key_exists('date', $data) ? $data['date'] : $this->date;
            $this->startTime = array_key_exists('startTime', $data) ? $data['startTime'] : $this->startTime;
            $this->endTime = array_key_exists('endTime', $data) ? $data['endTime'] : $this->endTime;
            $this->branchId = array_key_exists('branchId', $data) ? $data['branchId'] : $this->branchId;
        }
    }

    /**
     * Gets id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }



    /**
     * Sets id.
     *
     * @param int|null $id  An serial unique id of the opening hours instance.
     *
     * @return $this
     */
    public function setId(?int $id = null): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets category.
     *
     * @return DplOpeningHoursListGET200ResponseInnerCategory|null
     */
    public function getCategory(): ?DplOpeningHoursListGET200ResponseInnerCategory
    {
        return $this->category;
    }



    /**
     * Sets category.
     *
     * @param DplOpeningHoursListGET200ResponseInnerCategory|null $category
     *
     * @return $this
     */
    public function setCategory(?DplOpeningHoursListGET200ResponseInnerCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Gets date.
     *
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }



    /**
     * Sets date.
     *
     * @param \DateTime|null $date  The date which the opening hours applies to. In ISO 8601 format.
     *
     * @return $this
     */
    public function setDate(?\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Gets startTime.
     *
     * @return string|null
     */
    public function getStartTime(): ?string
    {
        return $this->startTime;
    }



    /**
     * Sets startTime.
     *
     * @param string|null $startTime  When the opening hours start. In format HH:MM
     *
     * @return $this
     */
    public function setStartTime(?string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Gets endTime.
     *
     * @return string|null
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }



    /**
     * Sets endTime.
     *
     * @param string|null $endTime  When the opening hours end. In format HH:MM
     *
     * @return $this
     */
    public function setEndTime(?string $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Gets branchId.
     *
     * @return int|null
     */
    public function getBranchId(): ?int
    {
        return $this->branchId;
    }



    /**
     * Sets branchId.
     *
     * @param int|null $branchId  The id for the branch the instance belongs to
     *
     * @return $this
     */
    public function setBranchId(?int $branchId): self
    {
        $this->branchId = $branchId;

        return $this;
    }
}


