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


    function priceSubmit() {
        if (priceValidate()) {

            if (price.value.min.length > 0 && price.value.max.length === 0) {
                submit(form, 'price', 'over'.concat(price.value.min))
                // filteredBy.value = [...'over '.concat(price.value.min)]
            }
            if (price.value.max.length > 0 && price.value.min.length === 0) {
                submit(form, 'price', 'under'.concat(price.value.max))
            }
            if (price.value.max.length > 0 && price.value.min.length > 0) {
                submit(form, 'price', 'over'.concat(price.value.min) + '|' + 'under'.concat(price.value.max))
            }

        }
    }
    function propertySubmit() {

        let property = ''
        propertyType.value.forEach((item, index) => {
            if (index === 0) {
                property = item
                submit(form, 'property_type', property)
            } else {
                property += '|'.concat(item)
                submit(form, 'property_type', property)
            }

        })
    }
    console.log(Object.values(form));

    return {
        locations,
        locationError,
        locationSubmit,
        price, priceError, statusCheckbox, status, propertyType, updateCheckbox, form, priceSubmit, propertySubmit
    }
}
