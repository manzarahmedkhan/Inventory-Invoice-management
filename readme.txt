ERROR:Temporary files directory "/var/www/html/mak/Inventory-Invoice-management/../temp//mpdf" is not writable
SOLUTION:in config/pdf.php Change 'tempDir' => base_path('../temp/') to 'tempDir' => storage_path('app/public/temp/'),
Give 777 permission to that folder.