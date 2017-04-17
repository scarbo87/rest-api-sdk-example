<?php

namespace scarbo87\RestApiSdk\Operator\V1;

use scarbo87\RestApiSdk\Client;
use scarbo87\RestApiSdk\Domain\V1\Post;
use scarbo87\RestApiSdk\Mapper\Mapper;
use scarbo87\RestApiSdk\Context;
use scarbo87\RestApiSdk as f;

class PostOperator
{
    /** @var Client */
    protected $client;
    /** @var Mapper */
    protected $mapper;

    public function __construct(Client $client, Mapper $mapper)
    {
        $this->client = $client;
        $this->mapper = $mapper;
    }

    /**
     * @param Post         $post
     * @param Context|null $context
     *
     * @return Post
     */
    public function create(Post $post, Context $context = null)
    {
        if (null === $context) {
            $context = Context::params();
        }

        $rawPost = $this->mapper->snapshot($post);
        $response = $this->client->post("/posts", null, $rawPost, $context);
        $json = f\json_decode((string) $response->getBody());

        /** @var Post $post */
        $post = $this->mapper->hydrateNew(Post::class, $json);
        return $post;
    }

    /**
     * @param  int         $id
     * @param Context|null $context
     *
     * @return Post
     */
    public function find($id, Context $context = null)
    {
        if (null === $context) {
            $context = Context::params();
        }

        $response = $this->client->get(sprintf('/posts/%d', $id), null, $context);
        $json = f\json_decode((string) $response->getBody());

        /** @var Post $post */
        $post = $this->mapper->hydrateNew(Post::class, $json);
        return $post;
    }

    /**
     * @param Context|null $context
     *
     * @return Post[]
     */
    public function findAll(Context $context = null)
    {
        if (null === $context) {
            $context = Context::params();
        }

        $response = $this->client->get("/posts", null, $context);
        $json = f\json_decode((string) $response->getBody());

        $objects = array_map(
            function ($json) {
                return $this->mapper->hydrateNew(Post::class, $json);
            },
            $json
        );

        return $objects;
    }
}