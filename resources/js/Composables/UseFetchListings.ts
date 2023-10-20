import axios from "axios";
import { ref } from "vue";


const collectionLimit = 24;
const collectionPage = ref(1);
const collections = ref([]);
const loading = ref(false);
export function useFetch() {
    async function getCollections(number = 24, page: number) {


        const response = await axios.get(
            `/api/listings?limit=${number}&page=${page}`
        );
        return response.data;
    }

    async function loadMore() {
        const newCollection = await getCollections(
            collectionLimit,
            collectionPage.value
        );

        // collections.value.push(...newCollection.collections);
        loading.value = true;
        setTimeout(() => (loading.value = false), 100);
    }
    function infiniteScroll() {
        collectionPage.value++;
        loadMore();
    }
    return {
        getCollections,
        collectionLimit,
        collectionPage,
        collections,
        infiniteScroll,
        loading,
    };
}