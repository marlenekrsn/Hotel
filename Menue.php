<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['Registrieren'])) {
            header("Location: Registrieren.php");
        } elseif (isset($_POST['Login'])) {
            header("Location: Login.php");
        } elseif (isset($_POST['Angebote'])) {
            header("Location: Angebote.php");
        } elseif (isset($_POST['Reservierungen'])) {
            header("Location: Reservierungen.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hauptmenü - Hotel Kamel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_menue.css">
</head>
<body>
    <?php if (isset($_SESSION['vorname'])): ?>
        <header class="header-nav">
            <form action="" method="post" class="nav-form">
                <button type="submit" id="abmelden" name="abmelden" class="btn-logout">
                    Abmelden
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </button>
            </form>
            <?php
                if(isset($_POST["abmelden"])){
                    session_destroy();
                    header("location:Menue.php");
                    exit;
                }
            ?>
        </header>
    <?php endif; ?>

    <div class="menu-container">
        <div class="menu-card">
            <div class="hotel-logo">
                <span class="logo-icon">🐫</span>
                <h2>Hotel Kamel</h2>
                <div class="logo-divider"></div>
            </div>
            
            <h1>Hauptmenü</h1>
            
            <?php
            if (isset($_SESSION['vorname']) && isset($_SESSION['nachname'])) {
                echo "<div class='welcome-box logged-in'>
                        <span class='welcome-badge'>Eingeloggt</span>
                        <p class='welcome-text'>Willkommen zurück, <strong class='user-name'>" . htmlspecialchars($_SESSION['vorname']) . " " . htmlspecialchars($_SESSION['nachname']) . "</strong>!</p>
                      </div>";
            } else {
                echo "<div class='welcome-box guest'>
                        <span class='welcome-badge'>Gast</span>
                        <p class='welcome-text'>Herzlich willkommen! Melden Sie sich an, um Zimmer zu buchen.</p>
                      </div>";
            }
            ?>

            <form action="" method="post" class="menu-form">
                <div class="menu-grid">
                    <?php if (!isset($_SESSION['vorname'])): ?>
                        <button type="submit" name="Registrieren" class="btn-menu">
                            <span class="btn-icon">👤</span>
                            <div class="btn-content">
                                <span class="btn-title">Registrieren</span>
                                <span class="btn-desc">Neues Konto erstellen</span>
                            </div>
                        </button>
                        
                        <button type="submit" name="Login" class="btn-menu">
                            <span class="btn-icon">🔑</span>
                            <div class="btn-content">
                                <span class="btn-title">Anmelden</span>
                                <span class="btn-desc">In Ihr Konto einloggen</span>
                            </div>
                        </button>
                    <?php endif; ?>
                    
                    <button type="submit" name="Angebote" class="btn-menu">
                        <span class="btn-icon">🌴</span>
                        <div class="btn-content">
                            <span class="btn-title">Zimmer buchen</span>
                            <span class="btn-desc">Entdecken Sie unsere Oasen</span>
                        </div>
                    </button>
                    
                    <button type="submit" name="Reservierungen" class="btn-menu">
                        <span class="btn-icon">📅</span>
                        <div class="btn-content">
                            <span class="btn-title">Meine Buchungen</span>
                            <span class="btn-desc">Bestehende Reservierungen</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>