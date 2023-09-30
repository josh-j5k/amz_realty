import { Loader } from "@googlemaps/js-api-loader"
import { ref } from "vue";
const options = {
    componentRestrictions: { country: "cm" },
    strictBounds: false,
};
const loader = new Loader({
    apiKey: "AIzaSyAj3t8m1tT8R9LuME3pcNedY9IK6aUjsu4",
    version: "weekly",
    libraries: ['places'],
});
export function useGoogleMaps() {
    const val = ref('')
    function usePlaces(input: HTMLInputElement, inputValue: string) {

        loader.importLibrary('places').then(res => {
            const autocomplete = new res.Autocomplete(input, options)
            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace()
                val.value = place.formatted_address
            })
        }).finally(() => inputValue = val.value)
    }
    return { usePlaces }
}