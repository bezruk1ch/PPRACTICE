document.addEventListener('DOMContentLoaded', () => {
  const items = document.querySelectorAll('.cart-item');

  function recalc(itemEl) {
    const base = parseFloat(itemEl.querySelector('.param-select').dataset.base);
    // сумма модификаторов всех выбранных опций
    let modifiers = 0;
    itemEl.querySelectorAll('.param-select').forEach(sel => {
      modifiers += parseFloat(sel.selectedOptions[0].dataset.modifier);
    });
    const pricePerItem = base + modifiers;
    const qty = parseInt(itemEl.querySelector('.qty-input').value, 10);
    const total = pricePerItem * qty;

    itemEl.querySelector('.price-per-item').textContent = pricePerItem.toFixed(2);
    itemEl.querySelector('.total-price').textContent = total.toFixed(2);
  }

  items.forEach(itemEl => {
    // при старте пересчитаем
    recalc(itemEl);

    // при изменении любого селекта или qty
    itemEl.querySelectorAll('.param-select, .qty-input').forEach(el => {
      el.addEventListener('change', () => recalc(itemEl));
    });
  });

  /* === 2. Доставка / Самовывоз === */
  document.querySelectorAll('.checkout-extra').forEach(extra => {
    const radios = extra.querySelectorAll('[name="shipping_type"]');
    const addrWrap = extra.querySelector('#address-wrap');
    const addrInput = extra.querySelector('input[name="shipping_address"]');

    function toggleAddress() {
      const isDelivery = extra.querySelector('[name="shipping_type"]:checked').value === 'delivery';
      addrWrap.style.display = isDelivery ? 'block' : 'none';
      addrInput.disabled = !isDelivery;
      if (!isDelivery) addrInput.value = '';
    }

    toggleAddress();                        // init
    radios.forEach(r => r.addEventListener('change', toggleAddress));
  });

  /* --- 1. DOM-узлы --- */
  const shippingModal = document.getElementById('shippingModal');
  const contactModal = document.getElementById('contactModal');
  const checkoutBtn = document.querySelector('.btn-submit');      // «Оформить заказ»

  const shippingClose = shippingModal?.querySelector('.close');
  const contactClose = contactModal?.querySelector('.close');
  const nextBtn = shippingModal?.querySelector('button[type="button"]');

  /* --- 2. Вспом‑функции --- */
  const open = el => el?.classList.remove('hidden');
  const close = el => el?.classList.add('hidden');

  function toggleAddressField() {
    const type = document.querySelector('input[name="shipping_type"]:checked')?.value;
    const wrap = document.getElementById('address-wrap');
    const input = document.getElementById('shipping_address');
    const need = type === 'delivery';

    wrap.style.display = need ? '' : 'none';

    if (need) {
      input.required = true;
      input.setAttribute('name', 'shipping_address');   // ← добавили name
    } else {
      input.required = false;
      input.removeAttribute('name');                    // ← убрали name
      input.value = '';
    }
  }

  /* --- 3. События --- */
  // открыть первую модалку
  checkoutBtn?.addEventListener('click', () => open(shippingModal));

  // крестики
  shippingClose?.addEventListener('click', () => close(shippingModal));
  contactClose?.addEventListener('click', () => close(contactModal));

  // «Далее» → проверяем адрес, открываем вторую модалку
  nextBtn?.addEventListener('click', () => {
    const type = document.querySelector('input[name="shipping_type"]:checked')?.value;
    const address = document.getElementById('shipping_address').value.trim();

    if (type === 'delivery' && !address) {
      alert('Пожалуйста, укажите адрес доставки');
      return;
    }
    close(shippingModal);
    open(contactModal);
  });

  // радиокнопки доставки (глобальные, а не в каждой карточке)
  document.querySelectorAll('input[name="shipping_type"]')
    .forEach(r => r.addEventListener('change', toggleAddressField));
  toggleAddressField();               // init
});

