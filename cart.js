const cartList = document.getElementById('cart-list');
const emptyCartMessage = document.getElementById('empty-cart-message');
const cartSummary = document.querySelector('.cart-summary');
const subtotalAmount = document.getElementById('subtotal-amount');
const shippingAmount = document.getElementById('shipping-amount');
const totalAmount = document.getElementById('total-amount');

// Calculate total cost including shipping 
const shippingCost = 60.00; 


function updateCartList(cartItems) { // Update to accept cartItems from PHP
    cartList.innerHTML = ""; 

    if (cartItems.length === 0) {
        emptyCartMessage.style.display = 'block';
        cartSummary.style.display = 'none';
        return;
    }

    emptyCartMessage.style.display = 'none';
    cartSummary.style.display = 'block';

    let subtotal = 0;
    for (const item of cartItems) {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.name} - Price: $${item.price.toFixed(2)} Qty: ${item.quantity}`;
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', () => {
            removeFromCart(item.name); // Implement removeFromCart in cart.js
        });
        listItem.appendChild(removeButton);
        cartList.appendChild(listItem);
 
        // Calculate subtotal including item quantity
        subtotal += item.price * item.quantity; 
    }

    subtotalAmount.textContent = subtotal.toFixed(2);
    calculateTotal(subtotal); 
}

function calculateTotal(subtotal) {
    const total = subtotal + shippingCost;
    shippingAmount.textContent = shippingCost.toFixed(2);
    totalAmount.textContent = total.toFixed(2);
}

// Rest of the cart.js code (removeFromCart, event listener for checkout, etc.)
