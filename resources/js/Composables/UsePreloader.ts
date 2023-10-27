import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

export function usePreloader() {
    const preload = ref(false)
    function showClosePreloader() {
        router.on('start', () => preload.value = true)
        router.on('finish', (event) => {
            if (event.detail.visit.completed) {
                preload.value = false
            } else if (event.detail.visit.interrupted) {
                preload.value = false
            } else if (event.detail.visit.cancelled) {
                preload.value = false
            }
        })
    }
    return { preload, showClosePreloader }
}