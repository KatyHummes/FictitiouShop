<script setup>
import { ref, defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import 'primeicons/primeicons.css';
import ShoppingCart from '@/Components/ShoppingCart.vue';
import { formatPrice, formatDiscount, applyDiscount, previewDescription } from '@/Pages/Utils/utils.js';
import { useCartStore } from '../Stores/cartStore.js';
import Drawer from 'primevue/drawer';

const props = defineProps({
    products: Array,
});

const cartStore = useCartStore();


const handleAddToCart = (product) => {
    cartStore.addToCart(product);
    toggleCart();
}
const toggleCart = () => {
    cartStore.toggleCart();
};

</script>
<template>
    {{ cartStore }}
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-2 overflow-hidden shadow-xl sm:rounded-lg">
                    <button @click="toggleCart()">
                        Ver carrinho {{ cartStore.visible }}
                    </button>
                    <div class="grid md:grid-cols-4 gap-4">
                        <div v-for="product in products" :key="product.id">

                            <div v-motion-fade-visible
                                class="border-2 houver:drop-shadow-lg rounded-xl p-4 h-96 flex flex-col justify-between group relative ">
                                <!-- Ícones de Favoritos e Carrinho -->
                                <div class="hidden group-hover:inline-block absolute top-2 right-4">
                                    <button @click="addToFavorites(product)">
                                        <i class="pi pi-heart-fill p-1"></i>
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
