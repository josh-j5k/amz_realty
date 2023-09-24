import { Loader } from "@googlemaps/js-api-loader"
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
    function usePlaces(input: HTMLInputElement, inputVaule: string) {
        loader.importLibrary('places').then(res => {

            const autocomplete = new res.Autocomplete(input, options)

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace()
                inputVaule = place.formatted_address
            })
        })
    }
    return { usePlaces }
}