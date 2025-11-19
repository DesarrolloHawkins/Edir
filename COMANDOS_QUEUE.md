# Comandos para Procesar Notificaciones (Queue Worker)

## Comando Principal

Para procesar los jobs de envío de emails, usa:

```bash
php artisan queue:work
```

## Opciones Recomendadas

### Para Producción (ejecución continua):

```bash
php artisan queue:work database --tries=3 --timeout=120 --sleep=3 --max-jobs=1000
```

**Parámetros:**
- `database`: Especifica que use la conexión de base de datos
- `--tries=3`: Reintenta hasta 3 veces si falla
- `--timeout=120`: Timeout de 2 minutos por job
- `--sleep=3`: Espera 3 segundos entre jobs cuando no hay trabajo
- `--max-jobs=1000`: Reinicia el worker después de 1000 jobs (previene memory leaks)

### Para Pruebas (ejecuta un job y sale):

```bash
php artisan queue:work --once
```

Útil para probar si hay jobs pendientes y procesarlos uno por uno.

## Verificar Jobs Pendientes

### Ver cuántos jobs hay en cola:

```bash
php artisan tinker
```

Luego ejecuta:
```php
DB::table('jobs')->count();
```

### Ver detalles de jobs pendientes:

```php
DB::table('jobs')->get();
```

## Ver Jobs Fallidos

```bash
php artisan queue:failed
```

## Reintentar Jobs Fallidos

```bash
# Reintentar todos los jobs fallidos
php artisan queue:retry all

# Reintentar un job específico
php artisan queue:retry {id}
```

## Limpiar Jobs Fallidos

```bash
php artisan queue:flush
```

## Monitorear en Tiempo Real

### Ver logs mientras se procesan jobs:

```bash
tail -f storage/logs/laravel-$(date +%Y-%m-%d).log
```

O si usas el canal `stack` o `single`:

```bash
tail -f storage/logs/laravel.log
```

## Configurar Ejecución Automática

### Opción 1: Usando Plesk (Tareas Programadas)

En Plesk, ve a **Tareas Programadas** y crea una nueva tarea:

**Comando:**
```bash
cd /ruta/a/tu/proyecto && php artisan queue:work --once --tries=3 --timeout=120
```

**Frecuencia:** Cada minuto (`* * * * *`)

**Nota:** Esto ejecutará un job cada minuto. Para procesar múltiples jobs, ejecuta el worker en modo continuo (ver Opción 2).

### Opción 2: Worker Continuo (Recomendado)

Para que el worker esté siempre ejecutándose, necesitas configurarlo como servicio. En Plesk puedes usar **Supervisor** o configurarlo manualmente.

**Comando para ejecutar en background:**
```bash
nohup php artisan queue:work database --tries=3 --timeout=120 --sleep=3 --max-jobs=1000 > /dev/null 2>&1 &
```

**Verificar que está corriendo:**
```bash
ps aux | grep "queue:work"
```

**Detener el worker:**
```bash
pkill -f "queue:work"
```

## Flujo Completo

1. **Crear notificación** → Se guarda en la tabla `jobs`
2. **Ejecutar worker** → `php artisan queue:work`
3. **Worker procesa jobs** → Ejecuta `EnviarNotificacionEmail::handle()`
4. **Logs se escriben** → En `storage/logs/laravel-YYYY-MM-DD.log`
5. **Email se envía** → A través de SMTP configurado

## Verificar que Funciona

1. Crea una notificación desde el panel admin
2. Verifica que hay jobs pendientes:
   ```bash
   php artisan tinker
   DB::table('jobs')->count();
   ```
3. Ejecuta el worker:
   ```bash
   php artisan queue:work --once
   ```
4. Verifica los logs:
   ```bash
   tail -n 20 storage/logs/laravel-$(date +%Y-%m-%d).log
   ```
5. Deberías ver:
   - `=== INICIANDO JOB EnviarNotificacionEmail ===`
   - `Alerta encontrada: ...`
   - `Usuario encontrado: ...`
   - `Email enviado exitosamente a ...`
   - `=== JOB COMPLETADO EXITOSAMENTE ===`

