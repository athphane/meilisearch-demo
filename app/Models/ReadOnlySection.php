<?php

namespace App\Models;

use Exception;

class ReadOnlySection extends Section
{
    /**
     * @throws Exception
     */
    public function save(array $options = [])
    {
        throw new \Exception('Cannot create or update read-only model');
    }

    /**
     * @throws Exception
     */
    public function update(array $attributes = [], array $options = [])
    {
        throw new \Exception('Cannot update read-only model');
    }

    /**
     * @throws Exception
     */
    public function delete()
    {
        throw new \Exception('Cannot delete read-only model');
    }
}
