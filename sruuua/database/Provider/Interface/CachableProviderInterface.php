<?php

namespace Sruuua\Database\Provider\Interface;

interface CachableProviderInterface
{
    /**
     * Get all line in table
     *
     * @return object[] instance of query result
     */
    public function getAll();

    /**
     * Get one line by id
     *
     * @param int $id the id to search
     *
     * @return object[] instance of query result
     */
    public function getOne(int $id);

    /**
     *  Create a cache name
     *
     * @param ?int $id the id of item
     *
     * @return string the non-hash name
     */
    public function getCacheName(?int $id = null);

    /**
     * Check if the cache already exists
     */
    public function checkCache(string $name);
}
