<?php

namespace ErasmusHelper\Models;

use Kreait\Firebase\Auth\UserRecord;

class UniModerator extends StaffModel {

    const PRIVILEGE_LEVEL = UNIMODERATORS_PRIVILEGES;

    const CLAIMS = ["faculty_id"];

}