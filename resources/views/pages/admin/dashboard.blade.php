<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administratif - Restaurant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #e75b1e;
            --primary-hover: #f04900;
            --text-dark: #333;
            --text-light: #777;
            --bg-light: #f8f9fa;
            --white: #ffffff;
            --gray: #e9ecef;
            --border: #dee2e6;
            --success: #28a745;
            --danger: #dc3545;
            --info: #17a2b8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--bg-light);
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--white);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 20px;
            background-color: var(--primary);
            color: var(--white);
            text-align: center;
        }
        
        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-dark);
            text-decoration: none;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(231, 91, 30, 0.1);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }
        
        .menu-item i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-dark);
            display: none;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Dashboard Statistics */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(231, 91, 30, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .stat-icon i {
            font-size: 24px;
            color: var(--primary);
        }
        
        .stat-info h3 {
            font-size: 1.8rem;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .stat-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        /* Content Section */
        .content-section {
            background-color: var(--white);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }
        
        .section-header h2 {
            color: var(--primary);
            font-size: 1.3rem;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        table th {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-weight: 600;
        }
        
        table tr:hover {
            background-color: rgba(231, 91, 30, 0.05);
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-light);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .action-btn.edit {
            color: var(--info);
        }
        
        .action-btn.delete {
            color: var(--danger);
        }
        
        .action-btn:hover {
            background-color: var(--primary);
            color: var(--white);
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(231, 91, 30, 0.2);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        /* User Card Styles */
        .user-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .user-card {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        
        .user-card-header {
            background-color: var(--primary);
            color: var(--white);
            padding: 15px;
            text-align: center;
        }
        
        .user-card-body {
            padding: 15px;
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 15px;
            background-color: var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-avatar i {
            font-size: 40px;
            color: var(--text-light);
        }
        
        .user-info {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .user-info h3 {
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .user-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .user-action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        .user-action-btn {
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
        }
        
        .btn-approve {
            background-color: var(--success);
            color: var(--white);
        }
        
        .btn-decline {
            background-color: var(--danger);
            color: var(--white);
        }
        
        /* Media Queries */
        @media screen and (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -250px;
                height: 100%;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .toggle-sidebar {
                display: block;
            }
            
            .stats-container, .user-cards {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
        
        @media screen and (max-width: 576px) {
            .stats-container, .user-cards {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .user-profile {
                margin-top: 10px;
            }
        }
        
        /* Tabs */
        #tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }
        
        .tab.active {
            border-bottom: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 500;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Restaurant</h2>
            <p>Panneau d'Administration</p>
        </div>
        <div class="sidebar-menu">
            <a href="#dashboard" class="menu-item active" onclick="showTab('dashboard')">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
            <a href="#categories" class="menu-item" onclick="showTab('categories')">
                <i class="fas fa-list"></i> Catégories
            </a>
            <a href="#meals" class="menu-item" onclick="showTab('meals')">
                <i class="fas fa-utensils"></i> Repas
            </a>
            <a href="#users" class="menu-item" onclick="showTab('users')">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="#statistics" class="menu-item" onclick="showTab('statistics')">
                <i class="fas fa-chart-bar"></i> Statistiques
            </a>
            <a href="#settings" class="menu-item">
                <i class="fas fa-cog"></i> Paramètres
            </a>
            <a href="#logout" class="menu-item">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="user-profile">
                <img src="/api/placeholder/40/40" alt="Admin">
                <div>
                    <p><strong>Admin</strong></p>
                    <p>admin@restaurant.com</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Tab -->
        <div id="dashboard" class="tab-content active">
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-info">
                        <h3>45</h3>
                        <p>Total des Repas</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="stat-info">
                        <h3>8</h3>
                        <p>Catégories</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>120</h3>
                        <p>Utilisateurs</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3>67</h3>
                        <p>Commandes</p>
                    </div>
                </div>
            </div>

            <!-- Gestion des Catégories -->
            <div class="content-section">
                <div class="section-header">
                    <h2>Gestion Rapide des Catégories</h2>
                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Nouvelle Catégorie</button>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Nb de Repas</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Entrées</td>
                                <td>Toutes les entrées et amuse-bouches</td>
                                <td>12</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Plats Principaux</td>
                                <td>Plats principaux pour tous les goûts</td>
                                <td>18</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Desserts</td>
                                <td>Desserts variés et gourmands</td>
                                <td>10</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Gestion des Utilisateurs -->
            <div class="content-section">
                <div class="section-header">
                    <h2>Utilisateurs en Attente d'Approbation</h2>
                </div>
                <div class="user-cards">
                    <div class="user-card">
                        <div class="user-card-header">
                            <h3>Nouvel Utilisateur</h3>
                        </div>
                        <div class="user-card-body">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info">
                                <h3>Jean Dupont</h3>
                                <p>jean.dupont@example.com</p>
                                <p>Inscrit le: 02/04/2025</p>
                            </div>
                            <div class="user-action-buttons">
                                <button class="user-action-btn btn-approve">Approuver</button>
                                <button class="user-action-btn btn-decline">Supprimer</button>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="user-card-header">
                            <h3>Nouvel Utilisateur</h3>
                        </div>
                        <div class="user-card-body">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info">
                                <h3>Marie Martin</h3>
                                <p>marie.martin@example.com</p>
                                <p>Inscrit le: 01/04/2025</p>
                            </div>
                            <div class="user-action-buttons">
                                <button class="user-action-btn btn-approve">Approuver</button>
                                <button class="user-action-btn btn-decline">Supprimer</button>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="user-card-header">
                            <h3>Nouvel Utilisateur</h3>
                        </div>
                        <div class="user-card-body">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info">
                                <h3>Pierre Lefebvre</h3>
                                <p>pierre.lefebvre@example.com</p>
                                <p>Inscrit le: 31/03/2025</p>
                            </div>
                            <div class="user-action-buttons">
                                <button class="user-action-btn btn-approve">Approuver</button>
                                <button class="user-action-btn btn-decline">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        