# ============================================================
# Script Backup Dự Án IgiveTest
# ============================================================
# Tự động backup mã nguồn, loại trừ các thư mục build/dependencies
# Cách dùng: Chạy script này trong PowerShell

param(
    [switch]$PhpOnly,      # Chỉ backup dự án PHP (textbtx2025)
    [switch]$NextOnly,     # Chỉ backup dự án Next.js (next-app)
    [switch]$SkipZip       # Không nén, chỉ copy files
)

# ============================================================
# CẤU HÌNH
# ============================================================
$projectPath = "C:\laragon\www"
$timestamp = Get-Date -Format 'yyyy-MM-dd_HHmmss'
$backupBasePath = "D:\OneDrive - THPT Bui Thi Xuan\C3DRIVE\IgiveTest\Backup"

# Các thư mục/file cần loại trừ
$excludeFolders = @(
    "node_modules",
    ".next",
    ".git",
    "vendor",
    ".nuxt",
    "dist",
    "build",
    ".cache",
    ".temp",
    ".tmp",
    "coverage",
    ".vscode"
)

$excludeFiles = @(
    "*.log",
    "*.tmp",
    ".DS_Store",
    "Thumbs.db",
    "*.swp",
    "checksums.md5"
)

# ============================================================
# HIỂN THỊ THÔNG TIN
# ============================================================
Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║         BACKUP DỰ ÁN IGIVETEST - TEXTBTX2025            ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

Write-Host "📂 Thư mục nguồn: " -ForegroundColor Yellow -NoNewline
Write-Host $projectPath -ForegroundColor White
Write-Host "💾 Thư mục đích:  " -ForegroundColor Yellow -NoNewline
Write-Host $backupBasePath -ForegroundColor White
Write-Host "⏰ Thời gian:     " -ForegroundColor Yellow -NoNewline
Write-Host $timestamp -ForegroundColor White

# ============================================================
# TẠO THƯ MỤC BACKUP
# ============================================================
if (!(Test-Path $backupBasePath)) {
    Write-Host "`n⚠️  Tạo thư mục backup..." -ForegroundColor Yellow
    New-Item -ItemType Directory -Path $backupBasePath -Force | Out-Null
    Write-Host "✓ Đã tạo thư mục backup" -ForegroundColor Green
}

# ============================================================
# XÁC ĐỊNH DỰ ÁN CẦN BACKUP
# ============================================================
$projectsToBackup = @()

if ($PhpOnly) {
    $projectsToBackup += @{Name = "textbtx2025"; Path = "textbtx2025"}
    Write-Host "`n📦 Chế độ: " -ForegroundColor Yellow -NoNewline
    Write-Host "Chỉ backup dự án PHP" -ForegroundColor Magenta
} elseif ($NextOnly) {
    $projectsToBackup += @{Name = "next-app"; Path = "next-app"}
    Write-Host "`n📦 Chế độ: " -ForegroundColor Yellow -NoNewline
    Write-Host "Chỉ backup dự án Next.js" -ForegroundColor Magenta
} else {
    # Backup toàn bộ với cấu trúc phân tách
    $projectsToBackup += @{Name = "full"; Path = "."}
    Write-Host "`n📦 Chế độ: " -ForegroundColor Yellow -NoNewline
    Write-Host "Backup toàn bộ dự án" -ForegroundColor Magenta
}

# ============================================================
# HÀM LỌC FILES
# ============================================================
function Test-ShouldExclude {
    param($ItemPath)
    
    foreach ($exclude in $excludeFolders) {
        if ($ItemPath -like "*\$exclude\*" -or $ItemPath -split '\\' -contains $exclude) {
            return $true
        }
    }
    
    foreach ($pattern in $excludeFiles) {
        if ($ItemPath -like $pattern) {
            return $true
        }
    }
    
    return $false
}

# ============================================================
# THỰC HIỆN BACKUP
# ============================================================
Write-Host "`n" + "="*60 -ForegroundColor DarkGray
Write-Host "BẮT ĐẦU BACKUP..." -ForegroundColor Green
Write-Host "="*60 -ForegroundColor DarkGray

$totalFiles = 0
$totalSize = 0
$excludedCount = 0

foreach ($project in $projectsToBackup) {
    $sourcePath = Join-Path $projectPath $project.Path
    
    if ($SkipZip) {
        # Copy trực tiếp không nén
        $destPath = Join-Path $backupBasePath "$($project.Name)_$timestamp"
        Write-Host "`n📁 Đang copy dự án: $($project.Name)..." -ForegroundColor Cyan
        
        $items = Get-ChildItem -Path $sourcePath -Recurse -File
        $filteredItems = $items | Where-Object { -not (Test-ShouldExclude $_.FullName) }
        
        foreach ($item in $filteredItems) {
            $relativePath = $item.FullName.Substring($sourcePath.Length + 1)
            $destFile = Join-Path $destPath $relativePath
            $destDir = Split-Path $destFile -Parent
            
            if (!(Test-Path $destDir)) {
                New-Item -ItemType Directory -Path $destDir -Force | Out-Null
            }
            
            Copy-Item $item.FullName -Destination $destFile -Force
            $totalFiles++
            $totalSize += $item.Length
        }
        
        $excludedCount += ($items.Count - $filteredItems.Count)
        
    } else {
        # Tạo file ZIP
        $zipPath = Join-Path $backupBasePath "$($project.Name)_$timestamp.zip"
        Write-Host "`n📦 Đang nén dự án: $($project.Name)..." -ForegroundColor Cyan
        
        # Tạo temp folder
        $tempFolder = Join-Path $env:TEMP "backup_temp_$timestamp"
        New-Item -ItemType Directory -Path $tempFolder -Force | Out-Null
        
        # Copy files đã lọc vào temp
        $items = Get-ChildItem -Path $sourcePath -Recurse -File
        $filteredItems = $items | Where-Object { -not (Test-ShouldExclude $_.FullName) }
        
        foreach ($item in $filteredItems) {
            $relativePath = $item.FullName.Substring($sourcePath.Length + 1)
            $tempFile = Join-Path $tempFolder $relativePath
            $tempDir = Split-Path $tempFile -Parent
            
            if (!(Test-Path $tempDir)) {
                New-Item -ItemType Directory -Path $tempDir -Force | Out-Null
            }
            
            Copy-Item $item.FullName -Destination $tempFile -Force
            $totalFiles++
            $totalSize += $item.Length
            
            # Hiển thị tiến độ
            if ($totalFiles % 100 -eq 0) {
                Write-Host "." -NoNewline -ForegroundColor Gray
            }
        }
        
        Write-Host ""
        $excludedCount += ($items.Count - $filteredItems.Count)
        
        # Nén từ temp folder
        Write-Host "🗜️  Đang nén file..." -ForegroundColor Yellow
        Compress-Archive -Path "$tempFolder\*" -DestinationPath $zipPath -CompressionLevel Optimal -Force
        
        # Xóa temp folder
        Remove-Item $tempFolder -Recurse -Force
        
        $backupFileSize = (Get-Item $zipPath).Length / 1MB
        Write-Host "✓ Đã tạo: " -ForegroundColor Green -NoNewline
        Write-Host "$zipPath" -ForegroundColor White
        Write-Host "  Dung lượng nén: " -ForegroundColor Gray -NoNewline
        Write-Host "$([math]::Round($backupFileSize, 2)) MB" -ForegroundColor Cyan
    }
}

# ============================================================
# THỐNG KÊ
# ============================================================
Write-Host "`n" + "="*60 -ForegroundColor DarkGray
Write-Host "✅ BACKUP HOÀN TẤT!" -ForegroundColor Green -BackgroundColor DarkGreen
Write-Host "="*60 -ForegroundColor DarkGray

Write-Host "`n📊 THỐNG KÊ:" -ForegroundColor Yellow
Write-Host "   ├─ Tổng files đã backup:  " -ForegroundColor Gray -NoNewline
Write-Host $totalFiles -ForegroundColor Cyan
Write-Host "   ├─ Files đã loại trừ:     " -ForegroundColor Gray -NoNewline
Write-Host $excludedCount -ForegroundColor Yellow
Write-Host "   └─ Tổng dung lượng:       " -ForegroundColor Gray -NoNewline
Write-Host "$([math]::Round($totalSize / 1MB, 2)) MB" -ForegroundColor Cyan

Write-Host "`n📁 Thư mục backup:" -ForegroundColor Yellow
Write-Host "   $backupBasePath" -ForegroundColor White

Write-Host "`n🚫 Đã loại trừ:" -ForegroundColor Yellow
$excludeFolders | ForEach-Object { Write-Host "   • $_" -ForegroundColor DarkGray }

Write-Host "`n"
