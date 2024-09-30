import { router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import { type form } from '@/types/listings';


const form = reactive(<form>{

})

const locations = ref('')
const locationError = ref(false)
const priceError = ref(false)
const status = ref('any')
const propertyType = ref(<string[]>[])

const price = ref(<{ min: string, max: string }>{})

type price = {
    min: string | null,
    max: string | null
}
const statusCheckbox = ref([status.value])
export function useListingFilter() {

    function setInputsValues(location: string | null, Status: string, fPrice: price, property: string[]) {
        if (location !== null) {
            locations.value = location
            form.location = location
        }
        if (Status !== 'any') {
            form.status = Status
        }

        if (fPrice.min && fPrice.min.length > 0 && fPrice.max === null) {
            form.price = 'over'.concat(fPrice.min)
            price.value.min = fPrice.min

        } else if (fPrice.min === null && fPrice.max && fPrice.max.length > 0) {
            form.price = 'under'.concat(fPrice.max)
            price.value.max = fPrice.max
        } else if (fPrice.min && fPrice.min.length > 0 && fPrice.max && fPrice.max.length > 0) {
            form.price = 'over'.concat(fPrice.min) + '|' + 'under'.concat(fPrice.max)
            price.value.max = fPrice.max
            price.value.min = fPrice.min
        }


        if (property.length > 0) {
            property.forEach((item, index) => {
                if (index === 0) {
                    form.property_type = item

                } else {
                    form.property_type += '|'.concat(item)

                }

            })
        }

        status.value = Status
        statusCheckbox.value = [Status]
        propertyType.value = property

    }
    function submit(input: any, key: string, value: string): void {
        input[key] = value
        router.get('/listings', input)

    }
    function updateCheckbox() {
        statusCheckbox.value = [status.value]
        submit(form, 'status', status.value)
    }
    function locationSubmit() {
        if (locations === null || locations.value.length === 0) {
            locationError.value = true
            setTimeout(() => locationError.value = false, 4000)
            return
        }
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

    return {
        locations,
        locationError,
        locationSubmit,
        price, priceError, statusCheckbox, status, propertyType, updateCheckbox, form, priceSubmit, propertySubmit,
        setInputsValues
    }
}
