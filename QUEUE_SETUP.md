# Configuración de Colas para Envío de Emails

## Problema Actual

Tienes `QUEUE_CONNECTION=sync` en tu `.env`, lo que significa que los jobs se ejecutan inmediatamente y NO se guardan en la base de datos. Por eso el cron no tiene nada que procesar.

## Solución

### 1. Cambiar la configuración de colas

En tu archivo `.env` de **producción**, cambia:

```env
QUEUE_CONNECTION=sync
```

Por:

```env
QUEUE_CONNECTION=database
```

### 2. Limpiar caché de configuración

Después de cambiar el `.env`, ejecuta:

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Ejecutar el Queue Worker

Tienes dos opciones:

#### Opción A: Ejecutar manualmente (para pruebas)

```bash
php artisan queue:work --tries=3 --timeout=120
```

#### Opción B: Configurar como servicio/cron (recomendado para producción)

**Para Linux con systemd**, crea un archivo `/etc/systemd/system/laravel-queue.service`:

```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /ruta/a/tu/proyecto/artisan queue:work --tries=3 --timeout=120 --sleep=3 --max-jobs=1000

[Install]
WantedBy=multi-user.target
```

Luego:
```bash
sudo systemctl enable laravel-queue
sudo systemctl start laravel-queue
sudo systemctl status laravel-queue
```

**O usando Supervisor** (recomendado):

Crea `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /ruta/a/tu/proyecto/artisan queue:work database --sleep=3 --tries=3 --timeout=120 --max-jobs=1000
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/ruta/a/tu/proyecto/storage/logs/worker.log
stopwaitsecs=3600
```

Luego:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

### 4. Verificar que funciona

1. Crea una nueva notificación desde el panel de admin
2. Verifica que se guarda en la tabla `jobs`:
   ```bash
   php artisan tinker
   DB::table('jobs')->count();
   ```
3. Verifica los logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

### 5. Comandos útiles

- Ver jobs pendientes: `php artisan queue:work --once` (ejecuta un job y sale)
- Ver jobs fallidos: `php artisan queue:failed`
- Reintentar jobs fallidos: `php artisan queue:retry all`
- Limpiar jobs fallidos: `php artisan queue:flush`

## Logging

He agregado logging extensivo al job `EnviarNotificacionEmail`. Ahora verás en `storage/logs/laravel.log`:

- `=== INICIANDO JOB EnviarNotificacionEmail ===` cuando el job comienza
- `Alerta encontrada: ...` cuando encuentra la alerta
- `Usuario encontrado: ...` cuando encuentra el usuario
- `Intentando enviar email a ...` antes de enviar
- `Email enviado exitosamente a ...` después de enviar
- `=== JOB COMPLETADO EXITOSAMENTE ===` cuando termina correctamente
- `=== ERROR EN JOB EnviarNotificacionEmail ===` si hay algún error

## Nota Importante

Si el log está vacío en producción, verifica:
1. Permisos del directorio `storage/logs/`: debe ser escribible por el usuario del servidor web
2. Que `LOG_CHANNEL=stack` o `LOG_CHANNEL=single` en el `.env`
3. Que `LOG_LEVEL=debug` para ver todos los logs

