<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * * Csv dosya yüklemesinde şablonunu görüntülendiği fonksiyon
     */
    public function fileImport()
    {
        return view('file-import');
    }
    /**
     * * Csv dosya yükleme fonksiyonu
     */
    public function fileImportStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt' //yalnız mimes.csv uzantısı boşluk olduğundan başarısız oluyor yanında txt kullandığında kabul ediyor.
        ]);

        if ($validator->fails()) {
            //response
            $data['success'] = 0;
            $data['error'] = $validator->errors()->first('file');

        } else {

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); //dosya uzantısını alır
            Excel::import(new UserImport, $file); //import işlemi yapar
            // Response
            $data['success'] = 1;
            $data['message'] = 'Dosyanız başarıyla yüklendi';
            $data['extension'] = $extension;

        }
        return response()->json($data);

    }

}
