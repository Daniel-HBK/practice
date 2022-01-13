<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'name', 'phone',
    ];

    protected $appends = [
        'country', 'state', 'country_code', 'phone_num',
    ];


    public function getStateAttribute() {
        $patterns = "/\(212\)\ ?[5-9]\d{8}$|\(258\)\ ?[28]\d{7,8}$|= \(256\)\ ?\d{9}$|\(251\)\ ?[1-59]\d{8}$|\(237\)\ ?[2368]\d{7,8}$/";
        return preg_match($patterns, $this->phone) == true ? 'OK' : 'NOK';
    }

    public function getCountryAttribute() {
        switch ($this->phone) {
            case preg_match("/\(212\)/", $this->phone) == true;
              return "Morocco";
              break;
            case preg_match("/\(258\)/", $this->phone) == true;
              return "Mozambique";
              break;
            case preg_match("/\(256\)/", $this->phone) == true;
              return "Uganda";
              break;
            case preg_match("/\(251\)/", $this->phone) == true;
              return "Ethiopia";
              break;
            case preg_match("/\(237\)/", $this->phone) == true;
              return "Cameroon";
              break;
            default:
              return "-";
          }
    }

    public function getCountryCodeAttribute() {
        preg_match("/\((.*?)\)/", $this->phone, $match);
        return "+" . $match[1];
    }

    public function getPhoneNumAttribute() {
        return substr($this->phone, strpos($this->phone, ") ") + 1);
    }

}
