<?php

namespace scarbo87\RestApiSdk\Domain\V1;

use scarbo87\RestApiSdk\Mapper\Annotation\Field;

class Post
{
    /**
     * @var int
     * @Field(type="int")
     */
    protected $id;
    /**
     * @var int
     * @Field(type="int")
     */
    protected $userId;
    /**
     * @var string
     * @Field(type="string")
     */
    protected $title;
    /**
     * @var string
     * @Field(type="string")
     */
    protected $body;

    /**
     * @param int    $userId
     * @param string $title
     * @param string $body
     */
    public function __construct($userId, $title, $body)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}