<script setup>
import { ref, computed } from 'vue';
import { useCartStore } from '../Stores/cartStore.js';
import { formatPrice, formatDiscount } from '@/Pages/Utils/utils.js';
import { Link } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

const cartStore = useCartStore();
const cartItems = computed(() => cartStore.items);


const removeFromCart = (item) => {
    const index = cartItems.value.indexOf(item);
    if (index !== -1) {
        cartItems.value.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cartItems.value));
        cartStore.cartTotal = cartItems.value.reduce((total, item) => total + parseFloat(item.price), 0); // atualizar o valor total
    }
};

// Recuperar o carrinho do LocalStorage ao carregar o componente
cartItems.value = JSON.parse(localStorage.getItem('cart')) || [];
</script>

<template>
    <div>
        <div class="my-10">
            <div v-for="(item, index) in cartItems" :key="index" class="flex items-center justify-between gap-2 py-2">
                <img :src="item.thumbnail" alt="imagem do produto" class="w-12 rounded-md">
                <div class="flex justify-start gap-4">
                    <h1 class="font-bold">{{ item.title }}</h1>
                    {{ item.price }}
                </div>
                <button @click="removeFromCart(item)"><i class="pi pi-cart-minus text-red-500"></i></button>
            </div>
        </div>

        <div class="pb-4">
            <p>Valor dos Produtos: {{ formatPrice(cartStore.cartTotal) }}</p>
            <p>Desconto: {{ formatDiscount(cartStore.cartTotalDiscount) }}</p>
            <p>Total com Desconto: {{ formatPrice(cartStore.cartFinalValue) }}</p>
        </div>

        <Link href="/resources/js/Pages/Product.vue"
            class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded bottom-4 left-2 group text-center">
        <div class="hidden group-hover:inline-block px-2" v-motion-roll-visible-top>
            <i class="pi pi-shopping-cart"></i>
        </div>
        <span class="text-xs">COMPRAR</span>
        </Link>
    </div>
</template>