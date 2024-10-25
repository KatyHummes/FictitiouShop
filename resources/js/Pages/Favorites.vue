<script setup>
import { defineProps } from 'vue';
import 'primeicons/primeicons.css';
import { useFavoriteStore } from '../Stores/favoriteStore.js';
import CardProduct from '@/Components/CardProduct.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    products: Array,
});

const favoriteStore = useFavoriteStore();

const handleAddToFavorite = (productId) => {
    favoriteStore.addFavorite(productId);
}

</script>
<template>
    <AppLayout>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-2 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid md:grid-cols-4 gap-4">
                    <CardProduct :products="products" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
