<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XXXBookShop</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><a href="index.php">XXXBookShop</a></h1>
            <div class="auth-container">
                <?php
                session_start();
                include 'php/config.php';

                if (isset($_SESSION['username'])) {
                    $user_id = $_SESSION['user_id'];
                    $stmt = $conn->prepare("SELECT wallet FROM users WHERE id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();

                    echo '<span id="auth-link"><i class="fas fa-user"></i> ' . $_SESSION['username'] . '</span>';
                    echo '<div id="user-menu">
                            <ul>
                                <li><a href="#"><i class="fas fa-shopping-cart"></i> Корзина</a></li>
                                <li><a href="#"><i class="fas fa-wallet"></i> Кошелёк: ' . $user['wallet'] . ' руб.</a></li>
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
                    <form id="search-form" action="php/search.php" method="GET">
                        <input type="text" id="search-input" name="query" placeholder="Поиск..." required>
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <ul class="sidebar-menu">
                    <li>
                        <i class="fas fa-book"></i>
                        <a href="index.php">Книги</a>
                    </li>
                    <li id="categories-item">
                        <i class="fas fa-list"></i>
                        <a href="#">Категории</a>
                        <ul class="submenu" id="categories-submenu">
                            <?php
                            $genresQuery = "SELECT DISTINCT genre FROM books";
                            $genresResult = $conn->query($genresQuery);

                            if ($genresResult->num_rows > 0) {
                                while ($genreRow = $genresResult->fetch_assoc()) {
                                    echo '<li><a href="php/search.php?genre=' . urlencode($genreRow['genre']) . '" class="genre-link"><i class="fas fa-book-open"></i> ' . htmlspecialchars($genreRow['genre']) . '</a></li>';
                                }
                            } else {
                                echo '<li>Нет доступных жанров</li>';
                            }
                            ?>
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
                            $query = "SELECT * FROM actions";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="slide" style="background-image: url(\'images/' . $row['image'] . '\');"></div>';
                                }
                            } else {
                                echo "Нет данных для отображения.";
                            }
                            ?>
                        </div>
                        <button class="slider-btn prev" onclick="prevSlide()">&#10094;</button>
                        <button class="slider-btn next" onclick="nextSlide()">&#10095;</button>
                    </section>
                    <section id="hot-offers">
                        <?php
                        $query = "SELECT * FROM offers";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="offer">';
                                echo '<div class="offer-icon">';
                                // Здесь можно добавить иконки для каждого предложения, если они есть
                                echo '</div>';
                                echo '<div class="offer-details">';
                                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "Нет данных для отображения.";
                        }
                        ?>
                    </section>
                </div>
                <section id="books">
                    <div id="book-container">
                        <?php
                        $categories = ["Новинки литературы", "Лучшие из лучших"];
                        foreach ($categories as $category) {
                            echo '<div class="category">';
                            echo '<h2>' . htmlspecialchars($category) . '</h2>';
                            echo '<div class="book-grid">';

                            $query = isset($_GET['query']) ? $_GET['query'] : '';
                            $sql = "SELECT * FROM books";
                            if (!empty($query)) {
                                $sql .= " WHERE title LIKE '%$query%' OR author LIKE '%$query%' OR genre LIKE '%$query%'";
                            }
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="book">';
                                    echo '<a href="php/book.php?id=' . $row['id'] . '">';
                                    echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                                    echo '</a>';
                                    echo '<h3>' . htmlspecialchars($row["title"]) . '</h3>';
                                    echo '<p>' . htmlspecialchars($row['author']) . '</p>';
                                    echo '<p>' . htmlspecialchars($row['price']) . ' руб.</p>';
                                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                                    echo '<p>' . htmlspecialchars($row['genre']) . '</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo 'Книги не найдены.';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </section>
            </section>
        </main>
        <footer>
            <p>&copy; 2024 XXXBookShop</p>
        </footer>
    </div>
    <div id="auth-form" style="display: none;">
        <form id="login-form" action="php/login.php" method="POST" style="display: block;">
            <h2>Вход</h2>
            <input type="text" id="login-username" name="username" placeholder="Логин или Email" required>
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
            <input type="text" id="register-first-name" name="first_name" placeholder="Имя" required>
            <input type="text" id="register-last-name" name="last_name" placeholder="Фамилия" required>
            <input type="text" id="register-middle-name" name="middle_name" placeholder="Отчество">
            <input type="email" id="register-email" name="email" placeholder="Email" required>
            <input type="text" id="register-phone" name="phone" placeholder="Телефон">
            <button type="submit">Зарегистрироваться</button>
            <button type="button" onclick="showLoginForm()">Войти</button>
        </form>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>
