// Funções utilitárias para serem usadas em qualquer lugar do projeto

// Função para formatar o preço
export const formatPrice = (price) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(price);
};

// Função para formatar o desconto
export const formatDiscount = (discount) => {
    const discountNumber = Number(discount); // Garante que seja número
    return `-${discountNumber.toFixed(2).replace('.', ',')}%`;
};

// Função para aplicar o desconto ao preço
export const applyDiscount = (price, discount) => {
    const discountedPrice = price - (price * (discount / 100));
    return discountedPrice;
};

// Função para mostrar apenas uma prévia da descrição
export const previewDescription = (description, maxLength = 45) => {
    if (description.length > maxLength) {
        return description.slice(0, maxLength) + '...';
    }
    return description;
};


export const addToCart = (product) => {
    if (!product) {
        console.error('Error: Product is null or undefined');
        return;
    }

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(product);

    localStorage.setItem('cart', JSON.stringify(cart));
    cartItems.value = cart;

    try {
        // Atualizar o valor total
        cartStore.cartTotal = cart.reduce((total, item) => total + parseFloat(item.price), 0);

        // Open the sidebar
        toggleCart();
    } catch (error) {
        console.error('Error updating cart in LocalStorage:', error);
    }
    toggleCart();
};