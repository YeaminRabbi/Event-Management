<?php

namespace App\Models;

use App\Traits\ContentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $casts = [
        'phone' => 'string'
    ];

    protected static function getTypes()
    {
        return [
            1 => 'Registration',
            2 => 'Reset Password',
            3 => 'Data Collection Form',
            4 => 'Online Admission Form',
        ];
    }


    protected $table = 'otp';

    protected $guarded = [];

    const CREATED_AT = null;

    protected $primaryKey = 'phone';

    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = $value;

        $this->attributes['count'] = (int) $this->count + 1;
    }

    /**
     * @param $phone
     * @param $event int accepted numbers 1,2,3,4 or null<br><br>
     * 1 => 'Registration',<br>
     * 2 => 'Reset Password',<br>
     * 3 => 'Data Collection Form',<br>
     * 4 => 'Online Admission Form',<br>
     * @return int
     */
    // public static function saveAndGet( $phone, int $event_type_id = null ){
    //     $code = rand(1111, 9999);

    //     self::updateOrCreate(
    //         [
    //             'phone' => $phone
    //         ],
    //         [
    //             'code'  => $code,
    //             'event_type_id' => $event_type_id
    //         ]
    //     );
    //     return $code;
    // }

    protected function getTypeColumn()
    {
        return 'event_type_id';
    }


}
