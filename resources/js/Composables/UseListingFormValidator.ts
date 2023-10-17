import { ref } from 'vue';

export function useListingFormValidator() {
    const formErrors = ref(
        {
            fileError: false,
            titleError: false,
            priceError: false,
            locationError: false,
            descriptionError: false,
            propertyTypeError: false
        }
    )
    const formValid = ref(
        {
            title: false,
            file: false,
            price: false,
            location: false,
            description: false,
            property_type: false
        }
    )
    function validation(title: string, description: string, property_type: string, price: string | number, property_status: string, location: string): void {

        if (title === '') {
            formErrors.value.titleError = true
        } else {
            formValid.value.title = true
        }
        if (description === '') {
            formErrors.value.descriptionError = true
        } else {
            formValid.value.description = true
        }
        if (property_type === '') {
            formErrors.value.propertyTypeError = true
        } else {
            formValid.value.property_type = true
        }
        if (location === '') {
            formErrors.value.locationError = true
        } else {
            formValid.value.location = true
        }
        if (price === '') {
            const intPrice = parseInt(price)
            if (isNaN(intPrice)) {
                formErrors.value.priceError = true
            } else {
                formValid.value.price = true
            }
        }
        // if (total.value === 0) {
        //     formErrors.value.fileError = true
        // } else {
        //     formValid.value.file = true
        // }

    }
    function valid(title: string, description: string, property_type: string, price: string | number, property_status: string, location: string): boolean {
        validation(title, description, property_type, price, property_status, location)
        if (formValid.value.description === true && formValid.value.location === true && formValid.value.price === true && formValid.value.title === true && formValid.value.property_type === true) {
            return true
        } else {
            setTimeout(() => {
                formErrors.value.descriptionError = false
                // formErrors.value.fileError = false
                formErrors.value.locationError = false
                formErrors.value.priceError = false
                formErrors.value.titleError = false
                formErrors.value.propertyTypeError = false
            }, 5000)
            return false
        }

    }
    return { valid, formErrors }
}