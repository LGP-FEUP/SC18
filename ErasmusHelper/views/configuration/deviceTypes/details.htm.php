<?php
/** @var DeviceType $deviceType */

$substances = $deviceType->getLinkedSubstances();
$resources = $deviceType->getLinkedResources();

use ErasmusHelper\Models\DeviceType;
?>

<div class="row">
    <?php include APPLICATION_PATH . "/views/configuration/substances/list.htm.php"; ?>
</div>
<div class="row">
    <?php include APPLICATION_PATH . "/views/configuration/resources/list.htm.php"; ?>
</div>
