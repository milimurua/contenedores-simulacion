# Demo Docker – Dos Contenedores Comunicados

## Estructura
```
docker-demo/
├── docker-compose.yml          ← Orquestación de los 3 servicios
├── db/
│   └── init.sql                ← Script SQL inicial (tablas + datos)
└── web/
    ├── nginx.conf              ← Configuración del servidor web
    ├── Dockerfile 
    └── src/
        └── index.php           ← Página PHP que consulta la BD
```

## Cómo levantar el entorno

```bash
# Desde la carpeta docker-demo/
docker compose up -d

# Ver logs en tiempo real
docker compose logs -f

# Detener y eliminar contenedores
docker compose down
```

## Acceso
Abrí el navegador en: http://localhost:8080

## Arquitectura
- **contenedor1-db** → MySQL 8.0 (red interna, no expuesto al exterior)
- **contenedor2-web** → PHP 8.2-FPM (conecta a la BD por nombre de host)
- **nginx-proxy** → Nginx Alpine, puerto 8080:80 (accesible desde el anfitrión)
