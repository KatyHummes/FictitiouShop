<script setup>
import { defineProps, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import 'primeicons/primeicons.css';
import { formatPrice, formatDiscount, applyDiscount, previewDescription } from '@/Pages/Utils/utils.js';
import { useCartStore } from '@/Stores/cartStore.js';
import { useFavoriteStore } from '@/Stores/favoriteStore.js';

const props = defineProps({
    products: Array,
});
const cartStore = useCartStore();
const favoriteStore = useFavoriteStore();

const handleAddToCart = (product) => {
    cartStore.addToCart(product);
    toggleCart();
}

const handleAddToFavorite = (productId, isFavorite) => {
    if (isFavorite) {
        favoriteStore.removeFavorite(productId);
    } else {
        favoriteStore.addFavorite(productId);
    }
}

onMounted(() => {
    favoriteStore.fetchFavorites();
})
</script>
<template>
    <div v-for="product in products" :key="product.id">

        <div v-motion-fade-visible
            class="border-2 houver:drop-shadow-lg rounded-xl p-4 h-96 flex flex-col justify-between group relative ">
            <!-- Ícones de Favoritos e Carrinho -->
            <div class="hidden group-hover:inline-block absolute top-2 right-4">
                <button @click="handleAddToFavorite(product.id, favoriteStore.isFavorite(product.id))"
                v-if="$page.props.auth.user">

                    <i class="pi pi-heart-fill p-1"
                        :class="{ 'text-red-500': favoriteStore.isFavorite(product.id) }"></i>
                </button>
                <button @click="handleAddToCart(product)">
                    <i class="pi pi-cart-plus p-1"></i>
                </button>
            </div>

            <!-- Imagem do Produto -->
            <Link :href="`/products/${product.id}`">
            <div class="flex items-center justify-center">
                <img :src="product.thumbnail" alt="imagem do produto" class="w-32 rounded-md">
            </div>
            <div>
                <h1 class="text-xl font-bold text-center text-gray-800">{{ product.title }}</h1>
                <p class="font-extralight text-sm text-center text-gray-600">
                    {{ previewDescription(product.description) }}
                </p>
                <div class="py-4">
                    <div class="flex justify-between">
                        <p class="text-gray-500 text-sm font-extralight line-through">
                            {{ formatPrice(product.price) }}
                        </p>
                        <div v-if="product.stock > 0">
                            <p class="text-gray-500 text-sm font-extralight ">
                                Restam {{ product.stock }} unid.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <p class="text-blue-600 text-xl font-black">
                            {{ formatPrice(applyDiscount(product.price,
                                product.discount_percentage)) }}
                        </p>
                        <p
                            class="text-white text-ellipsis font-bold text-sm border-2 border-black bg-black rounded-full">
                            {{ formatDiscount(product.discount_percentage) }}
                        </p>
                    </div>
                </div>
            </div>
            </Link>
            <Link href="/resources/js/Pages/Product.vue"
                class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded group text-center">
            <div class="hidden group-hover:inline-block px-2" v-motion-roll-visible-top>
                <i class="pi pi-shopping-cart"></i>
            </div>
            <span class="text-xs">COMPRAR</span>
            </Link>
        </div>
    </div>

</template>
