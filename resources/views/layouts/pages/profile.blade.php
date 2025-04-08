<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/profile.css'])
    @vite(['resources/css/footer.css'])
</head>

<body class="bg-[#ecf0f1] font-montserrat">
    @include('page-elements.header')

    <section class="profile-section">
        <h2 class="section-title">Личный кабинет</h2>

        <!-- Информация о пользователе -->
        <div class="profile-info">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="avatar-block">
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Аватар" class="profile-avatar">
                    <input type="file" name="profile_picture">
                </div>

                <div class="input-group">
                    <label>Имя</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}">
                </div>
                <div class="input-group">
                    <label>Фамилия</label>
                    <input type="text" name="surname" value="{{ auth()->user()->surname }}">
                </div>
                <div class="input-group">
                    <label>Отчество</label>
                    <input type="text" name="middle_name" value="{{ auth()->user()->middle_name }}">
                </div>
                <div class="input-group">
                    <label>Дата рождения</label>
                    <input type="date" name="birth_date" value="{{ auth()->user()->birth_date }}">
                </div>
                <div class="input-group">
                    <label>Телефон</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}">
                </div>
                <div class="input-group">
                    <label>Логин</label>
                    <input type="text" name="login" value="{{ auth()->user()->login }}">
                </div>
                <div class="input-group">
                    <label>Пароль (оставьте пустым, если не меняете)</label>
                    <input type="password" name="password">
                </div>

                <button type="submit" class="save-btn">Сохранить изменения</button>
            </form>
        </div>

        <!-- Текущие заказы -->
        <div class="orders-section">
            <h3>Текущие заказы</h3>
            <ul>
                @forelse($currentOrders as $order)
                <li>{{ $order->title }} - {{ $order->status }}</li>
                @empty
                <li>Нет активных заказов.</li>
                @endforelse
            </ul>
        </div>

        <!-- История заказов -->
        <div class="orders-section">
            <h3>История заказов</h3>
            <ul>
                @forelse($pastOrders as $order)
                <li>{{ $order->title }} - {{ $order->status }}</li>
                @empty
                <li>История заказов пуста.</li>
                @endforelse
            </ul>
        </div>

        <!-- Оставить отзыв -->
        <div class="review-form">
            <h3>Оставить отзыв</h3>
            <form action="{{ route('profile.review') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label>Оценка</label>
                    <select name="rating">
                        <option value="5">5 - Отлично</option>
                        <option value="4">4 - Хорошо</option>
                        <option value="3">3 - Нормально</option>
                        <option value="2">2 - Плохо</option>
                        <option value="1">1 - Ужасно</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Комментарий</label>
                    <textarea name="comment" rows="4"></textarea>
                </div>
                <button type="submit" class="save-btn">Отправить</button>
            </form>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Выход</button>
        </form>
    </section>

    @include('page-elements.footer')
</body>


</html>