// app/Logging/CreateCustomLogger.php

namespace App\Logging;

use Monolog\Logger;
use App\Logging\CustomDatabaseHandler;

class CreateCustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('database');
        return $logger->pushHandler(new CustomDatabaseHandler());
    }
}
