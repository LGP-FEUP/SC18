<?php

namespace ErasmusHelper\Models;

use Kreait\Firebase\Auth\UserRecord;

class UniModerator extends StaffModel {

    const PRIVILEGE_LEVEL = 2;

    const CLAIMS = ["faculty_id"];

}