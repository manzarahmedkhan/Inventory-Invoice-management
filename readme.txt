ERROR:Mpdf\MpdfException Temporary files directory  is not writable laravel
SOLUTION:in config/pdf.php Change 'tempDir' => base_path('../temp/') to 'tempDir' => storage_path('app/public/temp/'),
Give 777 permission to that folder.