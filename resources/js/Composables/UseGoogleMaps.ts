import { Loader } from "@googlemaps/js-api-loader"
import { ref } from "vue";
const options = {
    componentRestrictions: { country: "cm" },
    strictBounds: false,
};
const loader = new Loader({
    apiKey: import.meta.env.VITE_GOOGLE_MAPS_API,
    version: "weekly",
    libraries: ['places'],
});

export function useGoogleMaps() {
    const inputValue = ref('')
    function usePlaces(input: HTMLInputElement, value: string) {
        (async function () {
            const result = await loader.importLibrary('places')

            const autocomplete = new result.Autocomplete(input, options)

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace()
                value = place.formatted_address
                inputValue.value = value
            })
        })()

    }
    return { usePlaces, inputValue }
}