<?php

namespace ErasmusHelper\Models;

class CountryModerator extends StaffModel {

    const PRIVILEGE_LEVEL = COUNTRYMODERATORS_PRIVILEGES;

    const CLAIMS = ["country_id"];
}