<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Model;

use Hyperf\Database\Model\Concerns\HasUlids;
use Hyperf\Database\Model\Events\Creating;
use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\Stringable\Str;

abstract class Model extends BaseModel
{
    use HasUlids;

    public bool $incrementing = false;

    protected string $primaryKey = 'id';

    protected string $keyType = 'string';

    public function creating(Creating $event)
    {
        if (empty($this->getAttribute($this->getKeyName()))) {
            $this->setAttribute($this->getKeyName(), Str::ulid());
        }

        // Ensure the ID is always a string
        $this->setAttribute($this->getKeyName(), (string) $this->getAttribute($this->getKeyName()));
    }
}
