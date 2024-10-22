<script setup>
import { ref, defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import 'primeicons/primeicons.css';

const props = defineProps({
    products: Array,
});


// Função para formatar o preço
const formatPrice = (price) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(price);
};

// Função para formatar o desconto
const formatDiscount = (discount) => {
    const discountNumber = Number(discount); // Garante que seja número
    return `-${discountNumber.toFixed(2).replace('.', ',')}%`;
};

// Função para aplicar o desconto ao preço
const applyDiscount = (price, discount) => {
    const discountedPrice = price - (price * (discount / 100));
    return discountedPrice;
};

// Função para mostrar apenas uma prévia da descrição
const previewDescription = (description, maxLength = 45) => {
    if (description.length > maxLength) {
        return description.slice(0, maxLength) + '...';
    }
    return description;
};
</script>
<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-2 overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="grid md:grid-cols-4 gap-4">
                        <div v-for="product in products" :key="product.id">
                            <Link :href="`/products/${product.id}`">
                            <div class="border-2 houver:drop-shadow-lg rounded-xl p-4 h-96 flex flex-col justify-between">
                                <div class="flex items-center justify-center">
                                    <img :src="product.thumbnail" alt="imagem do produto" class="w-32 rounded-md">
                                </div>
                                <div class="">
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
                                <Link href="/resources/js/Pages/Product.vue" v-motion-roll-visible-left
                                    class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded group text-center">
                                    <div class="hidden group-hover:inline-block px-2" v-motion-roll-visible-top>
                                        <i class="pi pi-shopping-cart"></i>
                                    </div>
                                    <span class="text-xs" v-motion-roll-visible-left >COMPRAR</span>
                                </Link>
                            </div>
                            </Link>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
