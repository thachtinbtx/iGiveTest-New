# ============================================================
# Script Backup Dự Án Lên GitHub
# ============================================================

$ErrorActionPreference = "Stop"

$branch = "main"
$remote = "origin"
$timestamp = Get-Date -Format 'yyyy-MM-dd HH:mm:ss'
$commitMessage = "Auto backup: $timestamp"

Write-Host "BACKUP DỰ ÁN LÊN GITHUB" -ForegroundColor Cyan

$status = git status --porcelain
if ([string]::IsNullOrWhiteSpace($status)) {
    Write-Host "Khong co thay doi nao." -ForegroundColor Green
    exit
}

try {
    Write-Host "Adding files..." -ForegroundColor Yellow
    git add .

    Write-Host "Committing..." -ForegroundColor Yellow
    git commit -m "$commitMessage"

    Write-Host "Pushing..." -ForegroundColor Yellow
    git push $remote $branch

    Write-Host "SUCCESS!" -ForegroundColor Green
} catch {
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}
