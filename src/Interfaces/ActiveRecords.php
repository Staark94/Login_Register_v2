<?php
namespace Staark\Support\Interfaces;

use PDO;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Interfaces ActiveRecords
 * Author: Costin Ionut
 * Github: Staark94
 */

interface ActiveRecords
{
    public function save();
    public function insert();
    public function delete();
    public function update();

    public static function findOrFail(int $id = -1);
    public static function findById(int $id = -1);

    public function setConnection(array $config = []): ?PDO;
    public function setEmailServer(array $config = []): ?PHPMailer;
}