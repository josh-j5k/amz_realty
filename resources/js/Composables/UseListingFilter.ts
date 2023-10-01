import { router, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

const form = reactive({

})
const filteredBy = ref(<string[] | number[]>[])
const locations = ref('')
const locationError = ref(false)
const priceError = ref(false)
const status = ref('all')
const propertyType = ref(<string[]>[])

const price = ref(
    {
        min: '',
        max: '',
    }
)


const statusCheckbox = ref([status.value])
export function useListingFilter() {


    function submit(input: any, key: string, value: string): void {
        input[key] = value
        router.get('/listings', input)
    }
    function updateCheckbox() {
        statusCheckbox.value = [status.value]
        submit(form, 'status', status.value)
        // filteredBy.value = [...statusForm.status]
    }
    function locationSubmit() {
        if (locations === null || locations.value.length === 0) {
            locationError.value = true
            setTimeout(() => locationError.value = false, 4000)
            return
        }
        // filteredBy.value = [...locations]
        submit(form, 'location', locations.value)
    }
    function setPriceError() {
        priceError.value = true
        setTimeout(() => priceError.value = false, 4000)
        return
    }
    function priceValidate() {
        const newPriceMin = parseInt(price.value.min)
        const newPriceMax = parseInt(price.value.max)
        if (price.value.min.length === 0 && price.value.max.length === 0) {
            setPriceError()
        } else if (price.value.min.length > 0 && isNaN(newPriceMin)) {
            setPriceError()
        } else if (price.value.max.length > 0 && isNaN(newPriceMax)) {
            setPriceError()
        } else if (newPriceMin > newPriceMax) {
            setPriceError()
        } else {
            return true
        }

    }
    // function priceSubmit() {
    //     if (priceValidate()) {

    //         if (price.value.min.length > 0 && price.value.max.length === 0) {
    //             form[price] = form.price.price + 'min_'.concat(price.value.min)
    //             filteredBy.value = [...'over '.concat(price.value.min)]
    //         }
    //         if (price.value.max.length > 0 && price.value.min.length === 0) {
    //             formPrice.price = formPrice.price + 'max_'.concat(price.value.max)
    //             filteredBy.value = [...'under '.concat(price.value.max)]
    //         }
    //         if (price.value.max.length > 0 && price.value.min.length > 0) {
    //             formPrice.price = formPrice.price + 'min_'.concat(price.value.min) + '|' + 'max_'.concat(price.value.max)
    //             filteredBy.value = [...`${price.value.min} to ${price.value.min}`]
    //         }

    //         const encoded = encodeURI(formPrice.price)
    //         submit(formPrice, encoded)
    //     }
    // }
    // function propertySubmit() {

    //     propertyType.value.forEach((item, index) => {
    //         if (index === 0) {
    //             formProperty.property_type = item
    //         } else {
    //             formProperty.property_type += '|'.concat(item)
    //         }
    //         const encoded = encodeURI(formProperty.property_type)
    //         submit(formProperty, encoded)
    //         filteredBy.value = [...propertyType.value]
    //     })
    // }
    return {
        locations,
        locationError,
        locationSubmit,
        price, priceError, statusCheckbox, status, propertyType, updateCheckbox, filteredBy
    }
}
