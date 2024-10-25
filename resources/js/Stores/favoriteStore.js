// stores/favorites.js
import { defineStore } from 'pinia';
import axios from 'axios';

export const useFavoriteStore = defineStore('favorites', {
    state: () => ({
        favorites: [],
    }),

    actions: {
        async fetchFavorites() {
            try {
                const response = await axios.get(route('favorites'));
                console.log('favorites:', response);

                this.favorites = response.data; // Atualizar a lista de favoritos
            } catch (error) {
                console.error('Error fetching favorites:', error);
            }
        },
        async addFavorite(productId) {
            try {
                await axios.post(route('favorites.add'),
                    {
                        product_id: productId
                    }); // Adicionar o novo favorito na lista
                this.favorites.push({ id: productId });
            } catch (error) {
                console.error('Error adding favorite:', error);
            }
        },
        async removeFavorite(productId) {
            try {
                await axios.delete(route('favorites.remove', productId)); // Remover o favorito do servidor
                this.favorites = this.favorites.filter(p => p.id !== productId);
            } catch (error) {
                console.error('Error removing favorite:', error);
            }
        },
        isFavorite(productId) {
            console.log('call isFavorite:', productId);
            console.log(this.favorites?.some(f => f.id === productId));

            return this.favorites?.some(f => f.id === productId); // Verificar se o favorito existe
        },
    },
});
