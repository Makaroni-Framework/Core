<?php

namespace Makaroni\Core\Database\Migration;

use Alirezasalehizadeh\QuickMigration\Migration as QuickMigration;
use Makaroni\Core\App;

class Migration extends QuickMigration
{
    public function __construct()
    {
        parent::__construct(App::getInstance()->get('connection'));
        $this->database = App::getInstance()->get('config')['database']['name'];
    }
}
