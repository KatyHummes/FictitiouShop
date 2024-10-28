<script setup>
import { ref, defineProps } from 'vue';
const props = defineProps({
    product: Object,
    relatedProducts: Array
});

const responsiveOptionsRelated = ref([
    {
        breakpoint: '1300px',
        numVisible: 4
    },
    {
        breakpoint: '575px',
        numVisible: 2
    }
]);
</script>

<template>
    <div v-if="relatedProducts && relatedProducts.length">
        <Galleria :value="relatedProducts" :responsiveOptions="responsiveOptionsRelated" :numVisible="2" class=""
            containerStyle="border: white; margin-bottom: 16px">

            <template #thumbnail="slotProps">
                <img :src="slotProps.item.thumbnail" :alt="slotProps.item.alt" />
                <div class="flex justify-between">
                    <p class="text-gray-500 text-sm font-extralight line-through">
                        {{ formatPrice(product.price) }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <p class="text-blue-600 text-xl font-black">
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
</template>