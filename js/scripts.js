document.addEventListener('DOMContentLoaded', function() {
    // Пример: Получение данных из базы данных
    const books = [
        { id: 1, title: 'Книга 1', author: 'Автор 1', price: 500 },
        { id: 2, title: 'Книга 2', author: 'Автор 2', price: 600 },
        // Добавь больше книг по мере необходимости
    ];

    const booksSection = document.getElementById('books');
    books.forEach(book => {
        const bookElement = document.createElement('div');
        bookElement.innerHTML = `
            <h2>${book.title}</h2>
            <p>${book.author}</p>
            <p>${book.price} руб.</p>
        `;
        booksSection.appendChild(bookElement);
    });

    // Пример: Обработка поиска
    const searchContainer = document.querySelector('.search-container');
    const searchInput = document.getElementById('search-input');
    searchContainer.addEventListener('submit', function(event) {
        event.preventDefault();
        const query = searchInput.value.toLowerCase();
        const results = books.filter(book =>
            book.title.toLowerCase().includes(query) ||
            book.author.toLowerCase().includes(query)
        );
        booksSection.innerHTML = '';
        results.forEach(book => {
            const bookElement = document.createElement('div');
            bookElement.innerHTML = `
                <h2>${book.title}</h2>
                <p>${book.author}</p>
                <p>${book.price} руб.</p>
            `;
            booksSection.appendChild(bookElement);
        });
    });

    // Обработка формы входа
    const loginForm = document.getElementById('login-form');
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const username = document.getElementById('login-username').value;
        const password = document.getElementById('login-password').value;
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const user = users.find(u => u.username === username && u.password === password);
        if (user) {
            const authLink = document.getElementById('auth-link');
            authLink.innerHTML = `<span onclick="toggleUserMenu(event)">${user.nickname}</span>`;
            authLink.removeAttribute('onclick');
            document.getElementById('auth-form').style.display = 'none';
        } else {
            alert('Неверный логин или пароль');
        }
    });

    // Обработка формы регистрации
    const registerForm = document.getElementById('register-form');
    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const nickname = document.getElementById('register-nickname').value;
        const username = document.getElementById('register-username').value;
        const password = document.getElementById('register-password').value;
        const confirmPassword = document.getElementById('register-confirm-password').value;
        if (password !== confirmPassword) {
            alert('Пароли не совпадают');
            return;
        }
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const existingUser = users.find(u => u.username === username);
        if (existingUser) {
            alert('Пользователь с таким логином уже существует');
        } else {
            users.push({ nickname, username, password });
            localStorage.setItem('users', JSON.stringify(users));
            alert('Регистрация успешна');
            document.getElementById('auth-form').style.display = 'none';
        }
    });

    // Слайдер
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;
    let autoSlideInterval;

    function showSlide(index) {
        currentSlide = (index + totalSlides) % totalSlides;
        const sliderContainer = document.querySelector('.slider-container');
        sliderContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
        resetAutoSlide();
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
        resetAutoSlide();
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            nextSlide();
        }, 5000);
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Инициализация слайдера
    showSlide(currentSlide);
    startAutoSlide();

    // Обработка подменю категорий
    const categoriesItem = document.getElementById('categories-item');
    const categoriesSubmenu = document.getElementById('categories-submenu');

    categoriesItem.addEventListener('click', function(event) {
        event.preventDefault();
        if (categoriesSubmenu.style.display === 'block') {
            categoriesSubmenu.style.display = 'none';
        } else {
            categoriesSubmenu.style.display = 'block';
        }
    });

    // Закрытие подменю при клике вне его
    document.addEventListener('click', function(event) {
        if (!categoriesItem.contains(event.target) && !categoriesSubmenu.contains(event.target)) {
            categoriesSubmenu.style.display = 'none';
        }
    });
});

function showAuthForm() {
    document.getElementById('auth-form').style.display = 'block';
}

function showRegisterForm() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
}

function showLoginForm() {
    document.getElementById('register-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
}

let currentSlide = 0;

function prevSlide() {
    const slides = document.querySelectorAll('.slide');
    slides[currentSlide].style.display = 'none';
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    slides[currentSlide].style.display = 'block';
}

function nextSlide() {
    const slides = document.querySelectorAll('.slide');
    slides[currentSlide].style.display = 'none';
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].style.display = 'block';
}
