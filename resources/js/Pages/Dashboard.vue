<script setup>
import { defineProps } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import 'primeicons/primeicons.css';
import ShoppingCart from '@/Components/ShoppingCart.vue';
import { useCartStore } from '@/Stores/cartStore.js';
import { useFavoriteStore } from '@/Stores/favoriteStore.js';
import Drawer from 'primevue/drawer';
import CardProduct from '@/Components/CardProduct.vue';

const props = defineProps({
    products: Array,
});

const cartStore = useCartStore();
const favoriteStore = useFavoriteStore();

const handleAddToCart = (product) => {
    cartStore.addToCart(product);
    toggleCart();
}

const handleAddToFavorite = (productId) => {
    console.log('Adicionando favorito:', productId);
    
    favoriteStore.addFavorite(productId);
}

</script>
<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-2 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid md:grid-cols-4 gap-4">
                       <CardProduct :products="products" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
    <Drawer v-model:visible="cartStore.visible" header="Carrinho de Compras" position="right"
        class="!w-full md:!w-96 lg:!w-[30rem] relative">
        <ShoppingCart @close="toggleCart" />
    </Drawer>
</template>