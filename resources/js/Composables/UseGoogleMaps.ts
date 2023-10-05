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
    const inputValue = ref('')
    function usePlaces(input: HTMLInputElement, value: string) {
        async function load() {
            const result = await loader.importLibrary('places')
            console.log(result);

            const autocomplete = new result.Autocomplete(input, options)

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace()
                value = place.formatted_address
                inputValue.value = value
            })
        }
        load()
    }
    return { usePlaces, inputValue }
}