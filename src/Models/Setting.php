<?php

namespace app\Models;

use app\Entities\SettingEntity;

class Setting extends Model{

    protected $Filename = "setting";
    protected $EntityClass = SettingEntity::class;

}