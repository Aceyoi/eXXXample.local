<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин книг</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1>Магазин книг</h1>
        <div class="auth-container">
            <?php
            session_start();
            require 'php/config.php';

            // Проверка подключения
            if (!isset($pdo)) {
                die("Ошибка подключения к базе данных.");
            }

            if (isset($_SESSION['username'])) {
                echo '<span id="auth-link"><i class="fas fa-user"></i> ' . $_SESSION['nickname'] . '</span>';
                echo '<div id="user-menu">
                        <ul>
                            <li><a href="#"><i class="fas fa-shopping-cart"></i> Корзина</a></li>
                            <li><a href="#"><i class="fas fa-wallet"></i> Кошелёк</a></li>
                            <li><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Выйти</a></li>
                        </ul>
                      </div>';
            } else {
                echo '<span id="auth-link"><a href="#" onclick="showAuthForm()"><i class="fas fa-user"></i> Войти</a></span>';
            }
            ?>
        </div>
    </header>
    <main>
        <aside class="sidebar">
            <div class="search-container">
                <form id="search-form" method="GET" action="php/search.php">
                    <input type="text" id="search-input" name="query" placeholder="Поиск...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <i class="fas fa-book"></i>
                    <a href="#">Книги</a>
                </li>
                <li id="categories-item">
                    <i class="fas fa-list"></i>
                    <a href="#">Категории</a>
                    <ul class="submenu" id="categories-submenu">
                        <li><a href="#"><i class="fas fa-book-open"></i> Офисные принадлежности</a></li>
                        <li><a href="#"><i class="fas fa-tools"></i> Бумажная продукция для офиса</a></li>
                        <li><a href="#"><i class="fas fa-archive"></i> Папки, системы архивации</a></li>
                        <li><a href="#"><i class="fas fa-print"></i> Письменные принадлежности</a></li>
                        <li><a href="#"><i class="fas fa-folder"></i> Чертежные принадлежности</a></li>
                        <li><a href="#"><i class="fas fa-briefcase"></i> Учебные и наглядные пособия</a></li>
                        <li><a href="#"><i class="fas fa-pencil-alt"></i> Бумажная продукция для школы</a></li>
                        <li><a href="#"><i class="fas fa-ruler"></i> Школьные текстиль, пеналы</a></li>
                        <li><a href="#"><i class="fas fa-calendar-alt"></i> Календари 2025</a></li>
                        <li><a href="#"><i class="fas fa-gifts"></i> Ежедневники</a></li>
                    </ul>
                </li>
                <li>
                    <i class="fas fa-tags"></i>
                    <a href="#">Акции</a>
                </li>
            </ul>
        </aside>
        <section id="content">
            <div id="slider-and-offers">
                <section id="slider">
                    <div class="slider-container">
                        <?php
                        $sql = "SELECT * FROM actions";
                        $stmt = $pdo->query($sql);
                        $actions = $stmt->fetchAll();
                        foreach ($actions as $action) {
                            echo '<div class="slide" style="background-image: url(\'images/' . $action['image'] . '\');"></div>';
                        }
                        ?>
                    </div>
                    <button class="slider-btn prev" onclick="prevSlide()">&#10094;</button>
                    <button class="slider-btn next" onclick="nextSlide()">&#10095;</button>
                </section>
                <section id="hot-offers">
                    <?php
                    $sql = "SELECT * FROM offers";
                    $stmt = $pdo->query($sql);
                    $offers = $stmt->fetchAll();
                    foreach ($offers as $offer) {
                        echo '<div class="offer">';
                        echo '<div class="offer-icon">';
                        // Здесь можно добавить иконки для каждого предложения, если они есть
                        echo '</div>';
                        echo '<div class="offer-details">';
                        echo '<h3>' . htmlspecialchars($offer['title']) . '</h3>';
                        echo '<p>' . htmlspecialchars($offer['description']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </section>
            </div>
            <section id="books">
                <!-- Книги будут здесь -->
                <?php
                $query = isset($_GET['query']) ? $_GET['query'] : '';
                $sql = "SELECT * FROM books";
                if (!empty($query)) {
                    $sql .= " WHERE title LIKE :query OR author LIKE :query OR genre LIKE :query";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['query' => '%' . $query . '%']);
                } else {
                    $stmt = $pdo->query($sql);
                }
                $books = $stmt->fetchAll();

                if (!empty($books)) {
                    foreach ($books as $book) {
                        echo '<div>';
                        echo '<h2>' . htmlspecialchars($book['title']) . '</h2>';
                        echo '<p>' . htmlspecialchars($book['author']) . '</p>';
                        echo '<p>' . htmlspecialchars($book['price']) . ' руб.</p>';
                        echo '<p>' . htmlspecialchars($book['description']) . '</p>';
                        echo '<p>' . htmlspecialchars($book['genre']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo 'Книги не найдены.';
                }
                ?>
            </section>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Магазин книг</p>
    </footer>
    <div id="auth-form" style="display: none;">
        <form id="login-form" action="php/login.php" method="POST" style="display: block;">
            <h2>Вход</h2>
            <input type="text" id="login-username" name="username" placeholder="Логин" required>
            <input type="password" id="login-password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
            <button type="button" onclick="showRegisterForm()">Зарегистрироваться</button>
        </form>
        <form id="register-form" action="php/register.php" method="POST" style="display: none;">
            <h2>Регистрация</h2>
            <input type="text" id="register-nickname" name="nickname" placeholder="Ник" required>
            <input type="text" id="register-username" name="username" placeholder="Логин" required>
            <input type="password" id="register-password" name="password" placeholder="Пароль" required>
            <input type="password" id="register-confirm-password" name="confirm_password" placeholder="Подтвердите пароль" required>
            <button type="submit">Зарегистрироваться</button>
            <button type="button" onclick="showLoginForm()">Войти</button>
        </form>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>