<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { formatPrice, formatDiscount, applyDiscount } from '@/Pages/Utils/utils.js';
import Galleria from 'primevue/galleria';
import { useFavoriteStore } from '@/Stores/favoriteStore.js';
import { useCartStore } from '@/Stores/cartStore.js';
import RelatedProducts from '@/Components/RelatedProducts.vue';

const props = defineProps({
    product: Object,
    relatedProducts: Array
});

const responsiveOptions = ref([
    {
        breakpoint: '768px',
        numVisible: 2
    },
    {
        breakpoint: '640px',
        numVisible: 1
    }
]);

const responsiveOptionsRelated = ref([
    {
        breakpoint: '768px	',
        numVisible: 4
    },
    {
        breakpoint: '640px',
        numVisible: 2
    }
]);

const favoriteStore = useFavoriteStore();
const handleAddToFavorite = (productId, isFavorite) => {
    if (isFavorite) {
        favoriteStore.removeFavorite(productId);
    } else {
        favoriteStore.addFavorite(productId);
    }
}

const cartStore = useCartStore();
const handleAddToCart = (product) => {
    cartStore.addToCart(product);
    toggleCart();
}
</script>
<template>
    <AppLayout title="Product">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1 class="text-xl font-bold text-center text-gray-900 py-4">{{ product.title }}</h1>
                    <!-- {{ product }} -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="px-4">
                            <div class="grid grid-cols-3">
                                <p class="text-gray-900 text-sm font-extralight border-e-gray-900 ">Nome do Vendedor</p>
                                <p>{{ product.rating }}</p>
                                <div class="hidden group-hover:inline-block absolute top-2 right-4">
                                    <button
                                        @click="handleAddToFavorite(product.id, favoriteStore.isFavorite(product.id))"
                                        v-if="$page.props.auth.user">

                                        <i class="pi pi-heart-fill p-1"
                                            :class="{ 'text-red-500': favoriteStore.isFavorite(product.id) }"></i>
                                    </button>
                                    <button @click="handleAddToCart(product)">
                                        <i class="pi pi-cart-plus p-1"></i>
                                    </button>
                                </div>
                            </div>

                            <Galleria :value="product.images" :responsiveOptions="responsiveOptions" :numVisible="2"
                                containerStyle="max-width: 640px; border: white; margin-bottom: 16px">
                                <template #item="slotProps" class="">
                                    <img :src="slotProps.item.image_path" :alt="slotProps.item.alt" style="width: 100%"
                                        class="object-contain h-96" />
                                </template>
                                <template #thumbnail="slotProps" class="h-20">
                                    <img :src="slotProps.item.image_path" :alt="slotProps.item.alt"
                                        class="object-contain h-20" />
                                </template>
                            </Galleria>
                        </div>
                        <div class="">
                            <div class="grid md:grid-cols-2 px-4 py-6">
                                <div>
                                    <div class="flex justify-between">
                                        <p class="text-gray-500 text-sm font-extralight line-through">
                                            {{ formatPrice(product.price) }}
                                        </p>
                                        <div v-if="product.stock > 0">
                                            <p class="text-gray-500 text-sm font-extralight pr-4">
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
                                <Link href="/resources/js/Pages/Product.vue"
                                    class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded group text-center">
                                <div class="hidden group-hover:inline-block px-2" v-motion-roll-visible-top>
                                    <i class="pi pi-shopping-cart"></i>
                                </div>
                                <span class="text-xs">COMPRAR</span>
                                </Link>
                            </div>
                            <div class="px-4">
                                <h1 class="text-xl font-bold text-center text-gray-900 py-4"><i
                                        class="pi pi-sparkles"></i> PRODUTOS
                                    RELACIONADOS</h1>
                                <div>
                                    <div v-if="relatedProducts && relatedProducts.length">
                                        <Galleria :value="relatedProducts" :responsiveOptions="responsiveOptionsRelated"
                                            :numVisible="2" class="h-20"
                                            containerStyle="height: 200px; border: white; margin-bottom: 16px">

                                            <template #thumbnail="slotProps">
                                                <img :src="slotProps.item.thumbnail" :alt="slotProps.item.alt"
                                                    class="object-contain h-20" />
                                                <div class="flex justify-between">
                                                    <p class="text-gray-500 text-xs font-extralight line-through">
                                                        {{ formatPrice(product.price) }}
                                                    </p>
                                                </div>
                                                <div class="flex gap-2">
                                                    <p class="text-blue-600 text-base font-black">
                                                        {{ formatPrice(applyDiscount(product.price,
                                                            product.discount_percentage)) }}
                                                    </p>
                                                </div>
                                            </template>
                                        </Galleria>
                                    </div>
                                    <div v-else>
                                        <p>Sem produtos relacionados</p>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-center text-gray-900 py-4">DESCRIÇÃO:</h1>
                                    <P class="font-extralight text-sm text-gray-600 py-4">{{ product.description }}</P>
                                    <h2 class="text-xl font-bold text-center text-gray-900 py-4">TAMANHOS:</h2>
                                    <div class="flex justify-between py-4">
                                    <p class="font-extralight text-sm text-gray-600">Largura: {{ product.dimensions.width }}</p>
                                    <p class="font-extralight text-sm text-gray-600">Altura: {{ product.dimensions.height }}</p>
                                    <p class="font-extralight text-sm text-gray-600">Profundidade: {{ product.dimensions.depth }}</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>