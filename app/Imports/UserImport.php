<?php

namespace App\Imports;

use App\Models\User;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToModel,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /**
     * * Modelden gelen verilerin dosyasa hangi kolondan geleceğini belirler.Eğer dosyasa name,surname başlıklar varsa
     *  WithHeadingRow concerni implement edip burayı 'name'=> $row['name'] şeklinde kullanılabilir.Dosya biçimine göre değiştirilebilir.
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row[0],
            'surname'     => $row[1],
            'email'    => $row[2],
            'phone'    => $row[3],
            'points'    => $row[4],
            'employee_id'    => $row[5],
        ]);

    }
    /**
     * * istek için geçerli olan validation kurallarını döndürür
     */
    public function rules(): array
    {
        return [
            '2' => ['required', 'email', 'unique:users,email'],
            '3' => ['required', 'numeric', 'digits:10', 'unique:users,phone'],
            '4'=>['nullable','numeric'],
            '5' => ['required', 'unique:users,employee_id'],

        ];
    }
}
