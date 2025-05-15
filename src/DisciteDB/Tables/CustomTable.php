<?php

namespace DisciteDB\Tables;

use DisciteDB\Operators\All;
use DisciteDB\Operators\Compare;
use DisciteDB\Operators\Count;
use DisciteDB\Operators\Create;
use DisciteDB\Operators\Delete;
use DisciteDB\Operators\Keys;
use DisciteDB\Operators\Listing;
use DisciteDB\Operators\Retrieve;
use DisciteDB\Operators\Update;

/**
 * Récupère dynamiquement une table de la base.
 *
 * @method all \DisciteDB\Operators\All
 */
final class CustomTable extends BaseTable implements TableInterface
{
    use All;
    use Compare;
    use Count;
    use Create;
    use Delete;
    use Keys;
    use Listing;
    use Retrieve;
    use Update;
}

?>