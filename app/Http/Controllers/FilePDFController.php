<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class FilePDFController extends Controller
{
    public function process(Request $request)  
    {
        $nama = $request->post('nama'); // request name 
        $outputfile = public_path().'dcc.pdf'; // menyimpan output file
        $this->fillPDF(public_path().'/master/dcc.pdf', $outputfile, $nama);

        return response()->file($outputfile);
    }

    public function fillPDF($file, $outputfile, $nama) 
    {
        $fpdi = new FPDI;
        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'],array($size['width'],$size['height']));
        $fpdi->useTemplate($template); // kita use templatenya 
        $top = 85; // sesuaikan top
        $right = 75; // sesuaikan right
        $name= $nama; // panggil nama 
        $fpdi->SetFont("helvetica", "", 17);  // kita set fontnya
        $fpdi->SetTextColor(25,26,25); // kita kasih warna colornya hitam pakai rgba
        $fpdi->Text($right,$top,$name);

        return $fpdi->Output($outputfile, 'F');
    }
}
