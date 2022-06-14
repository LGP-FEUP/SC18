<?php

namespace ErasmusHelper\Models;

class CityModerator extends StaffModel {

    const PRIVILEGE_LEVEL = CITYMODERATORS_PRIVILEGES;

    const CLAIMS = ["city_id"];
}