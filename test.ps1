$backupBasePath = "D:\OneDrive - THPT Bui Thi Xuan\C3DRIVE\IgiveTest\Backup"
if (!(Test-Path $backupBasePath)) {
    Write-Host "Creating backup directory..."
    New-Item -ItemType Directory -Path $backupBasePath -Force | Out-Null
    Write-Host "Done."
}
Write-Host "Test complete."
