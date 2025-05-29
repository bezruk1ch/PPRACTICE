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
    itemEl.querySelector('.total-price').textContent      = total.toFixed(2);
  }

  items.forEach(itemEl => {
    // при старте пересчитаем
    recalc(itemEl);

    // при изменении любого селекта или qty
    itemEl.querySelectorAll('.param-select, .qty-input').forEach(el => {
      el.addEventListener('change', () => recalc(itemEl));
    });
  });
});
