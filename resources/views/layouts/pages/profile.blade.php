<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/profile.css'])
    @vite(['resources/css/footer.css'])
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    @include('page-elements.header')

    <section class="profile-section">
        <div class="container-profile">
            <h2 class="profile-title">Личный кабинет</h2>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                @csrf
                @method('POST')

                <div class="avatar-block">
                    <img src="{{ asset($user->profile_picture) }}" alt="Аватар" class="profile-avatar" id="avatarPreview">

                    <label for="profile_picture" class="avatar-overlay">Выбрать</label>
                    <input type="file" id="profile_picture" name="profile_picture" class="avatar-input" accept="image/*">
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
                    <label>Пол</label>
                    <select name="gender">
                        <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>Мужской</option>
                        <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>Женский</option>
                        <option value="other" {{ auth()->user()->gender === 'other' ? 'selected' : '' }}>Другое</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}">
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

            <div class="orders-section">
                <h3>Текущие заказы</h3>
                @forelse ($currentOrders as $order)
                <div class="order-block">
                    <p><strong>Номер заказа:</strong> {{ $order->id }}</p>
                    <p><strong>Статус:</strong> {{ $order->status }}</p>
                    <p><strong>Сумма:</strong> {{ number_format($order->total_price, 2) }} руб.</p>
                    <ul>
                        @foreach ($order->items as $item)
                        <li>
                            <strong>{{ $item->project_name }}</strong><br>
                            Тип: {{ $item->product_type }}<br>
                            Кол-во: {{ $item->quantity }}<br>
                            Цена за шт.: {{ $item->price_per_item }} руб.
                        </li>
                        @endforeach
                    </ul>
                </div>
                @empty
                <p>У вас нет текущих заказов.</p>
                @endforelse
            </div>

            <div class="orders-section">
                <h3>История заказов</h3>
                @forelse ($pastOrders as $order)
                <div class="order-block">
                    <p><strong>Номер заказа:</strong> {{ $order->id }}</p>
                    <p><strong>Статус:</strong> {{ $order->status }}</p>
                    <p><strong>Сумма:</strong> {{ number_format($order->total_price, 2) }} руб.</p>
                    <ul>
                        @foreach ($order->items as $item)
                        <li>
                            <strong>{{ $item->project_name }}</strong><br>
                            Тип: {{ $item->product_type }}<br>
                            Кол-во: {{ $item->quantity }}<br>
                            Цена за шт.: {{ $item->price_per_item }} руб.
                        </li>
                        @endforeach
                    </ul>
                </div>
                @empty
                <p>У вас нет завершённых заказов.</p>
                @endforelse
            </div>

            <div class="review-form" id="leave-review-section">
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
        </div>

        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Выйти из аккаунта</button>
            </form>
        </div>
    </section>

    @include('page-elements.footer')
</body>

</html>