<?php

// conexión a la base de datos
$host = getenv('DB_HOST') ?: 'db';
$db = getenv('DB_NAME') ?: 'inventario';
$user = getenv('DB_USER') ?: 'appuser';
$pass = getenv('DB_PASS') ?: 'apppassword';

$error = null;
$productos = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $stmt = $pdo->query("SELECT * FROM productos ORDER BY categoria, nombre");
    $productos = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error de conexión: " . $e->getMessage();
}

// Productos por Categoría
$categorias = [];
foreach ($productos as $p) {
    $categorias[$p['categoria']][] = $p;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario – Demo Docker</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; color: #2d3748; }

        header {
            background: linear-gradient(135deg, #2b6cb0, #2c5282);
            color: white; padding: 24px 40px;
            display: flex; align-items: center; gap: 16px;
        }
        header .logo { font-size: 2rem; }
        header h1 { font-size: 1.6rem; }
        header p  { font-size: 0.9rem; opacity: 0.85; margin-top: 4px; }

        .badge {
            display: inline-block; background: #48bb78; color: white;
            border-radius: 20px; padding: 4px 14px; font-size: 0.78rem;
            font-weight: 600; letter-spacing: 0.5px;
        }

        main { max-width: 1100px; margin: 32px auto; padding: 0 20px; }

        .info-bar {
            background: white; border-radius: 10px; padding: 14px 20px;
            margin-bottom: 28px; display: flex; gap: 24px; flex-wrap: wrap;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
            font-size: 0.88rem; color: #4a5568;
        }
        .info-bar span strong { color: #2b6cb0; }

        .error {
            background: #fff5f5; border: 1px solid #fc8181; color: #c53030;
            border-radius: 8px; padding: 16px 20px; margin-bottom: 24px;
        }

        h2 {
            font-size: 1.1rem; font-weight: 700; color: #2b6cb0;
            border-left: 4px solid #2b6cb0; padding-left: 10px;
            margin: 28px 0 12px;
        }

        table {
            width: 100%; border-collapse: collapse;
            background: white; border-radius: 10px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.08); margin-bottom: 12px;
        }
        thead { background: #2b6cb0; color: white; }
        th { padding: 12px 16px; text-align: left; font-size: 0.85rem; font-weight: 600; }
        td { padding: 11px 16px; font-size: 0.9rem; border-bottom: 1px solid #e2e8f0; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #ebf4ff; }

        .precio { font-weight: 700; color: #276749; }
        .stock-ok  { color: #276749; font-weight: 600; }
        .stock-low { color: #c05621; font-weight: 600; }

        footer {
            text-align: center; padding: 24px;
            font-size: 0.82rem; color: #718096;
        }
    </style>
</head>
<body>

<header>
    <div>
        <h1>Inventario de Productos &nbsp;<span class="badge">Demo Docker</span></h1>
    </div>
</header>

<main>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php else: ?>

    <div class="info-bar">
        <span>Host BD: <strong><?= htmlspecialchars($host) ?></strong></span>
        <span>Base de datos: <strong><?= htmlspecialchars($db) ?></strong></span>
        <span>Total productos: <strong><?= count($productos) ?></strong></span>
        <span>Consultado...: <strong><?= date('H:i:s') ?></strong></span>
    </div>

    <?php foreach ($categorias as $cat => $items): ?>
        <h2><?= htmlspecialchars($cat) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Precio (USD)</th>
                    <th>Stock</th>
                    <th>Registrado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td class="precio">$<?= number_format($p['precio'], 2) ?></td>
                    <td class="<?= $p['stock'] <= 10 ? 'stock-low' : 'stock-ok' ?>">
                        <?= $p['stock'] ?> unid.
                    </td>
                    <td><?= date('d/m/Y', strtotime($p['creado_en'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

    <?php endif; ?>
</main>

</body>
</html>
