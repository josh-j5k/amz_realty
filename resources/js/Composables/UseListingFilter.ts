import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


export function useListingFilter() {
    const locationForm = useForm({
        location: ''
    })



    const locationError = ref(false)
    const priceError = ref(false)
    const statusForm = useForm({
        status: ''
    })
    const propertyType = ref(<string[]>[])
    const formProperty = useForm({
        property_type: ''
    })
    const price = ref(
        {
            min: '',
            max: '',
        }
    )
    const formPrice = useForm({
        price: ''
    })
    const searchQuery = location.search
    const statusCheckbox = ref([statusForm.status])
    function submit(form: any, formValue: string): void {
        const key = Object.keys(form)[0]
        if (searchQuery.length > 0) {
            form.get('/listings'.concat(searchQuery) + `&${key}=`.concat(formValue))
            return
        }
        form.get('/listings')
    }
    function updateCheckbox() {
        statusCheckbox.value = [statusForm.status]
        submit(statusForm, statusForm.status)
    }
    function locationSubmit() {
        if (locationForm.location === null || locationForm.location.length === 0) {
            locationError.value = true
            setTimeout(() => locationError.value = false, 4000)
            return
        }
        submit(locationForm, locationForm.location)
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
                formPrice.price = formPrice.price + 'min_'.concat(price.value.min)
            }
            if (price.value.max.length > 0 && price.value.min.length === 0) {
                formPrice.price = formPrice.price + 'max_'.concat(price.value.max)
            }
            if (price.value.max.length > 0 && price.value.min.length > 0) {
                formPrice.price = formPrice.price + 'min_'.concat(price.value.min) + '|' + 'max_'.concat(price.value.max)
            }
            const encoded = encodeURI(formPrice.price)
            submit(formPrice, encoded)
        }
    }
    function propertySubmit() {
        propertyType.value.forEach((item, index) => {
            if (index === 0) {
                formProperty.property_type = item
            } else {
                formProperty.property_type += '|'.concat(item)
            }
            const encoded = encodeURI(formProperty.property_type)
            submit(formProperty, encoded)
        })
    }
    return {
        locationForm,
        locationError,
        locationSubmit,
        price, priceError, priceSubmit, statusCheckbox, statusForm, propertySubmit, propertyType, updateCheckbox,
    }
}
