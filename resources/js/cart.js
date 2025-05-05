document.addEventListener('DOMContentLoaded', function () {
    const cartItems = [];
    const cartItemsList = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');

    // Пример добавления товара в корзину
    function addToCart(productId, productName, price, quantity) {
        // Проверяем, есть ли товар в корзине
        let itemIndex = cartItems.findIndex(item => item.productId === productId);
        if (itemIndex > -1) {
            // Если товар уже есть, увеличиваем количество
            cartItems[itemIndex].quantity += quantity;
        } else {
            // Если товара нет, добавляем новый
            cartItems.push({ productId, productName, price, quantity });
        }
        updateCart();
    }

    // Обновляем корзину (перерисовываем товары и сумму)
    function updateCart() {
        cartItemsList.innerHTML = '';  // Очищаем список

        let total = 0;
        cartItems.forEach(item => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `${item.productName} - ${item.quantity} шт. - ${item.price * item.quantity} руб.`;
            cartItemsList.appendChild(listItem);
            total += item.price * item.quantity;
        });

        cartTotal.innerHTML = `Итого: ${total} руб.`;
    }

    // Пример оформления заказа
    checkoutBtn.addEventListener('click', function () {
        alert('Оформить заказ!');
        // Здесь можно отправить данные корзины на сервер для оформления заказа
    });

    // Пример использования
    // Допустим, при добавлении товара на страницу, например:
    addToCart(1, 'Визитка', 200, 2);  // Продукт с ID = 1, Название = Визитка, Цена = 200, Кол-во = 2
});