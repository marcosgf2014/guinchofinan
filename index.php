<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Guincho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-title">Guincho</div>
        <nav>
            <a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="clientes/index.php"><i class="fas fa-users"></i> Clientes</a>
            <a href="veiculos/index.php"><i class="fas fa-car"></i> Veículos</a>
            <a href="financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content">
        <h1>Dashboard</h1>
        <div class="cards">
            <div class="card">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-info">
                    <span class="card-title">Clientes</span>
                    <span class="card-value" id="clientes-count">0</span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-car"></i></div>
                <div class="card-info">
                    <span class="card-title">Veículos</span>
                    <span class="card-value" id="veiculos-count">0</span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-coins"></i></div>
                <div class="card-info">
                    <span class="card-title">Saldo</span>
                    <span class="card-value" id="saldo">R$ 0,00</span>
                </div>
            </div>
        </div>
        <div class="dashboard-sections">
            <section>
                <h2>Últimos Clientes</h2>
                <div id="ultimos-clientes">Nenhum cliente cadastrado.</div>
            </section>
            <section>
                <h2>Últimos Veículos</h2>
                <div id="ultimos-veiculos">Nenhum veículo cadastrado.</div>
            </section>
            <section>
                <h2>Movimentação Financeira</h2>
                <div id="ultimos-financeiro">Nenhum lançamento cadastrado.</div>
            </section>
        </div>
    </main>
    <script src="assets/dashboard.js"></script>
</body>
</html>
