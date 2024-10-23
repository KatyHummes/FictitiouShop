import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    // Estado: onde os dados são armazenados
    state: () => ({
        visible: false,
        items: []
    }),
    // Ações: funções que alteram o estado
    actions: {
        addToCart(product) {
            this.items.push(product);
        },
        clearCart() {
            this.items = [];
        },

        toggleCart() {
            this.visible = !this.visible;
        },

        removeFromCart(product) {
            console.log('Produto a ser removido:', product);
            this.items = this.items.filter(item => item.id !== product.id);
            console.log('Itens restantes no carrinho:', this.items);
        }
    },

    // Getters: funções que retornam valores derivados do estado
    getters: {
        cartCount: (state) => state.items?.length,

        // Adiciona 0 como valor inicial
        cartTotal: (state) => state.items.reduce((total, item) => total + parseFloat(item.price), 0),

        // Ajusta o cálculo do desconto, adicionando 0 como valor inicial
        cartTotalDiscount: (state) => {
            return state.items.reduce((total, item) => {
                return total + (item.price * (item.discount_percentage / 100));
            }, 0);
        },

        // Ajusta o valor final do carrinho
        cartFinalValue: (state) => {
            const total = state.items.reduce((sum, item) => sum + parseFloat(item.price), 0);
            const totalDiscount = state.items.reduce((sum, item) => sum + (item.price * (item.discount_percentage / 100)), 0);
            return total - totalDiscount;  
        }
    }
});