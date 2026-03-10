@echo off
C:\php.exe -d extension_dir=C:\ext -d extension=pdo_pgsql -d extension=pgsql -d extension=mbstring %*
