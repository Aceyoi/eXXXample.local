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
                <form id="search-form" method="GET" action="index.php">
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
                        <div class="slide" style="background-image: url('images/slide1.jpg');"></div>
                        <div class="slide" style="background-image: url('images/slide2.jpg');"></div>
                        <div class="slide" style="background-image: url('images/slide3.jpg');"></div>
                    </div>
                    <button class="slider-btn prev" onclick="prevSlide()">&#10094;</button>
                    <button class="slider-btn next" onclick="nextSlide()">&#10095;</button>
                </section>
                <section id="hot-offers">
                    <div class="offer">
                        <div class="offer-icon">
                            <img src="images/icon1.png" alt="Иконка 1">
                        </div>
                        <div class="offer-details">
                            <h3>Месяц камбеков</h3>
                            <p>Максимальная скидка на книги Макса Яроса – с новинками!</p>
                        </div>
                    </div>
                    <div class="offer">
                        <div class="offer-icon">
                            <img src="images/icon2.png" alt="Иконка 2">
                        </div>
                        <div class="offer-details">
                            <h3>Книжный дозор</h3>
                            <p>Делитесь впечатлениями, получайте бонусы!</p>
                        </div>
                    </div>
                    <div class="offer">
                        <div class="offer-icon">
                            <img src="images/icon3.png" alt="Иконка 3">
                        </div>
                        <div class="offer-details">
                            <h3>Приглашение на Чёрную пятницу</h3>
                            <p>Приходите, чтобы зажечь выгоду!</p>
                        </div>
                    </div>
                </section>
            </div>
            <section id="books">
                <!-- Книги будут здесь -->
                <?php
                // Пример: Получение данных из базы данных
                $books = [
                    ['id' => 1, 'title' => 'Книга 1', 'author' => 'Автор 1', 'price' => 500],
                    ['id' => 2, 'title' => 'Книга 2', 'author' => 'Автор 2', 'price' => 600],
                    // Добавь больше книг по мере необходимости
                ];

                if (isset($_GET['query'])) {
                    $query = strtolower($_GET['query']);
                    $books = array_filter($books, function($book) use ($query) {
                        return strpos(strtolower($book['title']), $query) !== false || strpos(strtolower($book['author']), $query) !== false;
                    });
                }

                foreach ($books as $book) {
                    echo '<div>';
                    echo '<h2>' . htmlspecialchars($book['title']) . '</h2>';
                    echo '<p>' . htmlspecialchars($book['author']) . '</p>';
                    echo '<p>' . htmlspecialchars($book['price']) . ' руб.</p>';
                    echo '</div>';
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
